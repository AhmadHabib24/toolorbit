@extends('layouts.app')

@section('title', 'HTTP Header Checker - ToolOrbit')
@section('meta_description', 'View all HTTP response headers for any URL. Analyze Server, Content-Type, Cache-Control, and more for technical SEO.')

@section('content')
<x-tool-layout 
    title="HTTP Header Checker" 
    description="Inspect raw HTTP headers returned by any server for technical analysis."
    category="Technical SEO"
>
    <div x-data="{ 
        url: '',
        loading: false,
        result: null,
        error: '',
        async check() {
            if (!this.url) return;
            this.loading = true;
            this.result = null;
            this.error = '';

            try {
                const response = await fetch('/technical-seo/header-checker', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ url: this.url })
                });
                
                const data = await response.json();
                if (!response.ok) throw new Error(data.error || 'Failed to fetch headers');
                this.result = data;
            } catch (e) {
                this.error = e.message;
            } finally {
                this.loading = false;
            }
        }
    }" class="p-8">
        
        <div class="max-w-3xl mx-auto mb-12">
            <div class="flex space-x-2">
                <input type="text" x-model="url" @keyup.enter="check()" placeholder="https://example.com" class="flex-1 p-6 bg-slate-50 border border-slate-200 rounded-[32px] focus:ring-2 focus:ring-indigo-500 transition-all text-lg">
                <button @click="check()" :disabled="loading" class="btn-primary px-10 rounded-[32px]">
                    <span x-show="!loading">Fetch Headers</span>
                    <svg x-show="loading" class="animate-spin h-6 w-6" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </div>
            <p x-show="error" x-text="error" class="mt-4 text-center text-red-500 font-bold"></p>
        </div>

        <template x-if="result">
            <div class="max-w-5xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
                <div class="flex items-center space-x-4">
                    <div :class="result.status >= 400 ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700'" class="px-6 py-2 rounded-2xl font-black text-2xl">
                        HTTP <span x-text="result.status"></span>
                    </div>
                    <div class="text-slate-500 font-bold uppercase tracking-widest text-sm">Response Received</div>
                </div>

                <div class="bg-slate-900 rounded-[40px] p-10 overflow-hidden shadow-2xl relative">
                    <!-- Copy Button -->
                    <button @click="navigator.clipboard.writeText(JSON.stringify(result.headers, null, 2)); alert('Headers copied!')" class="absolute top-6 right-6 p-4 bg-white/10 hover:bg-white/20 text-white rounded-2xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                    </button>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 font-mono text-sm">
                        <template x-for="(value, key) in result.headers" :key="key">
                            <div class="group border-b border-white/5 pb-4">
                                <span class="text-indigo-400 font-bold block mb-1" x-text="key"></span>
                                <span class="text-slate-300 break-all" x-text="value"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-tool-layout>
@endsection
