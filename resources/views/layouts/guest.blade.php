<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data :class="{ 'dark': $store.theme.isDark }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Account - ToolOrbit</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-slate-50 dark:bg-slate-950 transition-colors duration-500">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-8">
                <a href="/" class="flex items-center space-x-2">
                    <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <span class="text-3xl font-black text-slate-900 dark:text-white tracking-tighter">ToolOrbit</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-10 py-12 bg-white dark:bg-slate-900 shadow-2xl shadow-indigo-500/10 rounded-[40px] border border-slate-100 dark:border-slate-800 animate-in fade-in zoom-in duration-500">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center">
                <a href="/" class="text-sm font-bold text-slate-400 hover:text-indigo-600 transition-colors uppercase tracking-widest">← Back to Home</a>
            </div>
        </div>
    </body>
</html>
