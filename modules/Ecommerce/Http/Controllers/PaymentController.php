<?php

namespace Karma\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use Karma\Ecommerce\Models\Order;
use Karma\Ecommerce\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Handle payment gateway webhooks (IPN)
     */
    public function notification(Request $request, $gateway)
    {
        Log::info("Payment notification received from {$gateway}", $request->all());

        if ($gateway === 'midtrans') {
            return $this->handleMidtrans($request);
        }

        return response()->json(['message' => 'Gateway not supported'], 400);
    }

    protected function handleMidtrans(Request $request)
    {
        $serverKey = config('ecommerce.payment.midtrans.server_key');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $order = Order::where('order_number', $request->order_id)->first();
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $status = $request->transaction_status;

        if ($status == 'settlement' || $status == 'capture') {
            $order->update(['payment_status' => 'paid', 'paid_at' => now()]);
            $order->payments()->create([
                'gateway' => 'midtrans',
                'transaction_id' => $request->transaction_id,
                'amount' => $request->gross_amount,
                'status' => 'success',
                'payment_details' => $request->all(),
                'paid_at' => now(),
            ]);
        } elseif ($status == 'pending') {
            $order->update(['payment_status' => 'pending']);
        } else {
            $order->update(['payment_status' => 'failed']);
        }

        return response()->json(['message' => 'Notification processed']);
    }

    public function success(Request $request)
    {
        return view('ecommerce::frontend.checkout.success');
    }

    public function failed(Request $request)
    {
        return view('ecommerce::frontend.checkout.failed');
    }
}
