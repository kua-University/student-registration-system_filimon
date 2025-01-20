@extends('layouts.app')

@section('content')
<body class="bg-gray-900 text-white font-sans antialiased">

    <!-- Centering the container using flexbox -->
    <div class="flex justify-center items-center min-h-screen py-12">

        <!-- Receipt container with improved design -->
        <div class="bg-gray-800 p-8 rounded-lg shadow-lg transform transition duration-300 hover:scale-105">

            <!-- Title section with larger font size and bold color -->
            <h1 class="text-4xl font-extrabold text-indigo-500 mb-6 text-center">Payment Receipt</h1>

            <!-- Receipt details section -->
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-indigo-400">Receipt Details</h2>

                <div class="grid grid-cols-1 gap-4">
                    <p><strong class="text-lg">Amount Paid:</strong> ${{ number_format($receipt->amount, 2) }}</p>
                    <p><strong class="text-lg">Status:</strong> {{ ucfirst($receipt->status) }}</p>
                    <p><strong class="text-lg">Payment Description:</strong> {{ $receipt->description ?? 'N/A' }}</p>
                    <p><strong class="text-lg">Receipt Email:</strong> {{ $receipt->receipt_email }}</p>
                    <p><strong class="text-lg">Payment Intent ID:</strong> {{ $receipt->payment_intent_id }}</p>
                    <p><strong class="text-lg">Date:</strong> {{ \Carbon\Carbon::parse($receipt->created_at)->format('F j, Y, g:i a') }}</p>
                </div>
            </div>

            <!-- Button section with space between download and redirect buttons -->
            <div class="mt-6 flex justify-center space-x-6">
                <!-- Download Button -->
                <a href="{{ route('receipt.download', $receipt->id) }}" class="px-6 py-3 bg-indigo-500 text-white font-semibold rounded-lg hover:bg-indigo-600 transition duration-300 transform hover:scale-105">
                    Download PDF
                </a>

                <!-- Redirect to Dashboard -->
                <a href="{{ route('student.dashboard') }}" class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition duration-300 transform hover:scale-105">
                    Go to Dashboard
                </a>
            </div>
        </div>

    </div>

</body>
@endsection
