@php
    $siteSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => config('app.name'),
        'url' => url('/'),
    ];
@endphp

<script type="application/ld+json">
    {!! json_encode($siteSchema) !!}
</script>

@stack('schema')
