<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .receipt {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .receipt-details {
            margin-bottom: 20px;
        }
        .receipt-details p {
            font-size: 16px;
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="receipt">
        <div class="receipt-header">
            <h1>Receipt</h1>
            <p>Payment Receipt for {{ $receipt->payment_intent_id }}</p>
        </div>

        <div class="receipt-details">
            <p><strong>Amount:</strong> ${{ number_format($receipt->amount, 2) }} {{ strtoupper($receipt->currency) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($receipt->status) }}</p>
            <p><strong>Email:</strong> {{ $receipt->receipt_email }}</p>
            <p><strong>Date:</strong> {{ $receipt->created_at->format('M d, Y') }}</p>
            <p><strong>Description:</strong> {{ $receipt->description ?? 'N/A' }}</p>
        </div>

        <div class="footer">
            <p>Thank you for your payment!</p>
        </div>
    </div>

</body>
</html>
