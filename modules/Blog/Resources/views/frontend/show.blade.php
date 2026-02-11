@extends('layouts.web')

@section('title', $post->meta_title ?: $post->title)

@push('meta')
    @foreach($seo as $key => $value)
        @if($value)
            <meta name="{{ $key }}" content="{{ $value }}">
        @endif
    @endforeach
    <script type="application/ld+json">
        {!! json_encode($schema) !!}
    </script>
@endpush

@section('content')
<div class="flex flex-col lg:flex-row gap-8">
    <div class="lg:w-2/3">
        <article class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm" itemscope itemtype="https://schema.org/BlogPosting">
            <img src="{{ $post->getFirstMediaUrl('featured_image', 'large') ?: 'https://via.placeholder.com/800x400' }}" class="w-full h-auto" itemprop="image" alt="{{ $post->title }}">
            
            <div class="p-8">
                <header class="mb-6">
                    <div class="flex items-center gap-2 mb-2 text-xs text-indigo-600 font-semibold uppercase tracking-wider">
                        <a href="{{ $post->category->url }}">{{ $post->category->name }}</a>
                    </div>
                    <h1 class="text-4xl font-extrabold mb-4" itemprop="headline">{{ $post->title }}</h1>
                    
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <div class="flex items-center gap-2" itemprop="author" itemscope itemtype="https://schema.org/Person">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($post->author->name) }}" class="w-6 h-6 rounded-full" alt="">
                            <span itemprop="name">{{ $post->author->name }}</span>
                        </div>
                        <time datetime="{{ $post->published_at?->toIso8601String() }}" itemprop="datePublished">
                            {{ $post->published_at?->format('F d, Y') }}
                        </time>
                        <span>&middot;</span>
                        <span>{{ $post->reading_time }} min read</span>
                    </div>
                </header>

                <div class="prose prose-indigo max-w-none text-gray-700 leading-relaxed" itemprop="articleBody">
                    {!! nl2br(e($post->content)) !!}
                </div>

                <footer class="mt-8 pt-8 border-t border-gray-100">
                    <div class="flex flex-wrap gap-2 text-sm">
                        @foreach($post->tags as $tag)
                        <a href="{{ $tag->url }}" class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full hover:bg-indigo-600 hover:text-white transition">
                            #{{ $tag->name }}
                        </a>
                        @endforeach
                    </div>
                </footer>
            </div>
        </article>
    </div>

    <aside class="lg:w-1/3">
        @include('blog::frontend.partials.sidebar')
    </aside>
</div>
@endsection
