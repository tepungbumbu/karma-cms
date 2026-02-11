<div x-data="{ show: !localStorage.getItem('cookie_consent') }"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform translate-y-4"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     class="fixed bottom-4 right-4 max-w-sm bg-white rounded-lg shadow-2xl border border-gray-100 p-6 z-50">
    <div class="flex items-start gap-4">
        <div class="bg-indigo-50 p-2 rounded-full text-indigo-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <h3 class="font-bold text-sm mb-1">Cookie Consent</h3>
            <p class="text-gray-500 text-xs leading-relaxed mb-4">
                We use cookies to improve your experience and analyze our traffic. By clicking "Accept", you consent to our use of cookies.
            </p>
            <div class="flex gap-2">
                <button @click="localStorage.setItem('cookie_consent', 'true'); show = false" class="bg-indigo-600 text-white px-4 py-2 rounded text-xs font-bold hover:bg-indigo-700 transition">
                    Accept All
                </button>
                <button @click="show = false" class="text-gray-500 px-4 py-2 rounded text-xs font-bold hover:bg-gray-100 transition">
                    Settings
                </button>
            </div>
        </div>
    </div>
</div>
