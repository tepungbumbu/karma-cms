<?php

namespace Karma\Ecommerce\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Karma\Ecommerce\Models\Cart;
use Karma\Ecommerce\Models\Order;
use Karma\Ecommerce\Models\OrderItem;
use Karma\Ecommerce\Models\ShippingAddress;
use Karma\Ecommerce\Services\Payment\MidtransGateway;
use Karma\Ecommerce\Services\Shipping\RajaOngkirService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();
        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('ecommerce.cart.index')->with('error', 'Your cart is empty.');
        }

        $addresses = auth()->check() ? auth()->user()->shippingAddresses : collect();
        
        return view('ecommerce::frontend.checkout.index', compact('cart', 'addresses'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required',
            'shipping_address' => 'required|array',
            'payment_method' => 'required|string',
        ]);

        $cart = $this->getCart();

        try {
            DB::beginTransaction();

            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6));

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => auth()->id(),
                'status' => 'pending',
                'currency' => 'IDR',
                'subtotal' => $cart->items->sum('subtotal'),
                'tax_amount' => $cart->tax_amount,
                'shipping_amount' => $cart->shipping_amount,
                'total_amount' => $cart->total_amount,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'name' => $item->product->name,
                    'sku' => $item->product->sku,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'subtotal' => $item->subtotal,
                    'total' => $item->subtotal + $item->tax_amount,
                    'product_data' => $item->product->toArray(),
                ]);

                // Update stock
                $item->product->decrement('stock_quantity', $item->quantity);
            }

            $cart->update(['status' => 'converted', 'converted_at' => now()]);

            DB::commit();

            // Redirect to payment gateway
            return $this->redirectToGateway($order);

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }

    protected function redirectToGateway(Order $order)
    {
        if ($order->payment_method === 'midtrans') {
            $gateway = new MidtransGateway();
            $response = $gateway->initialize($order);
            return redirect($response['redirect_url']);
        }

        // Handle other gateways...
        return redirect()->route('ecommerce.order.success', $order->order_number);
    }

    protected function getCart()
    {
        return Cart::where(function($query) {
            $query->where('user_id', auth()->id())->orWhere('session_id', session()->getId());
        })->where('status', 'active')->first();
    }
}
