<div class="widget-recent-posts mb-8">
    <h3 class="font-bold text-gray-900 mb-4">{{ $settings['title'] ?? 'Recent Posts' }}</h3>
    <div class="space-y-4">
        @foreach($posts as $post)
        <div class="flex gap-4 items-center group">
            <a href="{{ $post->url }}" class="flex-shrink-0">
                <img src="{{ $post->getFirstMediaUrl('featured_image', 'thumb') ?: 'https://via.placeholder.com/80/eeeeee/999999?text=Post' }}" 
                     class="w-16 h-16 rounded object-cover shadow-sm group-hover:opacity-75 transition" alt="">
            </a>
            <div class="flex-1">
                <a href="{{ $post->url }}" class="text-sm font-bold text-gray-800 hover:text-indigo-600 transition leading-snug line-clamp-2">
                    {{ $post->title }}
                </a>
                <time class="text-xs text-gray-400 mt-1 block">{{ $post->published_at?->format('M d, Y') }}</time>
            </div>
        </div>
        @endforeach
    </div>
</div>
