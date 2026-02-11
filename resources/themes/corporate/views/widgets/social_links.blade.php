<div class="widget-social mb-8">
    <h3 class="font-bold text-gray-900 mb-4">{{ $settings['title'] ?? 'Follow Us' }}</h3>
    <div class="flex flex-wrap gap-4">
        @foreach($settings['links'] ?? [] as $platform => $url)
        <a href="{{ $url }}" class="text-gray-400 hover:text-indigo-600 transition" aria-label="{{ $platform }}">
            <!-- Icon placeholder based on platform -->
            <span class="text-sm font-medium capitalize">{{ $platform }}</span>
        </a>
        @endforeach
    </div>
</div>
