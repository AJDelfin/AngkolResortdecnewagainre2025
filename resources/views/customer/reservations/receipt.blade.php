<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
    <style>
        body { font-family: sans-serif; }
        .container { width: 80%; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .content { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Receipt</h1>
        </div>
        <div class="content">
            <p><strong>Reservation ID:</strong> {{ $reservation->id }}</p>
            <p><strong>Customer Name:</strong> {{ $reservation->user->name }}</p>
            <p><strong>Date:</strong> {{ $reservation->created_at->format('Y-m-d') }}</p>
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Down Payment</td>
                        <td>₱{{ number_format($reservation->down_payment, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
