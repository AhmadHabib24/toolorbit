@extends('layouts.app')

@section('title', 'ToolOrbit - All-in-One SEO & Developer Tools')
@section('meta_description', 'Free online tools for SEO, YouTube, Analysis, Security, and Development. Fast, secure, and easy to use.')

@section('content')
<div x-data='{ 
    search: "",
    page: 1,
    perPage: 12,
    tools: @json($tools),
    get filteredTools() {
        return this.tools.filter(t => t.title.toLowerCase().includes(this.search.toLowerCase()));
    },
    get paginatedTools() {
        const start = (this.page - 1) * this.perPage;
        return this.filteredTools.slice(start, start + this.perPage);
    },
    get totalPages() {
        return Math.ceil(this.filteredTools.length / this.perPage);
    }
}' class="min-h-screen">
    
    <!-- Hero Section -->
    <div class="relative overflow-hidden pt-16 pb-32 bg-white dark:bg-slate-950 transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-sm font-bold mb-8 animate-in fade-in slide-in-from-top-4 duration-700">
                <span class="relative flex h-2 w-2 mr-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
                {{ __('OrbitAI Assistant is now Live!') }}
            </div>
            
            <h1 class="text-6xl md:text-8xl font-black text-slate-900 dark:text-white mb-8 tracking-tighter">
                {{ __('Tools that Empower your Digital Journey') }}
            </h1>
            
            <p class="text-xl text-slate-500 dark:text-slate-400 max-w-2xl mx-auto mb-12 leading-relaxed">
                30+ Professional tools for SEO, YouTube, Development, and Security. Fast, free, and designed for high-performance teams.
            </p>

            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto relative group">
                <div class="absolute inset-0 bg-indigo-500/20 blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <input 
                    type="text" 
                    x-model="search"
                    @input="page = 1"
                    placeholder="Search 30+ tools (e.g. Meta, PDF, IP)..." 
                    class="w-full p-8 bg-white dark:bg-slate-900 border-none rounded-[32px] shadow-premium focus:ring-4 focus:ring-indigo-500/20 transition-all text-lg relative z-10 dark:text-white"
                >
            </div>
        </div>
    </div>

    <!-- Main Grid Section -->
    <section id="tools" class="py-24 bg-white dark:bg-slate-950 transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 space-y-4 md:space-y-0">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 dark:text-white">{{ __('Explore All Tools') }}</h2>
                    <p class="text-slate-500 dark:text-slate-400">Discover professional utilities for your next project.</p>
                </div>
                <div class="flex items-center space-x-2 px-4 py-2 bg-slate-100 dark:bg-slate-900 rounded-xl text-xs font-bold text-slate-500 dark:text-slate-400">
                    <span x-text="filteredTools.length"></span> Tools Available
                </div>
            </div>

            <!-- Dynamic Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <template x-for="tool in paginatedTools" :key="tool.title">
                    <a :href="tool.href" class="group block p-8 bg-white dark:bg-slate-900 rounded-[40px] border border-slate-100 dark:border-slate-800 shadow-premium hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10">
                            <div class="w-14 h-14 bg-slate-50 dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="tool.icon"></path>
                                </svg>
                            </div>
                            <div class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mb-2 opacity-60" x-text="tool.category"></div>
                            <h3 class="text-xl font-black text-slate-900 dark:text-white mb-2 group-hover:text-indigo-600 transition-colors" x-text="tool.title"></h3>
                            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed" x-text="tool.desc"></p>
                        </div>
                        <div class="absolute bottom-8 right-8 opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 transition-all duration-500">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </a>
                </template>
            </div>

            <!-- Pagination Controls -->
            <div class="mt-20 flex flex-col items-center space-y-4" x-show="totalPages > 1">
                <div class="flex items-center space-x-2">
                    <button @click="page--; window.scrollTo({top: document.getElementById('tools').offsetTop - 100, behavior: 'smooth'})" :disabled="page === 1" class="p-4 bg-slate-100 dark:bg-slate-800 rounded-2xl text-slate-600 dark:text-slate-400 disabled:opacity-30 disabled:cursor-not-allowed hover:bg-indigo-600 hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    
                    <div class="flex items-center space-x-2 px-6 py-4 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl shadow-premium">
                        <span class="text-sm font-bold text-slate-400 uppercase tracking-widest">Page</span>
                        <span class="text-lg font-black text-indigo-600" x-text="page"></span>
                        <span class="text-sm font-bold text-slate-400 uppercase tracking-widest">of</span>
                        <span class="text-lg font-black text-slate-900 dark:text-white" x-text="totalPages"></span>
                    </div>

                    <button @click="page++; window.scrollTo({top: document.getElementById('tools').offsetTop - 100, behavior: 'smooth'})" :disabled="page === totalPages" class="p-4 bg-slate-100 dark:bg-slate-800 rounded-2xl text-slate-600 dark:text-slate-400 disabled:opacity-30 disabled:cursor-not-allowed hover:bg-indigo-600 hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>

            <!-- No Results -->
            <div x-show="filteredTools.length === 0" class="py-20 text-center">
                <div class="text-2xl font-bold text-slate-400">No tools found matching your search.</div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-slate-50 dark:bg-slate-900 transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
                <div class="p-8 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="text-4xl font-black text-indigo-600 mb-2">30+</div>
                    <div class="text-slate-500 dark:text-slate-400 font-semibold uppercase tracking-wider text-xs">Free Tools</div>
                </div>
                <div class="p-8 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="text-4xl font-black text-indigo-600 mb-2">100%</div>
                    <div class="text-slate-500 dark:text-slate-400 font-semibold uppercase tracking-wider text-xs">Always Free</div>
                </div>
                <div class="p-8 bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-700">
                    <div class="text-4xl font-black text-indigo-600 mb-2">Instant</div>
                    <div class="text-slate-500 dark:text-slate-400 font-semibold uppercase tracking-wider text-xs">Fast Results</div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
