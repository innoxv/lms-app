<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md p-6">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold">LMS</h1>
        </div>
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white @error('email') border-red-500 @enderror" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-4">
                <label for="password" class="block text-sm font-medium">Password</label>
                <input type="password" name="password" id="password" class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white @error('password') border-red-500 @enderror" required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 mt-4">LOGIN</button>
            <p class="text-center text-sm mt-2">
                Don't have an account? <a href="{{ route('register.form') }}" class="text-blue-400 hover:underline">REGISTER</a>
            </p>
        </form>
    </div>
</body>
</html>