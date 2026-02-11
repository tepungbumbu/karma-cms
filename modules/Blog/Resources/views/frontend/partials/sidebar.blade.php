<div class="space-y-6">
    <!-- Search -->
    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
        <h3 class="font-bold mb-4">Search</h3>
        <form action="{{ route('blog.search') }}" method="GET">
            <div class="flex">
                <input type="text" name="q" placeholder="Type and enter..." class="w-full border-gray-300 rounded-l-md focus:ring-indigo-500 focus:border-indigo-500">
                <button type="submit" class="bg-indigo-600 text-white px-4 rounded-r-md hover:bg-indigo-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Categories -->
    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
        <h3 class="font-bold mb-4">Categories</h3>
        <ul class="space-y-2">
            @php $categories = \Karma\Blog\Models\Category::active()->ordered()->get(); @endphp
            @foreach($categories as $cat)
            <li>
                <a href="{{ $cat->url }}" class="flex justify-between items-center text-gray-600 hover:text-indigo-600 transition">
                    <span>{{ $cat->name }}</span>
                    <span class="bg-gray-100 text-gray-400 text-xs px-2 py-1 rounded-full">{{ $cat->posts_count ?: 0 }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
