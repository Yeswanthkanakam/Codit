@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4">{{ $challenge->title }}</h1>
    <p class="text-gray-600 mb-4">Difficulty: {{ $challenge->difficulty }}</p>
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-2">Challenge Description</h2>
        <p>{{ $challenge->description }}</p>
    </div>
    <div class="bg-gray-100 rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Code Editor</h2>
        <iframe
            frameBorder="0"
            height="450px"
            src="https://onecompiler.com/embed/html"
            width="100%"
        ></iframe>
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Submit Your Solution</h2>
            <form action="{{ route('challenges.submit', $challenge->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="html" class="block text-sm font-medium text-gray-700 mb-2">HTML:</label>
                    <textarea id="html" name="html" rows="10" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="css" class="block text-sm font-medium text-gray-700 mb-2">CSS:</label>
                    <textarea id="css" name="css" rows="10" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="javascript" class="block text-sm font-medium text-gray-700 mb-2">JavaScript:</label>
                    <textarea id="javascript" name="javascript" rows="10" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" required></textarea>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Submit Solution
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
@endsection
