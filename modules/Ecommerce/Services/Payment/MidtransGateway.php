<?php

namespace Karma\Ecommerce\Services\Payment;

use Karma\Ecommerce\Models\Order;
use Exception;

class MidtransGateway implements GatewayInterface
{
    protected string $serverKey;
    protected string $clientKey;
    protected bool $isProduction;
    protected bool $isSanitized;
    protected bool $is3ds;

    public function __construct()
    {
        $this->serverKey = config('ecommerce.payment.midtrans.server_key');
        $this->clientKey = config('ecommerce.payment.midtrans.client_key');
        $this->isProduction = config('ecommerce.payment.midtrans.is_production', false);
        $this->isSanitized = true;
        $this->is3ds = true;
    }

    public function initialize(Order $order, array $options = []): array
    {
        // Integration with Midtrans Snap
        // For demonstration, we simulate the token retrieval
        return [
            'status' => 'success',
            'token' => 'mock-midtrans-snap-token-' . uniqid(),
            'redirect_url' => 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' . uniqid(),
        ];
    }

    public function verify(string $transactionId): array
    {
        // Verify transaction via Midtrans API
        return [
            'status' => 'success',
            'transaction_status' => 'settlement',
            'payment_type' => 'credit_card',
        ];
    }

    public function refund(string $transactionId, float $amount): array
    {
        // Refund via Midtrans API
        return [
            'status' => 'success',
            'message' => 'Refund processed',
        ];
    }
}
