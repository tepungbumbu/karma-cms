<div class="widget-newsletter mb-8 p-6 bg-indigo-50 rounded-xl">
    <h3 class="font-bold text-gray-900 mb-2">{{ $settings['title'] ?? 'Newsletter' }}</h3>
    <p class="text-sm text-gray-600 mb-4">{{ $settings['description'] ?? 'Get the latest updates delivered to your inbox.' }}</p>
    <form class="flex flex-col gap-2">
        <input type="email" placeholder="Your email..." class="w-full px-4 py-2 rounded-lg border-gray-200 text-sm">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition">
            Subscribe
        </button>
    </form>
</div>
