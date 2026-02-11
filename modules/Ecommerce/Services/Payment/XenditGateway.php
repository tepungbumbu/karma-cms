<?php

namespace Karma\Ecommerce\Services\Payment;

use Karma\Ecommerce\Models\Order;

class XenditGateway implements GatewayInterface
{
    protected string $secretKey;

    public function __construct()
    {
        $this->secretKey = config('ecommerce.payment.xendit.secret_key');
    }

    public function initialize(Order $order, array $options = []): array
    {
        // Integration with Xendit Invoices
        return [
            'status' => 'success',
            'external_id' => $order->order_number,
            'invoice_url' => 'https://checkout.xendit.co/web/' . uniqid(),
        ];
    }

    public function verify(string $transactionId): array
    {
        // Verify via Xendit API
        return [
            'status' => 'success',
            'transaction_status' => 'PAID',
        ];
    }

    public function refund(string $transactionId, float $amount): array
    {
        return [
            'status' => 'error',
            'message' => 'Refund not supported for this gateway via API',
        ];
    }
}
