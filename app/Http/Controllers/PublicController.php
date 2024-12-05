<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Challenge;
use App\Models\PricingPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function index()
    {
        $featuredChallenges = Challenge::latest()->take(3)->get()->map(function ($challenge) {
            return [
                'id' => $challenge->id,
                'title' => $challenge->title,
                'description' => $challenge->description,
                'difficulty' => $challenge->difficulty,
                'difficulty_color' => $this->getDifficultyColor($challenge->difficulty),
            ];
        });

        $totalChallenges = Challenge::count();
        $completedChallenges = 0;

        if (Auth::check()) {
            $completedChallenges = Auth::user()->completedChallenges()->count();
        }

        $skillCategories = Category::all()->map(function ($category) {
            return [
                'name' => $category->name,
                'slug' => $category->slug,
            ];
        });

        $pricingPlans = PricingPlan::all()->map(function ($plan) {
            return [
                'id' => $plan->id,
                'name' => $plan->name,
                'price' => $plan->price,
                'features' => $plan->features,
            ];
        });

        return view('welcome', compact('featuredChallenges', 'totalChallenges', 'completedChallenges', 'skillCategories', 'pricingPlans'));
    }

    private function getDifficultyColor($difficulty)
    {
        switch (strtolower($difficulty)) {
            case 'easy':
                return 'green';
            case 'medium':
                return 'yellow';
            case 'hard':
                return 'red';
            default:
                return 'gray';
        }
    }
}
