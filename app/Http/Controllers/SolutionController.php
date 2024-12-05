<?php

namespace App\Http\Controllers;

use App\Models\Solution;
use Illuminate\Http\Request;

class SolutionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // Fetch all solutions along with the challenge and user relationships
        $solutions = Solution::with('user', 'challenge')->get();

        // Pass solutions to the view
        return view('dashboard.solutions.index', compact('solutions'));
    }
    public function show($id)
    {
        $solution = Solution::with('user', 'challenge')->findOrFail($id);
        return view('dashboard.solutions.show', compact('solution'));
    }
    public function updateStatus(Request $request, $id)
    {
        $solution = Solution::findOrFail($id);

        // Update the status based on the button clicked
        if ($request->input('action') === 'pass') {
            $solution->status = 'Passed';
        } elseif ($request->input('action') === 'fail') {
            $solution->status = 'Failed';
        }

        $solution->save();

        return redirect()->route('solutions.show', $solution->id)
            ->with('success', 'Solution status updated successfully.');
    }
}
