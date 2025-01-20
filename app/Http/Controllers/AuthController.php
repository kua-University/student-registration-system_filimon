<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class AuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login request
    public function login(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Redirect based on the user's role
            $user = Auth::user();
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'teacher':
                    return redirect()->route('teacher.dashboard');
                case 'student':
                    if (Payment::getPaymentStatus($user->id, 'registration') === 'completed') {
                        return redirect()->route('student.dashboard');
                    } else {
                        return redirect()->route('show.registration.payment');
                    }
                    
                default:
                    return redirect()->route('home');
            }
        }

        // If login fails, redirect back with an error
        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ])->withInput();  // This ensures that the previously entered input is retained
    }



    // Show the registration form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle registration request (only for students)
    public function register(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // Create a new user as a student
        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hashing the password
            'role' => 'student', // Assign the role as 'student'
        ]);

        Auth::login($user);

        // Redirect the user to the payment page
        return redirect()->route('show.registration.payment');
    }

    
    // Log out the user
    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
