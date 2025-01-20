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
                        <!-- Back to Courses link -->
                        <li><a href="{{ route('admin.courses') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Back to Courses</a></li>
                        <li><a href="{{ route('logout') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Main Section -->
        <main class="py-16">
            <div class="container mx-auto px-6">

                <!-- Confirm Deletion Form -->
                <div class="bg-gray-800 p-8 rounded-lg shadow-lg">
                    <h2 class="text-2xl text-red-500">Are you sure you want to delete this course?</h2>
                    <p class="text-lg text-white mt-4">{{ $course->name }}</p>

                    <form action="{{ route('admin.delete-course', $course->id) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-red-700 transition duration-200">Delete Course</button>
                    </form>
                    <a href="{{ route('admin.courses') }}" class="text-blue-500 hover:text-blue-400 mt-4 block">Cancel</a>
                </div>

            </div>
        </main>

    </body>
@endsection
