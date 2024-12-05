<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PricingPlan;

class SeedPricingPlans extends Command
{
    protected $signature = 'seed:pricing-plans';

    protected $description = 'Seed the pricing plans table with initial data';

    public function handle()
    {
        $plans = [
            [
                'name' => 'Basic',
                'price' => 9.99,
                'features' => [
                    'Access to all basic challenges',
                    '24/7 support',
                    'Progress tracking'
                ],
            ],
            [
                'name' => 'Pro',
                'price' => 19.99,
                'features' => [
                    'Access to all challenges',
                    'Priority support',
                    'Progress tracking',
                    'Code reviews',
                    'Monthly webinars'
                ],
            ],
            [
                'name' => 'Enterprise',
                'price' => 49.99,
                'features' => [
                    'Access to all challenges',
                    'Dedicated support',
                    'Progress tracking',
                    'Unlimited code reviews',
                    'Monthly webinars',
                    'Custom challenge creation',
                    'Team management tools'
                ],
            ],
        ];

        foreach ($plans as $plan) {
            PricingPlan::create($plan);
        }

        $this->info('Pricing plans seeded successfully!');
    }
}
