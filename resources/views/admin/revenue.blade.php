@extends('layouts.app')

@section('content')
    <body class="bg-gray-900 text-white font-sans antialiased">

        <!-- Header Section -->
        <header class="bg-gray-800 py-6 shadow-lg">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div class="logo">
                    <h1 class="text-3xl font-bold text-indigo-500">Total Revenue</h1>
                </div>
                <nav class="nav">
                    <ul class="flex space-x-6">
                        <li><a href="{{ route('admin.dashboard') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Back to Dashboard</a></li>
                        <li><a href="{{ route('logout') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Main Section -->
        <main class="py-16">
            <div class="container mx-auto px-6">

                <!-- Overview Widgets Section -->
                <section class="max-w-3xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-12 mb-16">

                    <!-- Total Course Payments Widget (no hover effect) -->
                    <div class="overview-widget bg-gray-800 p-6 rounded-lg shadow-lg w-full h-40">
                        <h3 class="text-2xl font-semibold text-indigo-400 mb-4">Total Course Payments</h3>
                        <p class="text-gray-300 text-3xl font-bold">${{ number_format($totalCoursePayments, 2) }}</p>
                    </div>

                    <!-- Total Registration Payments Widget (no hover effect) -->
                    <div class="overview-widget bg-gray-800 p-6 rounded-lg shadow-lg w-full h-40">
                        <h3 class="text-2xl font-semibold text-indigo-400 mb-4">Total Registration Payments</h3>
                        <p class="text-gray-300 text-3xl font-bold">${{ number_format($totalRegistrationPayments, 2) }}</p>
                    </div>

                </section>

                <!-- Registration Fee Widget -->
                <section class="max-w-2xl mx-auto mb-16">
                    <div class="overview-widget bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 cursor-pointer transform hover:scale-110 w-full h-40 flex items-center justify-center" onclick="window.location='{{ route('admin.update-registration-fee') }}'">
                        <div class="text-center">
                            <h3 class="text-2xl font-semibold text-indigo-400 mb-4">Registration Fee</h3>
                            <p class="text-gray-300 text-3xl font-bold">${{ number_format($registrationFee->amount, 2) }}</p>
                        </div>
                    </div>
                </section>


            </div>
        </main>

    </body>
@endsection
