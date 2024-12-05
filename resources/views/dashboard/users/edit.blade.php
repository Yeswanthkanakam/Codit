@extends('layouts.master')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-3xl font-bold mb-6 text-center text-codeit-green">Edit User</h2>

    <div class="bg-gray-800 p-4 rounded-lg mb-8">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="text-gray-400 block mb-1" for="name">Name:</label>
                <input type="text" name="name" id="name" class="bg-gray-900 text-gray-200 p-2 rounded w-full" value="{{ $user->name }}">
            </div>

            <div class="mb-4">
                <label class="text-gray-400 block mb-1" for="email">Email:</label>
                <input type="email" name="email" id="email" class="bg-gray-900 text-gray-200 p-2 rounded w-full" value="{{ $user->email }}">
            </div>

            <div class="mb-4">
                <label class="text-gray-400 block mb-1" for="role">Role:</label>
                <select name="role" id="role" class="bg-gray-900 text-gray-200 p-2 rounded w-full">
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="text-gray-400 block mb-1" for="score">Score:</label>
                <input type="number" name="score" id="score" class="bg-gray-900 text-gray-200 p-2 rounded w-full" value="{{ $user->score }}">
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update User</button>
            </div>
        </form>

        <a href="{{ route('users.index') }}" class="text-blue-500 hover:underline mt-4 block">Back to All Users</a>
    </div>
</div>
@endsection
