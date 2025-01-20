@extends('layouts.app')

@section('content')
    <body class="bg-gray-900 text-white font-sans antialiased">

        <!-- Header Section -->
        <header class="bg-gray-800 py-6 shadow-lg">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div class="logo">
                    <h1 class="text-3xl font-bold text-indigo-500">Manage Courses</h1>
                </div>
                <nav class="nav">
                    <ul class="flex space-x-6">
                        <!-- Back to Dashboard link -->
                        <li><a href="{{ route('admin.dashboard') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Back to Dashboard</a></li>
                        <li><a href="{{ route('logout') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Main Section -->
        <main class="py-16">
            <div class="container mx-auto px-6">

                <!-- Create New Course Button -->
                <div class="mb-8 flex justify-end">
                    <a href="{{ route('admin.create-course') }}" class="bg-indigo-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-600 transition duration-200">Create New Course</a>
                </div>

                <!-- Courses Table -->
                <section class="max-w-6xl mx-auto mb-16">
                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg overflow-x-auto">
                        <table class="min-w-full table-auto text-left">
                            <thead>
                                <tr>
                                    <th class="text-indigo-400 py-3 px-6">Course Name</th>
                                    <th class="text-indigo-400 py-3 px-6">Course Code</th>
                                    <th class="text-indigo-400 py-3 px-6">Category</th>
                                    <th class="text-indigo-400 py-3 px-6">Credits</th>
                                    <th class="text-indigo-400 py-3 px-6">Description</th>
                                    <th class="text-indigo-400 py-3 px-6">Fee</th>
                                    <th class="text-indigo-400 py-3 px-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $course)
                                    <tr class="border-t border-gray-700">
                                        <td class="py-3 px-6">{{ $course->name }}</td>
                                        <td class="py-3 px-6">{{ $course->code }}</td>
                                        <td class="py-3 px-6">{{ $course->category }}</td>
                                        <td class="py-3 px-6">{{ $course->credits }}</td>
                                        <td class="py-3 px-6">{{ Str::limit($course->description, 50) }}</td>
                                        <td class="py-3 px-6">
                                            @if($course->courseFee)
                                                ${{ number_format($course->courseFee->amount, 2) }}
                                            @else
                                                Not set
                                            @endif
                                        </td>
                                        <td class="py-3 px-6">
                                            <a href="{{ route('admin.edit-course', $course->id) }}" class="text-yellow-500 hover:text-yellow-400 mr-4">Edit</a>
                                            <a href="{{ route('admin.destroy-course', $course->id) }}" class="text-red-500 hover:text-red-400">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>
        </main>

    </body>
@endsection
