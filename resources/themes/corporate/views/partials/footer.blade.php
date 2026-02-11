<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
        <div class="col-span-1 md:col-span-1">
            <a href="/" class="font-bold text-xl text-white mb-4 block">Karma CMS</a>
            <p class="text-gray-400 text-sm leading-relaxed">
                Empowering businesses with modern, modular, and high-performance content management solutions.
            </p>
        </div>
        
        <div>
            <h4 class="font-bold mb-4">Quick Links</h4>
            <ul class="space-y-2 text-gray-400 text-sm">
                <li><a href="#" class="hover:text-white transition">Home</a></li>
                <li><a href="/blog" class="hover:text-white transition">Blog</a></li>
                <li><a href="#" class="hover:text-white transition">Services</a></li>
                <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
            </ul>
        </div>

        <div>
            <h4 class="font-bold mb-4">Services</h4>
            <ul class="space-y-2 text-gray-400 text-sm">
                <li><a href="#" class="hover:text-white transition">Web Development</a></li>
                <li><a href="#" class="hover:text-white transition">SEO Optimization</a></li>
                <li><a href="#" class="hover:text-white transition">Brand Strategy</a></li>
                <li><a href="#" class="hover:text-white transition">Digital Marketing</a></li>
            </ul>
        </div>

        <div>
            <h4 class="font-bold mb-4">Newsletter</h4>
            <p class="text-gray-400 text-sm mb-4">Stay updated with our latest news.</p>
            <form class="flex gap-2">
                <input type="email" placeholder="Email address" class="bg-gray-800 border-none rounded-md px-4 py-2 text-sm w-full focus:ring-2 focus:ring-indigo-500">
                <button class="bg-indigo-600 px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>
        </div>
    </div>
    
    <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
</div>
