<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Critical CSS -->
    <style>
        {!! app(\App\Core\Services\PerformanceOptimizer::class)->getCriticalCss('corporate') !!}
    </style>

    <!-- SEO Meta Tags -->
    @include('theme::partials.seo-meta')

    <!-- Preconnect hints -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- UI Core -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('head')
</head>
<body class="bg-white text-gray-900 font-sans antialiased">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-indigo-600 text-white px-4 py-2 rounded shadow-lg z-50">
        Skip to main content
    </a>

    <!-- Header -->
    <header role="banner" class="sticky top-0 bg-white/80 backdrop-blur-md border-b border-gray-100 z-40">
        @include('theme::partials.header')
    </header>

    @hasSection('hero')
    <section role="region" aria-label="Hero section">
        @yield('hero')
    </section>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            <main id="main-content" role="main" class="flex-1">
                @yield('content')
            </main>

            @hasSection('sidebar')
            <aside role="complementary" aria-label="Sidebar" class="lg:w-1/3">
                @yield('sidebar')
            </aside>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer role="contentinfo" class="bg-gray-900 text-white mt-auto">
        @include('theme::partials.footer')
    </footer>

    <!-- Schema.org -->
    @include('theme::partials.schema-jsonld')

    <!-- Cookie Consent -->
    @include('theme::partials.cookie-consent')

    @stack('scripts')
</body>
</html>
