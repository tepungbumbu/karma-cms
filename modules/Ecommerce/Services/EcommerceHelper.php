<?php

namespace Karma\Ecommerce\Services;

class EcommerceHelper
{
    /**
     * Format currency to IDR
     */
    public static function formatPrice($amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    /**
     * Format date to Indonesian format
     */
    public static function formatDate($date): string
    {
        return \Carbon\Carbon::parse($date)->translatedFormat('d F Y');
    }

    /**
     * Calculate 11% PPN (VAT)
     */
    public static function calculateTax($subtotal): float
    {
        return $subtotal * 0.11;
    }
}
