@props([
    'position' => 'general',
    'size' => ['300x250'],
    'lazy' => true
])

@php
    // Simple dimensions from size array
    $dim = explode('x', $size[0]);
    $width = $dim[0] ?? '300';
    $height = $dim[1] ?? '250';
    $adClientId = config('karma.adsense_id', 'ca-pub-XXXXXXXXXXXXXXXX');
@endphp

<div class="ad-container my-6 mx-auto text-center" 
     style="min-height: {{ $height }}px; min-width: {{ $width }}px;"
     x-data="{ visible: false }"
     x-intersect.margin.200px="visible = true">
    
    <div x-show="visible">
        <ins class="adsbygoogle"
             style="display:inline-block;width:{{ $width }}px;height:{{ $height }}px"
             data-ad-client="{{ $adClientId }}"
             data-ad-slot="1234567890"></ins>
        <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>

    <div x-show="!visible" class="bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-300 text-xs italic" style="height: {{ $height }}px;">
        Advertisement Space
    </div>
</div>
