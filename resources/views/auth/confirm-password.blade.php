<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password - CodeIt Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-gray-300">
<div class="container mx-auto px-4 min-h-screen flex items-center justify-center">
    <div class="w-full md:w-2/3 lg:w-1/2">
        <div class="bg-gray-800 shadow-lg rounded-lg">
            <div class="bg-gray-700 px-4 py-3 border-b border-gray-600 rounded-t-lg">
                <h2 class="text-lg font-semibold text-green-400">Confirm Password</h2>
            </div>

            <div class="p-6">
                <p class="mb-4 text-gray-300">Please confirm your password before continuing.</p>

                <form method="POST" action="{{route('password.confirm')}}">
                    @csrf

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>

                        <input id="password" type="password"
                               class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md shadow-sm text-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500"
                               name="password" required autocomplete="current-password">

                        @error('password')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Confirm Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
