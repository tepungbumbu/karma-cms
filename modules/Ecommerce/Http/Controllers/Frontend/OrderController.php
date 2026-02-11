<?php

namespace Karma\Ecommerce\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Karma\Ecommerce\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        return view('ecommerce::frontend.orders.index', compact('orders'));
    }

    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->with(['items.product', 'payments'])
            ->firstOrFail();

        return view('ecommerce::frontend.orders.show', compact('order'));
    }

    public function track($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        return view('ecommerce::frontend.orders.track', compact('order'));
    }
}
