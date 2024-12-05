<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeIt Academy Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@heroicons/vue@2.0.18/dist/heroicons.min.js"></script>
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
<body class="bg-gray-900 text-gray-300">
<div class="flex flex-col h-screen">
    <!-- Top Navigation -->
    <nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <span class="text-xl font-bold"> <a href="{{url('/')}}">  CodeIt Academy </a></span>
            </div>
            <div class="flex items-center">
                <input type="text" placeholder="Search Academy" class="bg-gray-700 text-white px-4 py-2 rounded-lg">
                @if(!auth()->user()->two_factor_secret)
                <form method="POST" action="{{ url('user/two-factor-authentication') }}" class="mr-4 ml-4">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-300">Enable MFA</button>
                </form>
                @else
                <div class="flex flex-col space-y-4">
                    <div class="flex space-x-4">
                        <form method="POST" action="{{ url('user/two-factor-authentication') }}" class="mr-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-300">
                                Disable MFA
                            </button>
                        </form>
                    </div>
                </div>
                @endif


                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center">
                        <img src="{{ asset('images/user.png') }}" alt="User Avatar" class="h-8 w-8 rounded-full">
                        <span class="ml-2">{{ Auth::user()->name }}</span>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="flex-grow flex">
        <!-- Sidebar -->
        <aside class="bg-gray-800 w-64 p-4 hidden md:block">
            <div class="mb-8">
                <img src="{{ asset('images/user.png') }}" alt="User Avatar" class="h-20 w-20 rounded-full mx-auto mb-2">
                <h2 class="text-center font-bold">{{ Auth::user()->name }}</h2>
            </div>
            <nav>
                <h3 class="text-gray-500 font-bold mb-2">LEARN</h3>
                <a href="{{route('home')}}" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{route('challenges')}}" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Challenges
                </a>
                @if(Auth::user() && Auth::user()->role == 'admin')

                <a href="{{route('categories.index')}}" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Categories
                </a>
                @endif
                <h3 class="text-gray-500 font-bold mt-4 mb-2">MY ACHIEVEMENTS</h3>
                <a href="{{route('completed-challenges.index')}}" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Completed Challenges
                </a>
                <a href=" {{route('certificates')}}" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    My Certificates
                </a>
                @if(Auth::user() && Auth::user()->role == 'admin')

                <h3 class="text-gray-500 font-bold mt-4 mb-2">Management</h3>
                <a href=" {{route('solutions.index')}}" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Solutions
                </a>
                <a href=" {{route('users.index')}}" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Users
                </a>
                @endif
                <h3 class="text-gray-500 font-bold mt-4 mb-2">GET HELP</h3>
                <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-gray-700">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Help Center
                </a>

            </nav>
        </aside>



        @yield('content')

    </div>
</div>
</body>
</html>
