@extends('layouts.app')

@section('content')
    <body class="bg-gray-900 text-white font-sans antialiased">

        <!-- Header Section -->
        <header class="bg-gray-800 py-6 shadow-lg">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div class="logo">
                    <h1 class="text-3xl font-bold text-indigo-500">Update Registration Fee</h1>
                </div>
                <nav class="nav">
                    <ul class="flex space-x-6">
                        <li><a href="{{ route('admin.revenue') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Back to Total Revenue</a></li>
                        <li><a href="{{ route('logout') }}" class="text-lg text-gray-300 hover:text-indigo-400 transition duration-200">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Main Section -->
        <main class="py-16">
            <div class="container mx-auto px-6">

                <section class="max-w-3xl mx-auto mb-16">
                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">

                        <!-- Current Registration Fee -->
                        <div class="mb-4">
                            <p class="text-lg text-indigo-400">Current Registration Fee:</p>
                            <p class="text-3xl font-bold text-gray-300">${{ number_format($registrationFee->amount, 2) }}</p>
                        </div>

                        <!-- Update Form -->
                        <form action="{{ route('admin.update-registration-fee.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="registration_fee" class="text-indigo-400">New Registration Fee</label>
                                <input type="number" name="registration_fee" id="registration_fee" value="{{ old('registration_fee', $registrationFee->amount) }}" class="w-full px-4 py-2 mt-2 bg-gray-700 text-white rounded-md" required />
                            </div>
                            <button type="submit" class="bg-indigo-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-600 transition duration-200">Update Fee</button>
                        </form>

                    </div>
                </section>

            </div>
        </main>

    </body>
@endsection
