@extends('layouts.app')

@section('content')
    <body class="bg-gray-900 text-white font-sans antialiased">

        <!-- Header Section -->
        <header class="bg-gray-800 py-6 shadow-lg">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div class="logo">
                    <h1 class="text-3xl font-bold text-indigo-500">Edit Course</h1>
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

                <!-- Edit Course Form -->
                <form action="{{ route('admin.update-course', $course->id) }}" method="POST" class="bg-gray-800 p-8 rounded-lg shadow-lg">
                    @csrf
                    @method('POST')
                    <div class="mb-4">
                        <label for="name" class="block text-lg text-gray-300">Course Name</label>
                        <input type="text" id="name" name="name" class="w-full p-3 rounded-lg bg-gray-700 text-white" value="{{ $course->name }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="code" class="block text-lg text-gray-300">Course Code</label>
                        <input type="text" id="code" name="code" class="w-full p-3 rounded-lg bg-gray-700 text-white" value="{{ $course->code }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="category" class="block text-lg text-gray-300">Category</label>
                        <input type="text" id="category" name="category" class="w-full p-3 rounded-lg bg-gray-700 text-white" value="{{ $course->category }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="credits" class="block text-lg text-gray-300">Credits</label>
                        <input type="number" id="credits" name="credits" class="w-full p-3 rounded-lg bg-gray-700 text-white" value="{{ $course->credits }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-lg text-gray-300">Description</label>
                        <textarea id="description" name="description" class="w-full p-3 rounded-lg bg-gray-700 text-white" rows="5" required>{{ $course->description }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="fee" class="block text-lg text-gray-300">Course Fee</label>
                        <input type="number" id="fee" name="fee" class="w-full p-3 rounded-lg bg-gray-700 text-white" value="{{ $course->courseFee->amount ?? '' }}" step="0.01" required>
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="bg-indigo-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-600 transition duration-200">Update Course</button>
                    </div>
                </form>

            </div>
        </main>

    </body>
@endsection
