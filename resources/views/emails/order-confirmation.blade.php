<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <style>
        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>Your Order Has Been Confirmed</h1>
    <p>Hi {{ $order->user->name }},</p>
    <p>Your order for <strong>{{ $order->product->title }}</strong> has been approved and is ready for shipping.</p>
    <p>Order Details:</p>
    <ul>
        <li>Quantity: {{ $order->quantity }}</li>
        <li>Price per Item: €{{ number_format($order->price_per_item, 2) }}</li>
        <li>Total Price: €{{ number_format($order->total_price, 2) }}</li>
    </ul>
    <p>Shipping Address:</p>
    <ul>
        <li>City: {{ $order->city }}</li>
        <li>Street: {{ $order->street }}</li>
        <li>House: {{ $order->house }}</li>
    </ul>
    <p>Once you receive the item, please confirm receipt by clicking the button below:</p>
    <a href="{{ $confirmUrl }}" class="button">Confirm Received</a>
    <p>If the button doesn't work, copy and paste this link into your browser: {{ $confirmUrl }}</p>
    <p>Thank you for shopping with us!</p>
    <p>Best regards,<br>Your E-commerce Platform</p>
</body>
</html>