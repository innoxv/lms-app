<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Register</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="centered-page">
    <div class="container2">
        <label class="header-label">LMS</label>
        <div class="content">
            <form method="POST" action="{{ route('register') }}" id="registrationForm" class="signupForm">
                @csrf
                <div>
                    <label for="role" class="block text-sm font-medium">Register as?</label>
                    <select name="role" id="role" class="p-2 bg-gray-800 border border-gray-700 rounded text-white" required>
                        <option value="lender">Lender</option>
                        <option value="customer">Customer</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex space-x-4">
                    <div class="w-1/2">
                        <label for="first_name" class="block text-sm font-medium">First Name</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white @error('first_name') border-red-500 @enderror" required>
                        @error('first_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-1/2">
                        <label for="second_name" class="block text-sm font-medium">Second Name</label>
                        <input type="text" name="second_name" id="second_name" value="{{ old('second_name') }}" class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white @error('second_name') border-red-500 @enderror" required>
                        @error('second_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex space-x-4">
                    <div class="w-1/2">
                        <label for="email" class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white @error('email') border-red-500 @enderror" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="w-1/2">
                        <label for="phone" class="block text-sm font-medium">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white @error('phone') border-red-500 @enderror" required>
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}" class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white @error('address') border-red-500 @enderror" required>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="customer-fields" style="display: none;">
                    <div class="flex space-x-4">
                        <div class="w-1/2">
                            <label for="dob" class="block text-sm font-medium">Date of Birth</label>
                            <input type="date" name="dob" id="dob" value="{{ old('dob') }}" class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white @error('dob') border-red-500 @enderror">
                            @error('dob')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-1/2">
                            <label for="national_id" class="block text-sm font-medium">National ID</label>
                            <input type="text" name="national_id" id="national_id" value="{{ old('national_id') }}" class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white @error('national_id') border-red-500 @enderror">
                            @error('national_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="bank_account" class="block text-sm font-medium">Bank Account</label>
                        <input type="text" name="bank_account" id="bank_account" value="{{ old('bank_account') }}" class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white @error('bank_account') border-red-500 @enderror">
                        @error('bank_account')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white @error('password') border-red-500 @enderror" required>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-2 bg-gray-800 border border-gray-700 rounded text-white">
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:transparent">REGISTER</button>
                <p class="alt" style="margin-top: .5em;">
                    Already have an account? <a href="{{ route('login') }}" class="text-blue-400 ">LOG IN</a>
                </p>
                @if (session('success'))
                    <p class="text-green-500 text-center mt-2">{{ session('success') }}</p>
                @endif
                @if ($errors->any())
                    <p class="text-red-500 text-center mt-2">{{ $errors->first() }}</p>
                @endif
            </form>
        </div>
    </div>
    <script>
        document.getElementById('role').addEventListener('change', function() {
            const customerFields = document.querySelector('.customer-fields');
            if (this.value === 'customer') {
                customerFields.style.display = 'block';
            } else {
                customerFields.style.display = 'none';
            }
        });

        // Trigger change event on page load to set initial state based on default value
        document.getElementById('role').dispatchEvent(new Event('change'));

        // Override form submission to remove hidden fields
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            const customerFields = document.querySelector('.customer-fields');
            if (customerFields.style.display === 'none') {
                const fieldsToRemove = ['dob', 'national_id', 'bank_account'];
                fieldsToRemove.forEach(fieldName => {
                    const input = document.querySelector(`input[name="${fieldName}"]`);
                    if (input) {
                        input.remove(); // Remove the input from the DOM to exclude it from submission
                    }
                });
            }
        });
    </script>
</body>
</html>