@php
    $seo = app(\App\Core\Services\SEOManager::class)->getMetaTags($model ?? null);
@endphp

<title>{{ $seo['title'] }}</title>
<meta name="description" content="{{ $seo['description'] }}">
<meta name="keywords" content="{{ $seo['keywords'] }}">
<link rel="canonical" href="{{ $seo['canonical'] }}">

<!-- Open Graph -->
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $seo['og_title'] }}">
<meta property="og:description" content="{{ $seo['og_description'] }}">
<meta property="og:image" content="{{ $seo['og_image'] }}">
<meta property="og:url" content="{{ URL::current() }}">

<!-- Twitter -->
<meta name="twitter:card" content="{{ $seo['twitter_card'] }}">
<meta name="twitter:title" content="{{ $seo['og_title'] }}">
<meta name="twitter:description" content="{{ $seo['og_description'] }}">
<meta name="twitter:image" content="{{ $seo['og_image'] }}">

<meta name="robots" content="{{ $seo['robots'] }}">
