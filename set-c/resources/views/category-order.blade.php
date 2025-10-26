<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HasOneThrough Result (Simplified)</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 50%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <h1>Category And Related Order Details</h1>
    <!-- <p><strong>Querying Category:</strong> {{ $category->name }} (ID: {{ $category->id }})</p> -->

    <hr>
    
    @if ($order)
        <p class="success">✅ Order Successfully Found via HasOneThrough Relationship!</p>

        <table>
            <thead>
                <tr>
                    <th>Data Field</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Order ID</strong></td>
                    <td>{{ $order->id }}</td>
                </tr>
                <tr>
                    <td><strong>Order Name</strong></td>
                    <td>{{ $order->name }}</td>
                </tr>
            </tbody>
        </table>
        
        <!-- <p style="margin-top: 20px; font-size: 0.9em;">
            *(Note: This is the primary Order record found by traversing Category -> Product -> Order.)*
        </p> -->
    @else
        <p class="error">❌ No Order found for this Category through the HasOneThrough relationship.</p>
    @endif

</body>
</html>