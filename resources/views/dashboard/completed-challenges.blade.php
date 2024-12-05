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
        <h1 class="text-3xl font-bold">Completed Challenges</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($challengesWithCertificateStatus as $item)
        <div class="bg-gray-800 rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-2">{{ $item['challenge']->title }}</h2>
            <p class="text-sm text-gray-400 mb-4">Completed at: {{ $item['challenge']->pivot->created_at }}</p>
            @if($item['hasCertificate'])
            <p class="text-green-500 mb-4">Certificate Issued</p>
            @else
           <div class="flex">
               <form action="{{ route('completed-challenges.request-certificate', $item['challenge']) }}" method="POST">
                   @csrf
                   <button type="submit" class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">
                       Request Certificate ($20)
                   </button>
               </form>
               @endif
               <form action="{{ route('completed-challenges.request-certificate', $item['challenge']) }}" method="POST">
                   @csrf
                   <button type="submit" class="inline-block bg-blue-500 text-white px-4 ml-3 py-2 rounded hover:bg-blue-600 transition duration-200">
                       View Solutions ($10)
                   </button>
               </form>
           </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
