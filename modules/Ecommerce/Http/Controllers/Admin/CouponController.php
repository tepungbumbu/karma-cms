<?php

namespace Karma\Ecommerce\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Karma\Ecommerce\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(20);
        return view('ecommerce::admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('ecommerce::admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:ecommerce_coupons,code',
            'type' => 'required|in:fixed_amount,percentage',
            'value' => 'required|numeric|min:0',
        ]);
        
        Coupon::create($request->all());

        return redirect()->route('admin.ecommerce.coupons.index')->with('success', 'Coupon created successfully.');
    }

    public function edit(Coupon $coupon)
    {
        return view('ecommerce::admin.coupons.edit', compact($coupon));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|unique:ecommerce_coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed_amount,percentage',
            'value' => 'required|numeric|min:0',
        ]);
        
        $coupon->update($request->all());

        return redirect()->route('admin.ecommerce.coupons.index')->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.ecommerce.coupons.index')->with('success', 'Coupon deleted successfully.');
    }
}
