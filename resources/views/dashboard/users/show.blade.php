@extends('layouts.master')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-3xl font-bold mb-6 text-center text-codeit-green">User Details</h2>

    <div class="bg-gray-800 p-4 rounded-lg mb-8">
        <p class="text-gray-400 mb-4">Name: <span class="text-codeit-green">{{ $user->name }}</span></p>
        <p class="text-gray-400 mb-4">Email: <span class="text-codeit-green">{{ $user->email }}</span></p>
        <p class="text-gray-400 mb-4">Role: <span class="text-codeit-green">{{ ucfirst($user->role) }}</span></p>
        <p class="text-gray-400 mb-4">Score: <span class="text-codeit-green">{{ $user->score }}</span></p>
        <p class="text-gray-400 mb-4">Joined At: <span class="text-codeit-green">{{ $user->created_at->format('Y-m-d') }}</span></p>

        <a href="{{ route('users.index') }}" class="text-blue-500 hover:underline">Back to All Users</a>
    </div>
</div>
@endsection
