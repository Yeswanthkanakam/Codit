<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\PricingPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $challenges = Challenge::with('solutions')->get();

        // Get the currently authenticated user
        $user = auth()->user();
        $currentPlan = auth()->user()->subscription()
            ->where('status', 'Active') // Adjust as needed for your status names
            ->first();
        // Fetch all pricing plans from the database
        $pricingPlans = PricingPlan::all()->map(function ($plan) {
            return [
                'id' => $plan->id,
                'name' => $plan->name,
                'price' => $plan->price,
                'features' => $plan->features,
            ];
        });
        $totalChallenges = Challenge::count();
        $completedChallenges = Auth::user()->completedChallenges()->count();

        return view('dashboard.home', compact('totalChallenges', 'completedChallenges','challenges','user','pricingPlans','currentPlan'));
    }
}
