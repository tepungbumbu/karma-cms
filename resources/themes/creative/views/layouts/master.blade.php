<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ darkMode: localStorage.getItem('dark_mode') === 'true' }"
      :class="{ 'dark': darkMode }"
      class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <style>
        [x-cloak] { display: none !important; }
        {!! app(\App\Core\Services\PerformanceOptimizer::class)->getCriticalCss('creative') !!}
    </style>

    @include('theme::partials.seo-meta')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                    colors: { creative: '#ff2d20' }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('head')
</head>
<body class="bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 font-sans antialiased transition-colors duration-300">
    
    <header role="banner" class="max-w-7xl mx-auto px-6 py-12 flex items-center justify-between">
        @include('theme::partials.header')
    </header>

    <main id="main-content" role="main" class="max-w-7xl mx-auto px-6 pb-24">
        @yield('content')
    </main>

    <footer role="contentinfo" class="border-t border-zinc-100 dark:border-zinc-900 py-12">
        @include('theme::partials.footer')
    </footer>

    @include('theme::partials.schema-jsonld')
    @stack('scripts')
</body>
</html>
