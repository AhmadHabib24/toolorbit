<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data :class="{ 'dark': $store.theme.isDark }"
      dir="{{ in_array(app()->getLocale(), ['ar', 'ur']) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ToolOrbit - All-in-One SEO Tools Platform')</title>
    <meta name="description" content="@yield('meta_description', 'Free online SEO tools for webmasters, content creators, and digital marketers.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 dark:bg-slate-950 transition-colors duration-500">
    <x-navbar />
    
    <main>
        @if (isset($header))
            <header class="bg-white dark:bg-slate-900 shadow-sm border-b border-slate-100 dark:border-slate-800">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-slate-500 dark:text-slate-400 font-bold uppercase tracking-widest text-[10px]">© {{ date('Y') }} ToolOrbit. Developed with passion for the digital world.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
