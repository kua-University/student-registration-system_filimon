@extends('layouts.app')

@section('content')
<body class="bg-gray-900 text-white font-sans antialiased">

    <!-- Header Section -->
    <header class="bg-gray-800 py-6 shadow-lg">
        <div class="container mx-auto flex justify-between items-center px-6">
            <div class="logo">
                <h1 class="text-3xl font-bold text-indigo-500">Student Dashboard</h1>
            </div>
            <nav class="nav">
                <ul class="flex space-x-6">
                    <li class="text-lg text-gray-300">Welcome, {{ Auth::user()->name }}</li>
                    <li><a href="{{ route('student.edit-profile') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Profile</a></li>
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

                <!-- Enrolled Courses Widget -->
                <div class="overview-widget bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 cursor-pointer transform hover:scale-110 w-full h-40" onclick="window.location='{{ route('student.enrolled-courses') }}'">
                    <h3 class="text-2xl font-semibold text-indigo-400 mb-4">Enrolled Courses</h3>
                    <p class="text-gray-300 text-3xl font-bold">{{ $enrolledCourses->count() ?? '0' }}</p>
                </div>

                <!-- Available Courses Widget -->
                <div class="overview-widget bg-gray-800 p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300 cursor-pointer transform hover:scale-110 w-full h-40" onclick="window.location='{{ route('student.available-courses') }}'">
                    <h3 class="text-2xl font-semibold text-indigo-400 mb-4">Available Courses</h3>
                    <p class="text-gray-300 text-3xl font-bold">{{ $availableCourses->count() ?? '0' }}</p>
                </div>

                <!-- Grades Widget -->
                <div class="overview-widget bg-gray-800 p-6 rounded-lg shadow-lg w-full h-40">
                    <h3 class="text-2xl font-semibold text-indigo-400 mb-4">My Grades</h3>
                    <p class="text-gray-300 text-3xl font-bold">
                        @if($averageGrade !== 'N/A')
                            {{ number_format($averageGrade, 2) }}%
                        @else
                            N/A
                        @endif
                    </p>
                </div>

            </section>

        </div>
    </main>

</body>
@endsection
