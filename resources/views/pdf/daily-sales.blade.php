<!DOCTYPE html>
<html>
<head>
    <title>Daily Sales</title>
</head>
<body>
    <h1>Daily Sales for {{ \Carbon\Carbon::today()->format('Y-m-d') }}</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->student->name }}</td>
                <td>{{ $order->total }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
