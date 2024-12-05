@extends('layouts.master')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-3xl font-bold mb-6 text-center text-codeit-green">Solution Details</h2>

    <div class="bg-gray-800 p-4 rounded-lg mb-8">
        <h3 class="text-xl font-bold mb-4 text-codeit-green">Challenge: {{ $solution->challenge->name }}</h3>
        <p class="text-gray-400 mb-4">Submitted by: {{ $solution->user->name }} on {{ $solution->submitted_at->format('Y-m-d H:i') }}</p>
        <p class="text-gray-400 mb-4">Status:
            <span class="px-2 py-1 rounded {{ $solution->status === 'Passed' ? 'bg-green-500' : ($solution->status === 'Failed' ? 'bg-red-500' : 'bg-blue-500') }}">
                {{ $solution->status }}
            </span>
        </p>

        <style>
            .wrap{
                text-wrap: auto;
            }
        </style>

        <div class="mb-4">
            <h4 class="text-lg font-bold text-codeit-green">HTML:</h4>
            <pre class="bg-gray-900 text-gray-200 p-4 rounded wrap">{{ $solution->html }}</pre>
        </div>

        <div class="mb-4">
            <h4 class="text-lg font-bold text-codeit-green">CSS:</h4>
            <pre class="bg-gray-900 text-gray-200 p-4 rounded">{{ $solution->css }}</pre>
        </div>

        <div class="mb-4">
            <h4 class="text-lg font-bold text-codeit-green">JavaScript:</h4>
            <pre class="bg-gray-900 text-gray-200 p-4 rounded">{{ $solution->javascript }}</pre>
        </div>
        <div class="mb-8 shadow-lg border rounded-lg overflow-hidden">
            <h4 class="text-lg font-bold text-codeit-green p-4">Run the Submitted Solution:</h4>

            <!-- Embed the iframe with the submitted code prefilled -->
            <iframe
                frameBorder="0"
                height="450px"
                srcdoc="
                <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Solution Preview</title>
                    <style>
                        {{ $solution->css }}
                    </style>
                </head>
                <body>
                    {{ $solution->html }}

                    <script>
                        {{ $solution->javascript }}
                    </script>
                </body>
                </html>
                "
                width="100%">
            </iframe>
        </div>

        @if($solution->feedback)
        <div class="mb-4">
            <h4 class="text-lg font-bold text-codeit-green">Feedback:</h4>
            <p class="text-gray-400">{{ $solution->feedback }}</p>
        </div>
        @endif

        <!-- Action Buttons for Admin -->
        <form action="{{ route('solutions.updateStatus', $solution->id) }}" method="POST" class="flex space-x-4">
            @csrf
            @method('PUT')

            <button type="submit" name="action" value="pass" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Mark as Passed
            </button>

            <button type="submit" name="action" value="fail" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Mark as Failed
            </button>
        </form>

        <div class="mt-4">
            <a href="{{ route('solutions.index') }}" class="text-blue-500 hover:underline">Back to All Solutions</a>
        </div>
    </div>
</div>
@endsection
