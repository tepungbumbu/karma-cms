<?php

namespace Karma\Ecommerce\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Karma\Ecommerce\Models\Product;
use Karma\Ecommerce\Models\Category;
use Karma\Ecommerce\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])->latest()->paginate(20);
        return view('ecommerce::admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('ecommerce::admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:ecommerce_products,sku',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:ecommerce_categories,id',
            'stock_quantity' => 'required|integer',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        $product = Product::create($data);

        return redirect()->route('admin.ecommerce.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('ecommerce::admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:ecommerce_products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:ecommerce_categories,id',
            'stock_quantity' => 'required|integer',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        $product->update($data);

        return redirect()->route('admin.ecommerce.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.ecommerce.products.index')->with('success', 'Product deleted successfully.');
    }
}
