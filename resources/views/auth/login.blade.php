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
                        <li><a href="{{ route('register') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Register</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Main Section -->
        <main class="py-16">
            <div class="container mx-auto px-6 max-w-lg">
                <section class="login-form-section bg-gray-800 p-8 rounded-lg shadow-lg">
                    <h2 class="text-4xl font-extrabold text-indigo-400 mb-6 text-center">Login to Your Account</h2>

                    <!-- Display error message if there are validation errors -->
                    @if ($errors->any())
                        <div class="mb-4 text-red-500">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf  <!-- CSRF token for security -->
                        
                        <!-- Email Input -->
                        <div class="form-group">
                            <label for="email" class="form-label text-lg font-medium text-gray-300">Email</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="w-full p-3 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                                placeholder="Enter your email" 
                                required 
                                value="{{ old('email') }}"
                                aria-describedby="emailHelp"
                            >
                        </div>

                        <!-- Password Input -->
                        <div class="form-group">
                            <label for="password" class="form-label text-lg font-medium text-gray-300">Password</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="w-full p-3 bg-gray-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                                placeholder="Enter your password" 
                                required
                                aria-describedby="passwordHelp"
                            >
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button 
                                type="submit" 
                                class="w-full p-3 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition duration-200"
                            >
                                Login
                            </button>
                        </div>
                    </form>

                    <!-- Register Link -->
                    <div class="register-link text-center mt-4">
                        <p class="text-gray-400">Don't have an account? 
                            <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300">Register here</a>
                        </p>
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
