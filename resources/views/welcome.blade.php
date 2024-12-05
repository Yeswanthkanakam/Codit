<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeIt - Front-end Developer Challenges</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'codeit-green': '#9fef00',
                        'codeit-dark': '#111927',
                        'codeit-darker': '#0a0e17',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-codeit-dark text-gray-300 font-sans">
<nav class="bg-codeit-darker border-b border-gray-800">
    <div class="container mx-auto px-6 py-3 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-codeit-green text-3xl font-bold">CodeIt</a>
        <div class="space-x-6">
            @auth
            <!-- User is logged in, show name and logout dropdown -->
            <div class="relative inline-block text-left">
                <button class="hover:text-codeit-green flex items-center focus:outline-none" id="user-menu-button" aria-expanded="true" aria-haspopup="true">
                    {{ Auth::user()->name }}
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown -->
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 hidden" id="user-menu">
                    <a href="{{ route('logout') }}"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Script to toggle dropdown -->
            <script>
                document.getElementById('user-menu-button').addEventListener('click', function() {
                    const menu = document.getElementById('user-menu');
                    menu.classList.toggle('hidden');
                });
            </script>
            @else
            <!-- User is not logged in, show default links -->
            <a href="{{ route('challenges') }}" class="hover:text-codeit-green">Challenges</a>
            <a href="{{ route('leaderboard') }}" class="hover:text-codeit-green">Leaderboard</a>
            <a href="{{ route('pricing') }}" class="hover:text-codeit-green">Pricing</a>
            <a href="{{ route('login') }}" class="bg-codeit-green text-codeit-darker px-4 py-2 rounded-md hover:bg-opacity-80 transition duration-300">Sign In</a>
            @endauth
        </div>

    </div>
</nav>

<header class="py-20 text-center bg-codeit-darker">
    <h1 class="text-5xl font-bold mb-4">Welcome to <span class="text-codeit-green">CodeIt</span></h1>
    <p class="text-xl mb-8">Master Front-end Development through Interactive Challenges</p>
    <a href="{{ route('challenges') }}" class="bg-codeit-green text-codeit-darker px-6 py-3 rounded-md font-semibold hover:bg-opacity-80 transition duration-300">Start Coding</a>
</header>

<main class="container mx-auto py-12">
    <!-- Display session messages -->
    @if(session('error'))
    <div class=" bg-red-500 text-white p-4 rounded-md mb-4">
        {{ session('error') }}
    </div>
    @endif

    @if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded-md mb-4">
        {{ session('success') }}
    </div>
    @endif

    <section class="mb-12">
        <h2 class="text-3xl font-bold mb-6 text-center text-codeit-green">Latest Challenges</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredChallenges as $challenge)
            <div class="bg-codeit-darker p-6 rounded-lg border border-gray-800 hover:border-codeit-green transition duration-300">
                <h3 class="text-xl font-bold mb-2 text-codeit-green">{{ $challenge['title'] }}</h3>
                <p class="mb-4">{{ $challenge['description'] }}</p>
                <span class="bg-{{ $challenge['difficulty_color'] }}-900 text-{{ $challenge['difficulty_color'] }}-300 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">{{ $challenge['difficulty'] }}</span>
                <a href="{{ route('challenges.show', $challenge['id']) }}" class="text-codeit-green hover:underline mt-2 inline-block">Start Challenge →</a>
            </div>
            @endforeach
        </div>
    </section>

    <section class="mb-12">
        <h2 class="text-3xl font-bold mb-6 text-center text-codeit-green">Your Coding Progress</h2>
        <div class="bg-codeit-darker p-6 rounded-lg border border-gray-800">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Challenges Completed</h3>
                <span class="text-2xl font-bold text-codeit-green">{{ $completedChallenges }} / {{ $totalChallenges }}</span>
            </div>
            <div class="w-full bg-gray-800 rounded-full h-2.5">
                @if($totalChallenges > 0)
                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
                    <div class="bg-codeit-green h-2.5 rounded-full" style="width: {{ ($completedChallenges / $totalChallenges) * 100 }}%"></div>
                </div>
                <p>Completed {{ $completedChallenges }} out of {{ $totalChallenges }} challenges</p>
                @else
                <p>Completed 0 out of {{ $totalChallenges }} challenges</p>
                @endif
            </div>
        </div>
    </section>

    <section class="mb-12">
        <h2 class="text-3xl font-bold mb-6 text-center text-codeit-green">Front-end Skill Categories</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($skillCategories as $category)
            <a href="{{ route('challenges') }}" class="bg-codeit-darker p-4 rounded-lg border border-gray-800 text-center hover:border-codeit-green transition duration-300">
                <h3 class="font-bold">{{ $category['name'] }}</h3>
            </a>
            @endforeach
        </div>
    </section>

    <section>
        <h2 class="text-3xl font-bold mb-6 text-center text-codeit-green">Pricing Plans</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($pricingPlans as $plan)
            <div class="bg-codeit-darker p-6 rounded-lg border border-gray-800 hover:border-codeit-green transition duration-300">
                <h3 class="text-xl font-bold mb-2 text-codeit-green">{{ $plan['name'] }}</h3>
                <p class="text-3xl font-bold mb-4">${{ $plan['price'] }}<span class="text-sm font-normal">/month</span></p>
                <ul class="mb-6 space-y-2">
                    @foreach($plan['features'] as $feature)
                    <li>{{ $feature }}</li>
                    @endforeach
                </ul>
                <form action="{{ route('subscriptions.store') }}" class="block text-center bg-codeit-green text-codeit-darker px-4 py-2 rounded-md hover:bg-opacity-80 transition duration-300" method="POST">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $plan['id'] }}">
                    <button type="submit">
                        Choose Plan
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </section>
</main>

<footer class="bg-codeit-darker py-6 mt-12">
    <div class="container mx-auto px-6 text-center">
        <p>&copy; {{ date('Y') }} CodeIt. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
