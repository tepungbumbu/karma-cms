@if($post && $post->author)
<div class="widget-author-bio mb-8 p-6 border border-gray-100 rounded-xl bg-white shadow-sm">
    <div class="flex items-center gap-4 mb-4">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($post->author->name) }}&background=6366f1&color=fff" class="w-12 h-12 rounded-full" alt="">
        <div>
            <h4 class="font-bold text-gray-900">{{ $post->author->name }}</h4>
            <span class="text-xs text-gray-400">Author</span>
        </div>
    </div>
    <p class="text-sm text-gray-600 leading-relaxed">
        Passionate creator and contributor to the Karma CMS ecosystem.
    </p>
</div>
@endif
