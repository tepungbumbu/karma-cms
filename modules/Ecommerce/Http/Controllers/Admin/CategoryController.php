<?php

namespace Karma\Ecommerce\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Karma\Ecommerce\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->latest()->paginate(20);
        return view('ecommerce::admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->get();
        return view('ecommerce::admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        Category::create($data);

        return redirect()->route('admin.ecommerce.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        $parents = Category::where('id', '!=', $category->id)->whereNull('parent_id')->get();
        return view('ecommerce::admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255']);
        
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        $category->update($data);

        return redirect()->route('admin.ecommerce.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete category with associated products.');
        }
        $category->delete();
        return redirect()->route('admin.ecommerce.categories.index')->with('success', 'Category deleted successfully.');
    }
}
