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
                    <option value="Easy">Easy</option>
                    <option value="Medium">Medium</option>
                    <option value="Hard">Hard</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="category_id" class="block text-gray-300 mb-2">Category</label>
                <select id="category_id" name="category_id" class="w-full px-3 py-2 bg-gray-700 text-white rounded" required>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="content" class="block text-gray-300 mb-2">Content</label>
                <textarea id="content" name="content" rows="6" class="w-full px-3 py-2 bg-gray-700 text-white rounded" required></textarea>
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
