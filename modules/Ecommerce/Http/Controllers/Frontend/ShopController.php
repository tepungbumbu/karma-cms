<?php

namespace Karma\Ecommerce\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Karma\Ecommerce\Models\Product;
use Karma\Ecommerce\Models\Category;
use Karma\Ecommerce\Models\Brand;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::published();

        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('brand')) {
            $query->whereHas('brand', function($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(12);
        
        $categories = Category::where('is_visible', true)->whereNull('parent_id')->with('children')->get();
        $brands = Brand::where('is_visible', true)->get();

        return view('ecommerce::frontend.shop.index', compact('products', 'categories', 'brands'));
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->published()->with(['category', 'brand', 'variants', 'reviews.user'])->firstOrFail();
        
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->published()
            ->limit(4)
            ->get();

        return view('ecommerce::frontend.shop.product', compact('product', 'relatedProducts'));
    }
}
