@extends('layouts.app')

@section('content')
    <body class="bg-gray-900 text-white font-sans antialiased">

        <!-- Header Section -->
        <header class="bg-gray-800 py-6 shadow-lg">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div class="logo">
                    <h1 class="text-3xl font-bold text-indigo-500">EduCourses</h1> <!-- Website Logo -->
                </div>
                <nav class="nav">
                    <ul class="flex space-x-6">
                        <li><a href="{{ route('home') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Home</a></li>
                        <li><a href="{{ route('login') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Login</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Main Section -->
        <main class="py-16">
            <div class="container mx-auto px-6 max-w-lg">
                <section class="register-form-section bg-gray-800 p-8 rounded-lg shadow-lg">
                    <h2 class="text-4xl font-extrabold text-indigo-400 mb-6 text-center">Create Your Account</h2>

                    <!-- Display error messages for any validation failures -->
                    @if ($errors->any())
                        <div class="mb-4 text-red-500">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST" class="space-y-6">
                        @csrf  <!-- CSRF token for security -->

                        <!-- Full Name -->
                        <div class="form-group">
                            <label for="full_name" class="form-label text-lg font-medium text-gray-300">Full Name</label>
                            <input type="text" id="full_name" name="full_name" class="w-full p-3 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter your full name" value="{{ old('full_name') }}" required>
                            @error('full_name')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email" class="form-label text-lg font-medium text-gray-300">Email Address</label>
                            <input type="email" id="email" name="email" class="w-full p-3 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Enter your email address" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password" class="form-label text-lg font-medium text-gray-300">Password</label>
                            <input type="password" id="password" name="password" class="w-full p-3 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Choose a password" required>
                            @error('password')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label text-lg font-medium text-gray-300">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-3 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Confirm your password" required>
                            @error('password_confirmation')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="w-full p-3 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition duration-200">Register</button>
                        </div>
                    </form>

                    <div class="already-registered-link text-center mt-4">
                        <p class="text-gray-400">Already have an account? <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300">Log in here</a></p>
                    </div>
                </section>
            </div>
        </main>

        <!-- Footer Section -->
        <footer class="bg-gray-800 py-6">
            <div class="container mx-auto px-6 flex flex-col items-center">
                <p class="text-sm text-gray-400 mb-4">© 2024 EduCourses. All Rights Reserved.</p>
                <nav class="footer-nav">
                    <ul class="flex space-x-6">
                        <li><a href="{{ route('terms-and-conditions') }}" class="text-gray-400 hover:text-indigo-400 transition duration-200">Terms of Service</a></li>
                        <li><a href="{{ route('privacy-policy') }}" class="text-gray-400 hover:text-indigo-400 transition duration-200">Privacy Policy</a></li>
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-indigo-400 transition duration-200">Home</a></li>
                    </ul>
                </nav>
            </div>
        </footer>

    </body>
@endsection
