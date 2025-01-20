@extends('layouts.app')

@section('content')
    <body class="bg-gray-900 text-white font-sans antialiased">
        <!-- Header Section -->
        <header class="bg-gray-800 py-6 shadow-lg">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div class="logo">
                    <h1 class="text-3xl font-bold text-indigo-500">Manage Students</h1>
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
                <!-- Students Table -->
                <section class="max-w-6xl mx-auto mb-16">
                    <div class="bg-gray-800 p-6 rounded-lg shadow-lg overflow-x-auto">
                        <table class="min-w-full table-auto text-left">
                            <thead>
                                <tr>
                                    <th class="text-indigo-400 py-3 px-6">Student Name</th>
                                    <th class="text-indigo-400 py-3 px-6">Email</th>
                                    <th class="text-indigo-400 py-3 px-6">Enrolled Courses</th>
                                    <th class="text-indigo-400 py-3 px-6">Total Payment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    <tr class="border-t border-gray-700">
                                        <td class="py-3 px-6">{{ $student->name }}</td>
                                        <td class="py-3 px-6">{{ $student->email }}</td>
                                        <td class="py-3 px-6">
                                            @foreach($student->enrollments as $enrollment)
                                                @if(in_array($enrollment->status, ['approved', 'completed']))
                                                    <span class="block 
                                                        {{ $enrollment->status == 'completed' ? 'text-green-500 font-bold' : '' }}">
                                                        {{ $enrollment->course->name }} ({{ $enrollment->course->code }})
                                                    </span>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="py-3 px-6">
                                            @php
                                                $totalPayment = $student->payments->sum('amount'); // Sum completed payments
                                            @endphp
                                            ${{ number_format($totalPayment, 2) }}
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
