@extends('layouts.master')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-3xl font-bold mb-6 text-center text-codeit-green">User Management</h2>

    <div class="bg-gray-800 p-4 rounded-lg mb-8">
        <table class="min-w-full bg-gray-800">
            <thead>
            <tr>
                <th class="text-left py-2 text-gray-300">Name</th>
                <th class="text-left py-2 text-gray-300">Email</th>
                <th class="text-left py-2 text-gray-300">Role</th>
                <th class="text-left py-2 text-gray-300">Score</th>
                <th class="text-left py-2 text-gray-300">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr class="border-b border-gray-700">
                <td class="py-2 text-gray-400">{{ $user->name }}</td>
                <td class="py-2 text-gray-400">{{ $user->email }}</td>
                <td class="py-2 text-gray-400">{{ ucfirst($user->role) }}</td>
                <td class="py-2 text-gray-400">{{ $user->score }}</td>
                <td class="py-2">
                    <a href="{{ route('users.show', $user->id) }}" class="text-blue-500 hover:underline">View</a> |
                    <a href="{{ route('users.edit', $user->id) }}" class="text-green-500 hover:underline">Edit</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
