<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Approved Product Request</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #1f2937;">
    <h2>Your product request list has been approved</h2>

    <p>Hello {{ $payload['customer_name'] }},</p>

    <p>Your product request has been reviewed and approved by the admin. Below is the final list and the message from the business team:</p>

    @if(!empty($payload['admin_reply']))
        <p><strong>Admin message:</strong> {{ $payload['admin_reply'] }}</p>
    @endif

    <p><strong>Phone:</strong> {{ $payload['phone'] }}</p>
    <p><strong>Location:</strong> {{ $payload['location'] }}</p>
    <p><strong>Submitted:</strong> {{ $payload['created_at'] }}</p>

    @if(!empty($payload['notes']))
        <p><strong>Your note:</strong> {{ $payload['notes'] }}</p>
    @endif

    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; margin-top: 16px;">
        <thead>
            <tr>
                <th align="left">Product</th>
                <th align="left">Cartons</th>
                <th align="left">Pieces</th>
                <th align="left">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payload['items'] as $item)
                <tr>
                    <td>{{ $item['product_name'] }}</td>
                    <td>{{ $item['cartons'] }}</td>
                    <td>{{ $item['pieces'] }}</td>
                    <td>TSh {{ number_format($item['total_price'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 16px;"><strong>Total amount:</strong> TSh {{ number_format($payload['total_amount'], 2) }}</p>
</body>
</html>
