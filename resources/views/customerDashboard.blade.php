<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>LMS - Customer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Customer Dashboard</h1>
        <p>Welcome, {{ Auth::user()->user_name }} (Role: {{ Auth::user()->role }})</p>

        <!-- Metrics -->
        <div class="grid grid-cols-1 gap-4 mb-6">
            <div class="bg-gray-800 p-4 rounded">
                <h2 class="text-lg font-semibold">Outstanding Balance</h2>
                <p class="text-2xl">0.00</p> <!-- Replace with dynamic data -->
            </div>
        </div>

        <!-- Loan Applications Section -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Loan Applications</h2>
            <table class="w-full bg-gray-800 rounded">
                <thead>
                    <tr>
                        <th class="p-2">Amount</th>
                        <th class="p-2">Status</th>
                        <th class="p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Populate with dynamic data -->
                    <tr><td colspan="3" class="p-2 text-center">No applications available</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Payment Tracking Section -->
        <div>
            <h2 class="text-xl font-semibold mb-2">Payment Tracking</h2>
            <table class="w-full bg-gray-800 rounded">
                <thead>
                    <tr>
                        <th class="p-2">Loan ID</th>
                        <th class="p-2">Amount Due</th>
                        <th class="p-2">Amount Paid</th>
                        <th class="p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Populate with dynamic data -->
                    <tr><td colspan="4" class="p-2 text-center">No payments available</td></tr>
                </tbody>
            </table>
        </div>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="text-blue-400 hover:underline">Logout</button>
        </form>
    </div>
</body>
</html>