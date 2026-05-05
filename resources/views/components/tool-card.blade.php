@props(['category', 'title', 'description', 'href', 'icon'])

<a href="{{ $href }}" class="group block p-8 bg-white rounded-[40px] border border-slate-100 shadow-premium hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 relative overflow-hidden">
    <!-- Hover Gradient -->
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
    
    <div class="relative z-10">
        <div class="w-14 h-14 bg-slate-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
            {!! $icon !!}
        </div>
        
        <div class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-2 opacity-60">{{ $category }}</div>
        <h3 class="text-xl font-black text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors">{{ $title }}</h3>
        <p class="text-slate-500 text-sm leading-relaxed">{{ $description }}</p>
    </div>

    <!-- Arrow Icon -->
    <div class="absolute bottom-8 right-8 opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 transition-all duration-500">
        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
        </svg>
    </div>
</a>
