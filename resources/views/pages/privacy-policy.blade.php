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
                <section class="privacy-policy-content">
                    <h2 class="text-4xl font-extrabold text-indigo-400 mb-6 text-center">Privacy Policy</h2>

                    <p class="text-lg text-gray-300 mb-6 text-center">
                        At EduCourses, we are committed to protecting your privacy. This Privacy Policy outlines the information we collect, how it is used, and the steps we take to ensure your privacy is respected.
                    </p>

                    <div class="space-y-8">
                        <div>
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-2">1. Information We Collect</h3>
                            <p class="text-gray-300">
                                We collect personal information such as your name, email address, payment details, and other information necessary for registration and course enrollment. We may also collect non-personal information such as usage data, browser information, and IP addresses to improve our services.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-2">2. How We Use Your Information</h3>
                            <p class="text-gray-300">
                                Your personal information is used to create and manage your account, process payments, enroll you in courses, and communicate with you regarding your activities on the platform. We may also use your information to improve our services and send you promotional emails, if you have opted to receive them.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-2">3. Data Sharing</h3>
                            <p class="text-gray-300">
                                We do not sell, rent, or lease your personal information to third parties. However, we may share your data with trusted partners who assist us in operating our platform, such as payment processors or email service providers. These partners are required to keep your information confidential and use it only for the purpose of fulfilling their services.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-2">4. Data Security</h3>
                            <p class="text-gray-300">
                                We use industry-standard security measures to protect your personal information from unauthorized access, alteration, or disclosure. However, no method of transmission over the internet or method of electronic storage is completely secure, and we cannot guarantee the absolute security of your data.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-2">5. Cookies</h3>
                            <p class="text-gray-300">
                                Our website uses cookies to enhance your experience and track usage patterns. You may disable cookies in your browser settings, but this may affect your ability to use some features of our platform.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-2">6. Your Rights</h3>
                            <p class="text-gray-300">
                                You have the right to access, correct, and delete your personal information. If you wish to exercise any of these rights or have questions about the information we hold, please contact us at owner@example.com.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-2">7. Changes to This Privacy Policy</h3>
                            <p class="text-gray-300">
                                We reserve the right to update or modify this Privacy Policy at any time. Any changes will be posted on this page with an updated revision date. By continuing to use the platform after changes are made, you consent to the updated policy.
                            </p>
                        </div>

                        <div>
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-2">8. Contact Us</h3>
                            <p class="text-gray-300">
                                If you have any questions or concerns regarding this Privacy Policy, please contact us at owner@example.com.
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
                        <!-- Updated route names for terms and privacy policy -->
                        <li><a href="{{ route('terms-and-conditions') }}" class="text-gray-400 hover:text-indigo-400 transition duration-200">Terms of Service</a></li>
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-indigo-400 transition duration-200">Home</a></li>
                    </ul>
                </nav>
            </div>
        </footer>

    </body>
@endsection
