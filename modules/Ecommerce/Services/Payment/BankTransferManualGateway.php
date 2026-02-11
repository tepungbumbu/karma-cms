<?php

namespace Karma\Ecommerce\Services\Payment;

use Karma\Ecommerce\Models\Order;

class BankTransferManualGateway implements GatewayInterface
{
    public function initialize(Order $order, array $options = []): array
    {
        return [
            'status' => 'success',
            'instructions' => 'Please transfer to BCA 1234567890 a/n KarmaCMS',
            'payment_page' => route('ecommerce.checkout.manual_payment', $order->order_number),
        ];
    }

    public function verify(string $transactionId): array
    {
        // Manual verification by admin
        return [
            'status' => 'pending',
            'message' => 'Pending manual verification',
        ];
    }

    public function refund(string $transactionId, float $amount): array
    {
        return [
            'status' => 'success',
            'message' => 'Please refund manually and update order status',
        ];
    }
}
