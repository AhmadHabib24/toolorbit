<nav class="sticky top-0 z-50 glass border-b border-slate-200" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <a href="/" class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-indigo-500/50 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-extrabold tracking-tight text-slate-900">Tool<span class="text-indigo-600">Orbit</span></span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="/" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">{{ __('Home') }}</a>
                <a href="/#tools" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">{{ __('All Tools') }}</a>
                <!-- OrbitAI -->
                <a href="/ai/chat" class="flex items-center text-sm font-bold text-indigo-600 px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg hover:bg-indigo-100 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    OrbitAI
                </a>
                
                <div class="h-6 w-px bg-slate-200 dark:bg-slate-800"></div>

                <!-- Theme Toggle -->
                <button 
                    @click="$store.theme.toggle()" 
                    class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:text-indigo-600 transition-all"
                    title="Toggle Dark Mode"
                >
                    <svg x-show="!$store.theme.isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg x-show="$store.theme.isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>

                <!-- Language Switcher -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-xs font-black bg-slate-100 dark:bg-slate-800 px-3 py-2 rounded-xl text-slate-600 dark:text-slate-400 uppercase tracking-widest hover:text-indigo-600 transition-all">
                        <span>{{ app()->getLocale() }}</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl shadow-xl z-50 overflow-hidden">
                        <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">English</a>
                        <a href="{{ route('lang.switch', 'es') }}" class="block px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">Spanish</a>
                        <a href="{{ route('lang.switch', 'fr') }}" class="block px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">French</a>
                        <a href="{{ route('lang.switch', 'ur') }}" class="block px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 text-right font-urdu">اردو</a>
                        <a href="{{ route('lang.switch', 'ar') }}" class="block px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 text-right">العربية</a>
                        <a href="{{ route('lang.switch', 'tr') }}" class="block px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">Türkçe</a>
                    </div>
                </div>

                @auth
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-3 p-1 pl-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-full border border-indigo-100 dark:border-indigo-800/50 hover:bg-indigo-100 transition-all">
                            <span class="text-sm font-bold text-indigo-700 dark:text-indigo-400">{{ Auth::user()->name }}</span>
                            <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl shadow-xl z-50 overflow-hidden py-2 animate-in fade-in slide-in-from-top-2">
                            @if(Auth::user()->hasRole('admin'))
                                <a href="/admin" class="block px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">Admin Dashboard</a>
                            @endif
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">User Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">Profile Settings</a>
                            <div class="h-px bg-slate-100 dark:bg-slate-700 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm font-bold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20">Log Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 dark:text-slate-400 hover:text-indigo-600 transition-all">Sign In</a>
                    <a href="{{ route('register') }}" class="btn-primary px-6 py-2.5 rounded-xl text-sm font-bold">Get Started</a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center space-x-4">
                <button @click="$store.theme.toggle()" class="p-2 text-slate-600">
                    <svg x-show="!$store.theme.isDark" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg x-show="$store.theme.isDark" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </button>
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-600 p-2">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="!mobileMenuOpen">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="mobileMenuOpen" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div x-show="mobileMenuOpen" 
         class="md:hidden bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800"
         style="display: none;"
    >
        <div class="px-4 pt-2 pb-6 space-y-2">
            <a href="/" class="block px-4 py-3 rounded-xl text-base font-bold text-slate-700 dark:text-slate-300">Home</a>
            <a href="/#tools" class="block px-4 py-3 rounded-xl text-base font-bold text-slate-700 dark:text-slate-300">All Tools</a>
            <a href="/ai/chat" class="flex items-center px-4 py-3 rounded-xl text-base font-bold text-indigo-600 bg-indigo-50 dark:bg-indigo-900/30">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                OrbitAI Assistant
            </a>
            
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 mt-4 flex flex-col space-y-3">
                @auth
                    <div class="px-4 py-2 text-xs font-black text-slate-400 uppercase tracking-widest">Account</div>
                    @if(Auth::user()->hasRole('admin'))
                        <a href="/admin" class="block px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-300">Admin Dashboard</a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-300">User Dashboard</a>
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-300">Profile Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm font-bold text-rose-600">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-center text-sm font-bold text-slate-600 dark:text-slate-400 py-3">Sign In</a>
                    <a href="{{ route('register') }}" class="btn-primary py-3 text-center">Get Started Free</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
