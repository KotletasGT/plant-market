<!DOCTYPE html>
<html>
<head>
    <title>New Order Notification</title>
</head>
<body>
    <h1>New Order for Your Product</h1>
    <p>Hi Seller,</p>
    <p>You have a new order for your product: <strong>{{ $order->product->title }}</strong></p>
    <p>Order Details:</p>
    <ul>
        <li>Quantity: {{ $order->quantity }}</li>
        <li>Price per Item: €{{ number_format($order->price_per_item, 2) }}</li>
        <li>Total Price: €{{ number_format($order->total_price, 2) }}</li>
    </ul>
    <p>Buyer Shipping Details:</p>
    <ul>
        <li>City: {{ $order->city }}</li>
        <li>Street: {{ $order->street }}</li>
        <li>House: {{ $order->house }}</li>
    </ul>
    <p>Please prepare the item for shipping.</p>
    <p>Best regards,<br>Your E-commerce Platform</p>
</body>
</html>