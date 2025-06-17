<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>LMS Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold">Welcome to LMS Dashboard</h1>
        <p>You are logged in as {{ Auth::user()->user_name }} (Role: {{ Auth::user()->role }})</p>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="text-blue-400 hover:underline">Logout</button>
        </form>
    </div>
</body>
</html>