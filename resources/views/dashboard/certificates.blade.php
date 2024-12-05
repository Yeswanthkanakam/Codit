@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-8">
    @if(session('success'))
    <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">
        {{ session('error') }}
    </div>
    @endif
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Attained Certificates</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            There is no certificate paid for.
        </div>
        @foreach($Certificates as $item)
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            There is no certificate paid for.
        </div>
        @endforeach
    </div>
</div>
@endsection
