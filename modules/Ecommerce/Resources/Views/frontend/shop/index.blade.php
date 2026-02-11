@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Sidebar Filters -->
            <div class="w-full md:w-1/4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold mb-4">Categories</h3>
                    <ul class="space-y-2">
                        @foreach($categories as $category)
                            <li><a href="?category={{ $category->slug }}" class="text-blue-600 hover:underline">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="w-full md:w-3/4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="font-bold text-lg mb-2"><a href="{{ route('ecommerce.product', $product->slug) }}">{{ $product->name }}</a></h3>
                                <p class="text-gray-600 mb-4">{{ Str::limit($product->short_description, 100) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xl font-bold">{{ Karma\Ecommerce\Services\EcommerceHelper::formatPrice($product->price) }}</span>
                                    <form action="{{ route('ecommerce.cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
