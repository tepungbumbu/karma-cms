<?php

namespace Karma\Ecommerce\Services\Payment;

use Karma\Ecommerce\Models\Order;

interface GatewayInterface
{
    /**
     * Initialize payment and get redirect URL or custom response
     * 
     * @param Order $order
     * @param array $options
     * @return array
     */
    public function initialize(Order $order, array $options = []): array;

    /**
     * Verify payment status from gateway
     * 
     * @param string $transactionId
     * @return array
     */
    public function verify(string $transactionId): array;

    /**
     * Handle refund for a transaction
     * 
     * @param string $transactionId
     * @param float $amount
     * @return array
     */
    public function refund(string $transactionId, float $amount): array;
}
