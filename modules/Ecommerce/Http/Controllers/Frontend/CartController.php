<?php

namespace Karma\Ecommerce\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Karma\Ecommerce\Models\Cart;
use Karma\Ecommerce\Models\CartItem;
use Karma\Ecommerce\Models\Product;
use Karma\Ecommerce\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cart->load('items.product', 'items.variant');
        return view('ecommerce::frontend.cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:ecommerce_products,id',
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'nullable|exists:ecommerce_product_variants,id',
        ]);

        $cart = $this->getOrCreateCart();
        $product = Product::findOrFail($request->product_id);
        $variant = $request->variant_id ? ProductVariant::find($request->variant_id) : null;

        $unitPrice = $variant ? $variant->getFinalPrice() : $product->getFinalPrice();

        // Check if item already exists in cart
        $cartItem = $cart->items()->where('product_id', $product->id)
            ->where('variant_id', $request->variant_id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
            $cartItem->update(['subtotal' => $cartItem->quantity * $cartItem->unit_price]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'variant_id' => $request->variant_id,
                'quantity' => $request->quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $unitPrice * $request->quantity,
            ]);
        }

        $cart->updateTotals();

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'cart_count' => $cart->items()->count()]);
        }

        return redirect()->back()->with('success', 'Item added to cart.');
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        
        $item->update([
            'quantity' => $request->quantity,
            'subtotal' => $request->quantity * $item->unit_price
        ]);

        $item->cart->updateTotals();

        return back()->with('success', 'Cart updated.');
    }

    public function remove(CartItem $item)
    {
        $cart = $item->cart;
        $item->delete();
        $cart->updateTotals();

        return back()->with('success', 'Item removed from cart.');
    }

    protected function getOrCreateCart()
    {
        $sessionId = session()->getId();
        $userId = auth()->id();

        if ($userId) {
            $cart = Cart::where('user_id', $userId)->where('status', 'active')->first();
            if (!$cart) {
                $cart = Cart::create(['user_id' => $userId, 'status' => 'active']);
            }
        } else {
            $cart = Cart::where('session_id', $sessionId)->where('status', 'active')->first();
            if (!$cart) {
                $cart = Cart::create(['session_id' => $sessionId, 'status' => 'active']);
            }
        }

        return $cart;
    }
}
