<?php

namespace App\Http\Controllers;

use App\Models\PricingPlan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'plan_id' => 'required|exists:pricing_plans,id',
        ]);

        $plan = PricingPlan::findOrFail($request->input('plan_id'));
        $user = Auth::user();

        // Check if the user already has an active subscription
        $activeSubscription = Subscription::where('user_id', $user->id)
            ->where('status', 'Active') // Change to match the enum value
            ->first();

        if ($activeSubscription) {
            return redirect()->back()->with('error', 'You already have an active subscription. Please cancel your existing subscription before creating a new one.');
        }

        // Set the status to 'Active' when creating a new subscription
        $status = 'Cancelled'; // Use the correct casing to match the enum definition

        // Create subscription record
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'status' => $status,
        ]);

        // Proceed to PayPal payment
        return redirect()->route('paypal.process', [
            'subscription_id' => $subscription->id,
            'amount' => $plan->price,
        ]);
    }


}
