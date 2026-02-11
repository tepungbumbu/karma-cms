@extends('theme::layouts.master')

@section('title', 'Modern Solutions for Your Business - ' . config('app.name'))

@section('hero')
<div class="relative bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                        <span class="block xl:inline">Build your brand with</span>
                        <span class="block text-indigo-600 xl:inline">modular CMS efficiency</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        Karma CMS provides the ultimate foundation for your next project. High performance, SEO ready, and fully customizable themes.
                    </p>
                    <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                        <div class="rounded-md shadow">
                            <a href="#" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                Get started
                            </a>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:ml-3">
                            <a href="/blog" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 md:py-4 md:text-lg md:px-10">
                                View Blog
                            </a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
        <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&auto=format&fit=crop&w=2850&q=80" alt="Team working">
    </div>
</div>
@endsection

@section('content')
<div class="space-y-24">
    <!-- Services Section -->
    <section>
        <div class="text-center mb-16">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Our Services</h2>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500 text-center">Comprehensive solutions for modern digital presence.</p>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach(['Web Design', 'SEO Optimization', 'Cloud Hosting', 'Digital Marketing', 'Content Strategy', 'Brand Identity'] as $service)
            <div class="pt-6">
                <div class="flow-root bg-gray-50 rounded-lg px-6 pb-8 border border-transparent hover:border-indigo-100 transition duration-300">
                    <div class="-mt-6">
                        <div>
                            <span class="inline-flex items-center justify-center p-3 bg-indigo-600 rounded-md shadow-lg">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </span>
                        </div>
                        <h3 class="mt-8 text-lg font-medium text-gray-900 tracking-tight">{{ $service }}</h3>
                        <p class="mt-5 text-base text-gray-500">
                            Amet interdum tate tate rper pretium elit. Curae vitae aenean tristique.
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Ad placeholder -->
    <x-ad-unit position="home-middle" :size="['728x90']" />

    <!-- Features -->
    <section class="bg-indigo-600 rounded-2xl p-12 text-white">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold mb-6">Why choose Karma CMS for your business?</h2>
                <ul class="space-y-4">
                    @foreach(['Blazing fast performance on shared hosting', 'Dynamic theme switching system', 'SEO optimized with Schema.org markup', 'Mobile-first semantic HTML 2026'] as $feature)
                    <li class="flex items-center gap-3">
                        <svg class="h-6 w-6 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ $feature }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="bg-white/10 backdrop-blur-md rounded-xl p-8 border border-white/20">
                <blockquote class="text-xl italic">
                    "The most flexible CMS we've used. The modularity and PageSpeed scores are incredible."
                </blockquote>
                <div class="mt-6 font-bold">- John Doe, CTO at LexCorp</div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('sidebar')
    @widgetArea('sidebar')
    
    <div class="mt-12 bg-gray-50 p-8 rounded-xl text-center border border-gray-100">
        <h3 class="font-bold text-gray-900 mb-4">Start your project today</h3>
        <p class="text-gray-500 text-sm mb-6 leading-relaxed">Let our experts help you build something amazing.</p>
        <a href="#" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold text-sm block hover:bg-indigo-700 transition">Get a Quote</a>
    </div>
@endsection
