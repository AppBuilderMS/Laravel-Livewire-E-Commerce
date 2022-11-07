<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Confirmation</title>
</head>
<body>

    <p>Hi {{$order->first_name}} {{$order->last_name}}</p>
    <p>Your order has been successfully placed.</p>

<table style="width: 600px; text-align: right">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
    </thead>

    <tbody>
        @foreach($order->orderItems as $item)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$item->product->name}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{currency()}}{{$item->price * $item->quantity}}</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="3" style="border-top: 1px solid #ccc"></td>
            <td style="font-size: 15px; font-weight: bold; border-top: 1px solid #ccc">subtotal: {{currency()}}{{$order->subtotal}}</td>
        </tr>

        <tr>
            <td colspan="3"></td>
            <td style="font-size: 15px; font-weight: bold;">Tax: {{currency()}}{{$order->tax}}</td>
        </tr>

        <tr>
            <td colspan="3"></td>
            <td style="font-size: 15px; font-weight: bold;">Free Shipping</td>
        </tr>

        <tr>
            <td colspan="3"></td>
            <td style="font-size: 15px; font-weight: bold;">Total: {{currency()}}{{$order->total}}</td>
        </tr>
    </tbody>
</table>

</body>
</html>
