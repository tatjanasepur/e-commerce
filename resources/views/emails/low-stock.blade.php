<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Low stock alert</title>
</head>
<body>
    <h2>Low stock alert</h2>

    <p>
        Product: <strong>{{ $product->name }}</strong>
    </p>

    <p>
        Current stock: <strong>{{ $product->stock_quantity }}</strong>
    </p>

    <p>
        Threshold: <strong>{{ config('shop.low_stock_threshold') }}</strong>
    </p>

    <hr>
    <p style="color:#666;">
        Dummy notification email (test task).
    </p>
</body>
</html>
