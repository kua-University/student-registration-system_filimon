@extends('layouts.app')

@section('content')
    <body class="bg-gray-900 text-white font-sans antialiased">

        <!-- Header Section -->
        <header class="bg-gray-800 py-6 shadow-lg">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div class="logo">
                    <h1 class="text-3xl font-bold text-indigo-500">EduCourses</h1>
                </div>
                <nav class="nav">
                    <ul class="flex space-x-6">
                        <li><a href="{{ route('login') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Login</a></li>
                        <li><a href="{{ route('register') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Register</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Main Section -->
        <main class="py-16">
            <div class="container mx-auto px-6">
                <section class="intro text-center mb-16">
                    <h2 class="text-4xl font-extrabold text-indigo-400 mb-4">Welcome to EduCourses</h2>
                    <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                        EduCourses is an online platform designed to connect students, teachers, and administrators for a seamless learning experience. Explore, enroll, and grow in your courses today!
                    </p>
                </section>

                <section class="roles grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Student Role -->
                    <div class="role-card bg-gray-800 p-8 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
                        <h3 class="text-2xl font-semibold text-indigo-400 mb-4">For Students</h3>
                        <p class="text-gray-300 mb-6">
                            Enroll in courses, track your progress, and view your grades.
                        </p>
                        <a href="{{ route('register') }}" class="text-indigo-500 hover:text-indigo-400 font-semibold transition duration-200">Get Started</a>
                    </div>
                    <!-- Teacher Role -->
                    <div class="role-card bg-gray-800 p-8 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
                        <h3 class="text-2xl font-semibold text-indigo-400 mb-4">For Teachers</h3>
                        <p class="text-gray-300 mb-6">
                            Manage your courses, approve student enrollments, and grade students.
                        </p>
                        <a href="{{ route('login') }}" class="text-indigo-500 hover:text-indigo-400 font-semibold transition duration-200">Log In</a>
                    </div>
                    <!-- Admin Role -->
                    <div class="role-card bg-gray-800 p-8 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
                        <h3 class="text-2xl font-semibold text-indigo-400 mb-4">For Admins</h3>
                        <p class="text-gray-300 mb-6">
                            Register teachers, create courses, and approve student registrations.
                        </p>
                        <a href="{{ route('login') }}" class="text-indigo-500 hover:text-indigo-400 font-semibold transition duration-200">Log In</a>
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
                        <!-- Updated route names for terms and privacy policy -->
                        <li><a href="{{ route('terms-and-conditions') }}" class="text-gray-400 hover:text-indigo-400 transition duration-200">Terms of Service</a></li>
                        <li><a href="{{ route('privacy-policy') }}" class="text-gray-400 hover:text-indigo-400 transition duration-200">Privacy Policy</a></li>
                    </ul>
                </nav>
            </div>
        </footer>

    </body>
@endsection
