<!DOCTYPE html>
<html>
<head>
    <title>New Order Placed</title>
</head>
<body>
    <h1>New Order placed by: {{ $customer->name }}!</h1>
    <p>Here are the details:</p>
    <ul>
        <li><strong>Order ID:</strong> {{ $order->id }}</li>
        <li><strong>Customer Name:</strong> {{ $customer->name }}</li>
        <li><strong>Mobile Number:</strong> {{ $customer->mobile }}</li>
        <li><strong>Delivery Address:</strong> {{ $order->house_address }}, {{ $order->street_address }}, {{ $order->locality }}</li>
        <li><strong>Pincode:</strong> {{ $order->pincode }}</li>
        <li><strong>Total Amount:</strong> ₹{{ $order->total_amount }}</li>
        <li><strong>Products:</strong>
            <ul>
                @foreach ($products as $product)
                    <li>
                        {{ $product->product_name }}
                    </li>
                @endforeach
            </ul>
        </li>
    </ul>
</body>
</html>
