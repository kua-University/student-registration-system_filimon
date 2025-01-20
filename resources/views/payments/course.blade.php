@extends('layouts.app')

@section('content')
<body class="bg-gray-900 text-white font-sans antialiased">
    <div class="container mx-auto py-12">

        <h1 class="text-3xl font-bold text-indigo-500 mb-6">Complete Your Payment for {{ $course->name }}</h1>

        <form id="payment-form" class="space-y-6">

            <!-- Card Element -->
            <div>
                <label for="card-element" class="text-lg font-medium text-gray-300">Credit or Debit Card</label>
                <div id="card-element" class="mt-2 p-4 rounded-lg bg-gray-800 border border-gray-600">
                    <!-- A Stripe Element will be inserted here. -->
                </div>
                <p class="mt-2 text-sm text-gray-400">Please enter your card details.</p>
            </div>

            <!-- Error Message -->
            <div id="error-message" class="text-red-500 mt-4"></div>

            <!-- Submit Button -->
            <button id="submit" class="w-full px-4 py-3 bg-indigo-500 text-white font-semibold rounded-lg shadow-lg hover:bg-indigo-600 transition duration-300">
                Pay ${{ number_format($fee, 2) }}
            </button>
            
        </form>

    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Initialize Stripe
        var stripe = Stripe("{{ config('services.stripe.key') }}");
        var elements = stripe.elements();

        // Style customization for the Stripe Elements
        var style = {
            base: {
                color: '#fff',
                fontSize: '16px',
                fontFamily: '"Inter", sans-serif',
                fontSmoothing: 'antialiased',
                '::placeholder': {
                    color: '#888'
                },
            },
            invalid: {
                color: '#e74c3c',
                iconColor: '#e74c3c'
            }
        };

        // Create an instance of the card Element
        var card = elements.create("card", {style: style});

        // Add the card Element to the page
        card.mount("#card-element");

        // Handle form submission
        var form = document.getElementById("payment-form");
        form.addEventListener("submit", async function (event) {
            event.preventDefault();

            const {token, error} = await stripe.createToken(card);

            if (error) {
                document.getElementById("error-message").innerText = error.message;
            } else {
                const response = await fetch("{{ route('process.course.payment', $course->id) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({ token: token.id })
                });

                const data = await response.json();

                if (data.success) {
                    // Redirect to the student dashboard after successful payment
                    window.location.href = data.redirect_url;
                } else {
                    document.getElementById("error-message").innerText = data.error;
                }
            }
        });

    </script>
</body>
@endsection
