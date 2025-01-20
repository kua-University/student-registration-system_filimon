@extends('layouts.app')

@section('content')
    <body class="bg-gray-900 text-white font-sans antialiased">

        <!-- Header Section -->
        <header class="bg-gray-800 py-6 shadow-lg">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div class="logo">
                    <h1 class="text-3xl font-bold text-indigo-500">Confirm Deletion</h1>
                </div>
                <nav class="nav">
                    <ul class="flex space-x-6">
                        <!-- Back to Teachers link -->
                        <li><a href="{{ route('admin.teachers') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Back to Teachers</a></li>
                        <li><a href="{{ route('logout') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Main Section -->
        <main class="py-16">
            <div class="container mx-auto px-6">

                <!-- Confirm Teacher Deletion Form -->
                <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
                    <h2 class="text-2xl text-red-500">Are you sure you want to delete this teacher?</h2>
                    <p class="text-lg text-white mt-4">{{ $teacher->name }}</p>

                    <!-- Assigned Courses Section -->
                    <div class="mt-4">
                        <h3 class="text-lg font-bold text-white mb-2">Assigned Courses:</h3>
                        @if ($assignedCourses->isEmpty())
                            <p class="text-white">This teacher has no courses assigned.</p>
                        @else
                            <ul class="list-disc pl-5">
                                @foreach ($assignedCourses as $course)
                                    <li class="text-white">{{ $course->name }} ({{ $course->code }})</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <!-- Buttons Section -->
                    <div class="mt-6 flex justify-between">
                        <!-- Cancel Button -->
                        <a href="{{ route('admin.teachers') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-gray-700 transition duration-200">
                            Cancel
                        </a>

                        <!-- Confirm Deletion Form -->
                        <form action="{{ route('admin.delete-teacher', $teacher->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-red-700 transition duration-200">
                                Yes, Delete
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </main>

    </body>
@endsection
