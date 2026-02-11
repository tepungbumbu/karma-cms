<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee;">
        <h2 style="color: #2b3a4a;">Order Confirmation</h2>
        <p>Hi {{ $order->customer_name }},</p>
        <p>Thank you for your order <strong>#{{ $order->order_number }}</strong>. We have received your payment and are processing it.</p>
        
        <h3>Order Summary</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa;">
                    <th style="padding: 10px; text-align: left; border-bottom: 2px solid #dee2e6;">Item</th>
                    <th style="padding: 10px; text-align: center; border-bottom: 2px solid #dee2e6;">Qty</th>
                    <th style="padding: 10px; text-align: right; border-bottom: 2px solid #dee2e6;">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">{{ $item->name }}</td>
                    <td style="padding: 10px; text-align: center; border-bottom: 1px solid #dee2e6;">{{ $item->quantity }}</td>
                    <td style="padding: 10px; text-align: right; border-bottom: 1px solid #dee2e6;">{{ Karma\Ecommerce\Services\EcommerceHelper::formatPrice($item->total) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="padding: 10px; text-align: right; font-weight: bold;">Total</td>
                    <td style="padding: 10px; text-align: right; font-weight: bold;">{{ Karma\Ecommerce\Services\EcommerceHelper::formatPrice($order->total_amount) }}</td>
                </tr>
            </tfoot>
        </table>

        <p style="margin-top: 20px;">
            <strong>Shipping Address:</strong><br>
            {{ $order->shipping_address['address'] ?? 'N/A' }}
        </p>

        <p>You can track your order status in your dashboard.</p>
        <p>Regards,<br>KarmaCMS Team</p>
    </div>
</body>
</html>
