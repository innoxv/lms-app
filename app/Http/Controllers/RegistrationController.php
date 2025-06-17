<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Lender;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegistrationController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'role' => ['required', 'in:lender,customer'],
            'first_name' => ['required', 'string', 'max:50'],
            'second_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:users,email', 'unique:lenders,email', 'unique:customers,email'],
            'phone' => ['required', 'string', 'max:15', 'unique:users,phone', 'unique:lenders,phone', 'unique:customers,phone'],
            'address' => ['required', 'string', 'max:255'],
            'dob' => ['required_if:role,customer', 'date'],
            'national_id' => ['required_if:role,customer', 'string', 'max:20'],
            'bank_account' => ['required_if:role,customer', 'string', 'max:50'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        DB::beginTransaction();

        try {
            Log::info('Starting registration for email: ' . $data['email']);
            $user = User::create([
                'user_name' => $data['first_name'] . ' ' . $data['second_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'status' => 'active',
            ]);

            if (!$user) {
                throw new \Exception('User creation failed');
            }

            Log::info('User created with ID: ' . $user->user_id);
            if ($data['role'] === 'lender') {
                Lender::create([
                    'name' => $data['first_name'] . ' ' . $data['second_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'address' => $data['address'],
                    'status' => 'active',
                    'registration_date' => now(),
                    'total_loans' => 0.00,
                    'average_interest_rate' => 0.00,
                    'user_id' => $user->user_id,
                ]);
                Log::info('Lender created for user ID: ' . $user->user_id);
            } else {
                Customer::create([
                    'name' => $data['first_name'] . ' ' . $data['second_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'dob' => $data['dob'],
                    'national_id' => $data['national_id'],
                    'address' => $data['address'],
                    'status' => 'active',
                    'registration_date' => now(),
                    'bank_account' => $data['bank_account'],
                    'user_id' => $user->user_id,
                ]);
                Log::info('Customer created for user ID: ' . $user->user_id);
            }

            DB::commit();
            Log::info('Transaction committed for user ID: ' . $user->user_id);

            Auth::login($user);
            Log::info('User logged in with ID: ' . $user->user_id);

            return redirect()->route('dashboard')->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Registration failed for email ' . ($data['email'] ?? 'unknown') . ': ' . $e->getMessage());
            return back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput();
        }
    }

    public function showLoginForm()
    {
        return view('auth.login'); // Updated to reflect new path: resources/views/auth/login.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}