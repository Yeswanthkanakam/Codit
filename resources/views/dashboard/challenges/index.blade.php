@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-8">
    @if (session('success'))
    <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    @if(Auth::user() && Auth::user()->role == 'admin')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Coding Challenges</h1>
        <a href="{{ route('challenges.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded inline-flex items-center">
            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Challenge
        </a>
    </div>
    @endif

    <!-- Filters Section -->
    <div class="mb-6 w-full">
        <form action="{{ route('challenges') }}" method="GET" class="flex flex-col md:flex-row md:space-x-4">
            <select name="difficulty" class="bg-gray-700 text-white px-4 py-2 rounded flex-1 mb-4 md:mb-0">
                <option value="">All Difficulties</option>
                <option value="easy" {{ request('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                <option value="medium" {{ request('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="hard" {{ request('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
            </select>

            <select name="category" class="bg-gray-700 text-white px-4 py-2 rounded flex-1 mb-4 md:mb-0">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
                </option>
                @endforeach
            </select>

            <select name="sort" class="bg-gray-700 text-white px-4 py-2 rounded flex-1 mb-4 md:mb-0">
                <option value="">Sort By Date</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Ascending</option>
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Descending</option>
            </select>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded flex-1 md:flex-none">
                Filter
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($challenges as $challenge)
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-2">{{ $challenge['title'] }}</h2>
            <p class="text-sm text-gray-400 mb-4">Difficulty: {{ $challenge['difficulty'] }}</p>
            <p class="text-gray-300 mb-4">{{ $challenge['description'] }}</p>
            <a href="{{ route('challenges.editor', $challenge['id']) }}" class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-200">
                Start Challenge
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
