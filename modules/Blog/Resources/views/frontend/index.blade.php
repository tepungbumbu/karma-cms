@extends('layouts.web')

@section('title', isset($category) ? $category->name . ' - Blog' : 'Blog')

@section('content')
<div class="flex flex-col lg:flex-row gap-8">
    <div class="lg:w-2/3">
        <header class="mb-8">
            <h1 class="text-3xl font-bold">
                @if(isset($category))
                    Category: {{ $category->name }}
                @elseif(isset($tag))
                    Tag: {{ $tag->name }}
                @elseif(isset($query))
                    Search Results for "{{ $query }}"
                @else
                    Latest Blog Posts
                @endif
            </h1>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($posts as $post)
            <article class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm transition hover:shadow-md">
                <a href="{{ $post->url }}">
                    <img src="{{ $post->getFirstMediaUrl('featured_image', 'thumb') ?: 'https://via.placeholder.com/400x250' }}" class="w-full h-48 object-cover" alt="{{ $post->title }}">
                </a>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-2 text-xs text-indigo-600 font-semibold uppercase tracking-wider">
                        <a href="{{ $post->category->url }}">{{ $post->category->name }}</a>
                    </div>
                    <h2 class="text-xl font-bold mb-2">
                        <a href="{{ $post->url }}" class="hover:text-indigo-600 transition">{{ $post->title }}</a>
                    </h2>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                        {{ $post->summary }}
                    </p>
                    <div class="flex items-center justify-between text-xs text-gray-400">
                        <span>{{ $post->published_at?->format('F d, Y') }}</span>
                        <span>{{ $post->reading_time }} min read</span>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>

    <aside class="lg:w-1/3">
        @include('blog::frontend.partials.sidebar')
    </aside>
</div>
@endsection
