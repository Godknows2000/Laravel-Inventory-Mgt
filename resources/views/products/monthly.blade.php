<!DOCTYPE html>
<html>
<head>
    <title>Monthly Stocks</title>
</head>
<body>
    <h1>Monthly Stocks</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Month</th>
                <th>Total Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
            <tr>
                <td>{{ $stock->month }}</td>
                <td>{{ $stock->total_quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
