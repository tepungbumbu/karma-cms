<?php

namespace Karma\Ecommerce\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Karma\Ecommerce\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->paginate(20);
        return view('ecommerce::admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('ecommerce::admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        Brand::create($data);

        return redirect()->route('admin.ecommerce.brands.index')->with('success', 'Brand created successfully.');
    }

    public function edit(Brand $brand)
    {
        return view('ecommerce::admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate(['name' => 'required|string|max:255']);
        
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        $brand->update($data);

        return redirect()->route('admin.ecommerce.brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->products()->count() > 0) {
            return back()->with('error', 'Cannot delete brand with associated products.');
        }
        $brand->delete();
        return redirect()->route('admin.ecommerce.brands.index')->with('success', 'Brand deleted successfully.');
    }
}
