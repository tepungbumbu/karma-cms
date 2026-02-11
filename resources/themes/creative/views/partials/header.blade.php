<nav class="flex items-center justify-between w-full">
    <a href="/" class="text-3xl font-extrabold tracking-tighter text-zinc-900 dark:text-white uppercase italic">
        Karma<span class="text-creative">Creative</span>
    </a>

    <div class="flex items-center gap-8">
        <ul class="hidden md:flex items-center gap-8 text-sm font-semibold tracking-wide uppercase">
            <li><a href="/" class="hover:text-creative transition">Work</a></li>
            <li><a href="/blog" class="hover:text-creative transition">Journal</a></li>
            <li><a href="#" class="hover:text-creative transition">About</a></li>
        </ul>

        <button @click="darkMode = !darkMode; localStorage.setItem('dark_mode', darkMode)" 
                class="p-2 bg-zinc-100 dark:bg-zinc-900 rounded-full text-zinc-600 dark:text-zinc-400 hover:scale-110 transition">
            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            <svg x-show="darkMode" x-cloak class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9h-1m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
        </button>
    </div>
</nav>
