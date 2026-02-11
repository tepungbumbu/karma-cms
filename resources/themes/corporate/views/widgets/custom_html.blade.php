<div class="widget-custom-html mb-8">
    @if(isset($settings['title']))
        <h3 class="font-bold text-gray-900 mb-4">{{ $settings['title'] }}</h3>
    @endif
    <div class="text-gray-600 text-sm leading-relaxed">
        {!! $settings['html'] ?? '' !!}
    </div>
</div>
