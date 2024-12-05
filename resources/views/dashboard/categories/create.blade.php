@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-codeit-darker rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-codeit-green mb-6">Add New Category</h2>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-300 text-sm font-bold mb-2">Category Name</label>
                    <input type="text" name="name" id="name" class="w-full px-3 py-2 text-gray-300 bg-gray-800 rounded-md focus:outline-none focus:ring-2 focus:ring-codeit-green" required>
                </div>
                @error('name')
                <p class="text-red-500 text-xs italic mb-4">{{ $message }}</p>
                @enderror
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-codeit-green text-codeit-darker px-4 py-2 rounded-md hover:bg-opacity-80 transition duration-300">Add Category</button>
                    <a href="{{ route('categories.index') }}" class="text-gray-300 hover:text-codeit-green">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
