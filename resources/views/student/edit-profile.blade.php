@extends('layouts.app')

@section('content')
    <body class="bg-gray-900 text-white font-sans antialiased">

        <!-- Header Section -->
        <header class="bg-gray-800 py-6 shadow-lg">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div class="logo">
                    <h1 class="text-3xl font-bold text-indigo-500">Edit Profile</h1>
                </div>
                <nav class="nav">
                    <ul class="flex space-x-6">
                        <!-- Back to Dashboard link -->
                        <li><a href="{{ route('student.dashboard') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Back to Dashboard</a></li>
                        <li><a href="{{ route('logout') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Main Section -->
        <main class="py-16">
            <div class="container mx-auto px-6">

                <!-- Edit Profile Form -->
                <form action="{{ route('student.update-profile') }}" method="POST" class="bg-gray-800 p-8 rounded-lg shadow-lg">
                    @csrf
                    @method('PUT') <!-- Using PUT for updating resource -->
                    <div class="mb-4">
                        <label for="name" class="block text-lg text-gray-300">Full Name</label>
                        <input type="text" id="name" name="name" class="w-full p-3 rounded-lg bg-gray-700 text-white" value="{{ old('name', $student->name) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-lg text-gray-300">Email Address</label>
                        <input type="email" id="email" name="email" class="w-full p-3 rounded-lg bg-gray-700 text-white" value="{{ old('email', $student->email) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-lg text-gray-300">Password (Leave blank to keep current)</label>
                        <input type="password" id="password" name="password" class="w-full p-3 rounded-lg bg-gray-700 text-white">
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-lg text-gray-300">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-3 rounded-lg bg-gray-700 text-white">
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="bg-indigo-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-600 transition duration-200">Update Profile</button>
                    </div>
                </form>

            </div>
        </main>

    </body>
@endsection
