@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-gray-800 rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">Create New Challenge</h1>
        <form action="{{ route('challenges.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-300 mb-2">Challenge Title</label>
                <input type="text" id="title" name="title" class="w-full px-3 py-2 bg-gray-700 text-white rounded" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-300 mb-2">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 bg-gray-700 text-white rounded" required></textarea>
            </div>
            <div class="mb-4">
                <label for="difficulty" class="block text-gray-300 mb-2">Difficulty</label>
                <select id="difficulty" name="difficulty" class="w-full px-3 py-2 bg-gray-700 text-white rounded" required>
                    <option value="easy">Easy</option>
                    <option value="medium">Medium</option>
                    <option value="hard">Hard</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="points" class="block text-gray-300 mb-2">Points</label>
                <input type="number" id="points" name="points" class="w-full px-3 py-2 bg-gray-700 text-white rounded" required>
            </div>
            <div class="mb-4">
                <label for="category" class="block text-gray-300 mb-2">Category</label>
                <input type="text" id="category" name="category" class="w-full px-3 py-2 bg-gray-700 text-white rounded" required>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Create Challenge
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
