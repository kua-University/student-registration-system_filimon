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
                        <li><a href="{{ route('register') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Register</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Main Section -->
        <main class="py-16">
            <div class="container mx-auto px-6">
                <section class="terms-content">
                    <h2 class="text-4xl font-extrabold text-indigo-400 mb-6 text-center">Terms of Service</h2>

                    <p class="text-lg text-gray-300 mb-6 text-center">
                        Welcome to EduCourses! These Terms of Service outline the rules and regulations for the use of our website and services.
                    </p>

                    <div class="space-y-8">
                        <div>
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-2">1. Acceptance of Terms</h3>
                            <p class="text-gray-300">
                                By using the EduCourses platform, you agree to abide by these Terms of Service. If you do not agree to these terms, please do not use the platform.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-2">2. User Accounts</h3>
                            <p class="text-gray-300">
                                Users must register to access certain features on EduCourses. You are responsible for maintaining the confidentiality of your account information and for all activities that occur under your account.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-2">3. Course Enrollment</h3>
                            <p class="text-gray-300">
                                Students can enroll in available courses by completing the registration and payment process. Course availability is subject to approval by the respective instructor and platform administrators.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-2">4. Payment Terms</h3>
                            <p class="text-gray-300">
                                Students must pay any required fees to enroll in courses or to use certain services on EduCourses. Payment details must be provided before completing the registration and enrollment processes.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-2">5. Content Ownership</h3>
                            <p class="text-gray-300">
                                All content provided on the EduCourses platform, including but not limited to courses, materials, and intellectual property, are owned by EduCourses or its licensors. Users may not reproduce, distribute, or modify content without permission.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-2">6. Privacy and Data Protection</h3>
                            <p class="text-gray-300">
                                EduCourses takes privacy seriously. We collect and use personal information as outlined in our Privacy Policy. Please review our Privacy Policy for more details on how we protect your data.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-2">7. Limitation of Liability</h3>
                            <p class="text-gray-300">
                                EduCourses is not liable for any direct, indirect, incidental, or consequential damages resulting from the use of our platform, including issues related to content accuracy, payment processing, or course enrollment.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-2">8. Changes to Terms</h3>
                            <p class="text-gray-300">
                                EduCourses reserves the right to modify these Terms of Service at any time. Users will be notified of any changes via email or through the platform itself.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-2">9. Governing Law</h3>
                            <p class="text-gray-300">
                                These Terms of Service shall be governed by and construed in accordance with the laws. Any disputes shall be resolved through binding arbitration.
                            </p>
                        </div>
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
                        <!-- Update links to use Laravel's route helper -->
                        <li><a href="{{ route('privacy-policy') }}" class="text-gray-400 hover:text-indigo-400 transition duration-200">Privacy Policy</a></li>
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-indigo-400 transition duration-200">Home</a></li>
                    </ul>
                </nav>
            </div>
        </footer>

    </body>
@endsection
