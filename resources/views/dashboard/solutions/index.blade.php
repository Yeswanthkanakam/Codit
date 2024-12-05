@extends('layouts.master')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-3xl font-bold mb-6 text-center text-codeit-green">Challenge Solutions</h2>

        <div class="bg-gray-800 p-4 rounded-lg mb-8">
        <table class="min-w-full bg-gray-800">
            <thead>
            <tr>
                <th class="text-left py-2 text-gray-300">User</th>
                <th class="text-left py-2 text-gray-300">Challenge</th>
                <th class="text-left py-2 text-gray-300">Submitted At</th>
                <th class="text-left py-2 text-gray-300">Status</th>
                <th class="text-left py-2 text-gray-300">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($solutions as $solution)
            <tr class="border-b border-gray-700">
                <td class="py-2 text-gray-400">{{ $solution->user->name }}</td>
                <td class="py-2 text-gray-400">{{ $solution->challenge->title }}</td>
                <td class="py-2 text-gray-400">{{ $solution->submitted_at->format('Y-m-d H:i') }}</td>
                <td class="py-2">
                    @php
                    $statusClass = match($solution->status) {
                    'Pending' => 'bg-yellow-500',
                    'passed' => 'bg-green-500',
                    'Failed' => 'bg-red-500',
                    default => 'bg-gray-500',
                    };
                    @endphp
                    <span class="px-2 py-1 rounded {{ $statusClass }}">{{ $solution->status }}</span>
                </td>
                @if(Auth::user() && Auth::user()->role == 'admin')
                <td class="py-2">
                    <a href="{{ route('solutions.show', $solution->id) }}" class="text-blue-500 hover:underline">View Details</a>
                </td>
                @endif
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
