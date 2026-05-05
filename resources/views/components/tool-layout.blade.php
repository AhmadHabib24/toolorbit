@props(['title', 'description', 'category'])

<div class="py-12 bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-500">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex mb-8 text-sm font-medium text-slate-500">
            <a href="/" class="hover:text-indigo-600 transition-colors">Home</a>
            <span class="mx-2">/</span>
            <span class="text-slate-400 dark:text-slate-500">{{ $category }}</span>
        </nav>

        <!-- Tool Header -->
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-black text-slate-900 dark:text-white mb-4">{{ $title }}</h1>
            <p class="text-lg text-slate-600 dark:text-slate-400">{{ $description }}</p>
        </div>

        <!-- Tool Content -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-premium border border-slate-100 dark:border-slate-800 overflow-hidden">
            {{ $slot }}
        </div>

        <!-- How it works / Info Section -->
        <div class="mt-16 max-w-none">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-6 text-center">How to use {{ $title }}?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-6">
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center font-bold mx-auto mb-4">1</div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-2">Input Data</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Paste your text or enter the required information into the input field above.</p>
                </div>
                <div class="p-6">
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center font-bold mx-auto mb-4">2</div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-2">Process</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Click the action button to process your request using our high-speed algorithms.</p>
                </div>
                <div class="p-6">
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center font-bold mx-auto mb-4">3</div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-2">Get Results</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">View or download your results instantly. It's 100% free and secure.</p>
                </div>
            </div>
        </div>
    </div>
</div>

