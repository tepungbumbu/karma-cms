<?php

namespace Karma\Ecommerce\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Karma\Ecommerce\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        return view('ecommerce::admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'payments', 'user']);
        return view('ecommerce::admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|string']);
        
        $order->update(['status' => $request->status]);

        // Trigger notification logic here if needed

        return back()->with('success', 'Order status updated successfully.');
    }

    public function printInvoice(Order $order)
    {
        // Integration with DomPDF or similar would go here
        return view('ecommerce::admin.orders.invoice', compact('order'));
    }
}
