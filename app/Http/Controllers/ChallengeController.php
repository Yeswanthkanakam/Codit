<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Models\Challenge;
use App\Models\Category;
use App\Models\Solution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class ChallengeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $query = Challenge::with('category');

        // Filter by difficulty
        if ($request->has('difficulty') && $request->difficulty != '') {
            $query->where('difficulty', $request->difficulty);
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Sort by date
        if ($request->has('sort') && $request->sort != '') {
            $query->orderBy('created_at', $request->sort);
        }

        // Retrieve the filtered challenges
        $challenges = $query->get();

        // Fetch all categories for the filter dropdown
        $categories = Category::all();

        return view('dashboard.challenges.index', compact('challenges', 'categories'));
    }



    public function certificates()
    {
        $Certificates = Certificate::with('category')->get();
        return view('dashboard.certificates', compact('Certificates'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('dashboard.challenges.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'difficulty' => 'required|in:Easy,Medium,Hard',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
        ]);

        $challenge = new Challenge();
        $challenge->title = $validatedData['title'];
        $challenge->description = $validatedData['description'];
        $challenge->difficulty = $validatedData['difficulty'];
        $challenge->category_id = $validatedData['category_id'];
        $challenge->content = $validatedData['content'];
        $challenge->save();

        return redirect()->route('challenges')->with('success', 'Challenge created successfully!');
    }

    public function show()
    {
        $categories = Category::all();

        return view('dashboard.challenges.show', compact('categories'));
    }
    public function editor(Challenge $challenge)
    {
        return view('dashboard.challenges.editor', compact('challenge'));
    }

    public function submit(Request $request, Challenge $challenge)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'html' => 'required|string|max:50000',
            'css' => 'required|string|max:50000',
            'javascript' => 'required|string|max:50000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user has already submitted a solution for this challenge
        $existingSolution = Solution::where('user_id', $user->id)
            ->where('challenge_id', $challenge->id)
            ->first();

        if ($existingSolution) {
            // Update existing solution
            $existingSolution->update([
                'html' => $request->html,
                'css' => $request->css,
                'javascript' => $request->javascript,
                'submitted_at' => now(),
            ]);
            $solution = $existingSolution;
        } else {
            // Create new solution
            $solution = Solution::create([
                'user_id' => $user->id,
                'challenge_id' => $challenge->id,
                'html' => $request->html,
                'css' => $request->css,
                'javascript' => $request->javascript,
                'submitted_at' => now(),
            ]);
        }

        // Perform basic validation on the submitted code
        $validationResult = $this->validateSubmission($solution);

        // Update the solution status based on validation
        $solution->update([
            'status' => $validationResult['status'],
            'feedback' => $validationResult['feedback'],
        ]);

        // Update user's progress
        $this->updateUserProgress($user, $challenge);

        // Redirect back with appropriate message
        if ($validationResult['status'] === 'passed') {
            return redirect()->back()->with('success', 'Solution submitted successfully!');
        } else {
            return redirect()->back()->with('error', 'Solution submitted, but did not pass all validations. Please review the feedback and try again.');
        }
    }

    private function validateSubmission(Solution $solution)
    {
        // This is a basic validation. You might want to implement more sophisticated checks.
        $errors = [];

        // Check if HTML contains basic structure
        if (!preg_match('/<html.*>.*<\/html>/is', $solution->html)) {
            $errors[] = 'HTML must contain <html> tags.';
        }

        // Check if CSS is not empty
        if (empty(trim($solution->css))) {
            $errors[] = 'CSS should not be empty.';
        }

        // Check if JavaScript is not empty
        if (empty(trim($solution->javascript))) {
            $errors[] = 'JavaScript should not be empty.';
        }

        // You can add more specific checks based on the challenge requirements

        if (empty($errors)) {
            return [
                'status' => 'passed',
                'feedback' => 'All basic checks passed.',
            ];
        } else {
            return [
                'status' => 'failed',
                'feedback' => implode(' ', $errors),
            ];
        }
    }

    private function updateUserProgress($user, $challenge)
    {
        // Check if the user has completed this challenge
        $completedChallenge = $user->completedChallenges()->where('challenge_id', $challenge->id)->first();

        if (!$completedChallenge) {
            // If not completed, add it to completed challenges
            $user->completedChallenges()->attach($challenge->id, ['completed_at' => now()]);

            // Update user's total score
            $user->score += $challenge->points;
            $user->save();
        }
    }
}
