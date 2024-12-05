
@extends('layouts.master')

@section('content')


        <!-- Main Dashboard Area -->
        <main class="flex-grow p-8">
            <h1 class="text-3xl font-bold mb-8">DASHBOARD</h1>

            @if(auth()->user()->two_factor_secret && !auth()->user()->two_factor_confirmed_at)
            <div class="bg-gray-800 p-4 rounded-lg">
                <h2 class="text-xl font-bold mb-4">Two-Factor Authentication Setup</h2>
                <p class="mb-4">Scan this QR code with your authenticator application or enter the setup key manually:</p>

                @php
                $google2fa = app('pragmarx.google2fa');
                $qrCodeUrl = $google2fa->getQRCodeUrl(
                config('app.name'),
                auth()->user()->email,
                decrypt(auth()->user()->two_factor_secret)
                );
                @endphp

                <div class="mb-4">
                    <div id="qrcode"></div>
                </div>
                @if(!auth()->user()->two_factor_confirmed_at)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                    <p class="font-bold">MFA is not confirmed yet!</p>
                    <p>Please scan the QR code and enter a verification code to confirm MFA.</p>
                </div>
                @endif

                @if(session('status') == 'two-factor-authentication-enabled')
                <div class="bg-green-500 text-white px-4 py-2 rounded-lg mb-4">
                    Two-factor authentication has been enabled.
                </div>
                @endif

                @if(session('status') == 'two-factor-authentication-disabled')
                <div class="bg-red-500 text-white px-4 py-2 rounded-lg mb-4">
                    Two-factor authentication has been disabled.
                </div>
                @endif
                <p class="mt-4 mb-2">Manual Setup Key:</p>
                <p class="font-mono bg-gray-700 p-2 rounded mb-4">{{ decrypt(auth()->user()->two_factor_secret) }}</p>

                <form method="POST" action="{{ route('two-factor.confirm') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="code" class="block text-sm font-medium text-gray-400">Verification Code</label>
                        <input type="text" name="code" id="code" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Confirm & Enable
                    </button>
                </form>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var qr = qrcode(0, 'M');
                    qr.addData("{{ $qrCodeUrl }}");
                    qr.make();
                    document.getElementById('qrcode').innerHTML = qr.createImgTag(5, 10);
                });
            </script>

            @endif

            @if(auth()->user()->two_factor_confirmed_at)
            <div class="bg-gray-800 p-4 rounded-lg mb-8">
                <h2 class="text-xl font-bold mb-4">Two-Factor Authentication Recovery Codes</h2>
                <p class="mt-4 mb-2">Please store these recovery codes in a secure location:</p>
                <ul class="list-disc list-inside mb-4">
                    @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes)) as $code)
                    <li>{{ $code }}</li>
                    @endforeach
                </ul>
            </div>
            @endif


            <div class="bg-gray-800 p-4 rounded-lg mb-8 mt-3">
                <h2 class="text-xl font-bold mb-4">Challenges List</h2>
                <table class="w-full">
                    <thead>
                    <tr>
                        <th class="text-left py-2">Name</th>
                        <th class="text-left py-2">Difficulty</th>
                        <th class="text-left py-2">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($challenges as $challenge)
                    <tr>
                        <td class="py-2">{{ $challenge->title }}</td>

                        <td class="py-2">
                            @php
                            $colorClass = match($challenge->difficulty) {
                            'Medium' => 'bg-green-500',
                            'Hard' => 'bg-blue-500',
                            'Easy' => 'bg-yellow-500',
                            'Advanced' => 'bg-red-500',
                            default => 'bg-gray-500'
                            };
                            @endphp
                            <span class="{{ $colorClass }} text-black px-2 py-1 rounded text-xs">{{ $challenge->difficulty }}</span>
                        </td>
                        <td class="py-2">
                            @php
                            // Check if the user has submitted a solution for this challenge
                            $userSubmittedSolution = $challenge->solutions->where('user_id', $user->id)->first();
                            @endphp
                            @if(!$userSubmittedSolution)
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded text-sm"><a href="{{ route('challenges.editor', $challenge['id']) }}"> Start</a> </button>
                            @elseif($userSubmittedSolution->status == 'completed')
                            <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded text-sm">Review</button>
                            @else
                            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-1 rounded text-sm">Done</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>



            <!-- Weekly Streak -->
            <div class="bg-gray-800 p-4 rounded-lg mb-8">
                <h2 class="text-xl font-bold mb-4">Your Progress<span class="bg-yellow-500 text-black px-2 py-1 rounded text-xs">BETA</span></h2>
                <p class="text-4xl font-bold">{{ $completedChallenges }} <span class="text-sm font-normal">/{{ $totalChallenges }} challenges</span></p>
                <p>This Week</p>

                <!-- Progress Bar -->
                @if($totalChallenges > 0)
                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
                    <div class="bg-codeit-green h-2.5 rounded-full" style="width: {{ ($completedChallenges / $totalChallenges) * 100 }}%"></div>
                </div>
                <p>Completed {{ $completedChallenges }} out of {{ $totalChallenges }} challenges</p>
                @else
                <p>Completed 0 out of {{ $totalChallenges }} challenges</p>
                @endif
            </div>



            @if(Session::has('success'))
            <div class="bg-green-500 text-white px-4 py-2 rounded-lg mb-4">{{ Session::get('success') }}</div>
            @endif
            @if(Session::has('error'))
            <div class="bg-red-500 text-white px-4 py-2 rounded-lg mb-4">{{ Session::get('error') }}</div>
            @endif

            <!-- My Plan -->
            <!-- My Plan -->
            <div class="bg-gray-800 p-4 rounded-lg mb-8">
                <h2 class="text-xl font-bold mb-4">My Plan</h2>

                @if($currentPlan && isset($currentPlan['plan'])) <!-- Check if the user has a current plan -->
                <p class="text-lg text-gray-300 mb-2">Current Plan: <strong class="text-codeit-green">{{ $currentPlan['plan']['name'] }}</strong></p>
                <p class="text-lg text-gray-300 mb-4">Price: <strong>${{ $currentPlan['plan']['price'] }}</strong> / month</p>
                <ul class="mb-4 space-y-2">
                    <li class="text-gray-300">Features:</li>
                    @if (isset($currentPlan['plan']['features']) && is_array($currentPlan['plan']['features'])) <!-- Check if features exist -->
                    @foreach($currentPlan['plan']['features'] as $feature)
                    <li class="text-gray-400">- {{ $feature }}</li>
                    @endforeach
                    @else
                    <li class="text-gray-400">No features available.</li> <!-- Handle no features -->
                    @endif
                </ul>
                <a href="{{ route('processTransaction', ['amount' => $currentPlan['plan']['price']]) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded inline-block">Upgrade Plan</a>
                @else
                <p class="text-lg text-gray-300 mb-4">You currently have no active subscription.</p>
                <h3 class="text-lg text-gray-300 mb-2">Choose a Plan:</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4"> <!-- Grid for displaying available plans -->
                    @foreach($pricingPlans as $plan)
                    <div class="bg-codeit-darker p-4 rounded-lg border border-gray-800 hover:border-codeit-green transition duration-300">
                        <h4 class="text-xl font-bold text-codeit-green">{{ $plan['name'] }}</h4>
                        <p class="text-3xl font-bold mb-2">${{ $plan['price'] }}<span class="text-sm font-normal">/month</span></p>
                        <ul class="mb-2 space-y-1">
                            @if(isset($plan['features']) && is_array($plan['features'])) <!-- Ensure features exist -->
                            @foreach($plan['features'] as $feature)
                            <li class="text-gray-400">- {{ $feature }}</li>
                            @endforeach
                            @else
                            <li class="text-gray-400">No features available.</li> <!-- Handle no features -->
                            @endif
                        </ul>
                        <form action="{{ route('subscriptions.store') }}" class="block text-center bg-codeit-green text-codeit-darker px-4 py-2 rounded-md hover:bg-opacity-80 transition duration-300" method="POST">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan['id'] }}">
                            <button type="submit" class="text-white">Choose Plan</button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>




        </main>

@endsection
