<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication - CodeIt Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-300 flex items-center justify-center min-h-screen">
<div class="w-full max-w-md">
    <div class="bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold">Two-Factor Authentication</h2>
        </div>

        <form method="POST" action="{{ route('two-factor.login') }}">
             @csrf

            @if (session('status'))
            <div class="bg-green-500 text-white px-4 py-2 rounded mb-4" role="alert">
                {{ session('status') }}
            </div>
            @endif

            <p class="text-gray-400 mb-4 text-sm">Please confirm access to your account by entering the authentication code provided by your authenticator application.</p>

            <div class="mb-4">
                <label class="block text-gray-400 text-sm font-bold mb-2" for="code">
                    Authentication Code
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="code"
                       type="text"
                       name="code"
                       required
                       autofocus>
                 @error('code')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end mb-6">
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Verify
                </button>
            </div>
        </form>

        <hr class="my-6 border-gray-700">

        <form method="POST" action="{{ route('two-factor.login') }}">
             @csrf

            <p class="text-gray-400 mb-4 text-sm">Or confirm access to your account by entering one of your emergency recovery codes.</p>

            <div class="mb-4">
                <label class="block text-gray-400 text-sm font-bold mb-2" for="recovery_code">
                    Recovery Code
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="recovery_code"
                       type="text"
                       name="recovery_code">
                @error('recovery_code')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Verify
                </button>
            </div>
        </form>
    </div>
    <p class="text-center text-gray-500 text-xs">
        &copy;2024 CodeIt Academy. All rights reserved.
    </p>
</div>
</body>
</html>
