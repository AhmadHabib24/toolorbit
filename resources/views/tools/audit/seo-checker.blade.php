@extends('layouts.app')

@section('title', 'On-Page SEO Checker - ToolOrbit')
@section('meta_description', 'Audit your website SEO for free. Check Meta tags, Headers, Images, and Links instantly.')

@section('content')
<x-tool-layout 
    title="On-Page SEO Checker" 
    description="Analyze any URL to find SEO improvements and fix technical issues."
    category="SEO Audit"
>
    <div x-data="{ 
        url: '',
        loading: false,
        error: '',
        result: null,
        async audit() {
            if (!this.url.trim()) return;
            this.loading = true;
            this.error = '';
            this.result = null;
            
            try {
                const response = await fetch('/audit/seo-checker', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ url: this.url })
                });
                
                const data = await response.json();
                if (!response.ok) throw new Error(data.error || 'Audit failed');
                this.result = data;
            } catch (e) {
                this.error = e.message;
            } finally {
                this.loading = false;
            }
        }
    }" class="p-8">
        
        <div class="max-w-4xl mx-auto mb-12">
            <div class="flex space-x-2">
                <input type="text" x-model="url" @keyup.enter="audit()" placeholder="https://example.com" class="flex-1 p-6 bg-slate-50 border border-slate-200 rounded-[32px] focus:ring-2 focus:ring-indigo-500 transition-all text-lg">
                <button @click="audit()" :disabled="loading" class="btn-primary px-10">
                    <span x-show="!loading">Analyze</span>
                    <svg x-show="loading" class="animate-spin h-6 w-6" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </div>
            <p x-show="error" x-text="error" class="mt-4 text-center text-red-500 font-bold"></p>
        </div>

        <template x-if="result">
            <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="p-6 bg-emerald-50 rounded-3xl border border-emerald-100">
                        <div class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-1">Status</div>
                        <div class="text-2xl font-black text-emerald-700" x-text="result.status"></div>
                    </div>
                    <div class="p-6 bg-indigo-50 rounded-3xl border border-indigo-100">
                        <div class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-1">Total Links</div>
                        <div class="text-2xl font-black text-indigo-700" x-text="result.links"></div>
                    </div>
                    <div class="p-6 bg-rose-50 rounded-3xl border border-rose-100">
                        <div class="text-[10px] font-black text-rose-600 uppercase tracking-widest mb-1">Images</div>
                        <div class="text-2xl font-black text-rose-700" x-text="result.images"></div>
                    </div>
                    <div class="p-6 bg-amber-50 rounded-3xl border border-amber-100">
                        <div class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-1">Missing ALT</div>
                        <div class="text-2xl font-black text-amber-700" x-text="result.images_no_alt"></div>
                    </div>
                </div>

                <!-- Detailed Analysis -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="p-8 bg-white rounded-[40px] border border-slate-100 shadow-premium">
                            <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                Meta Information
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Meta Title</label>
                                    <p class="text-slate-700 font-medium" x-text="result.title"></p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Meta Description</label>
                                    <p class="text-slate-600 text-sm leading-relaxed" x-text="result.description"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 bg-white rounded-[40px] border border-slate-100 shadow-premium">
                        <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            Heading Structure
                        </h3>
                        <div class="space-y-4 max-h-60 overflow-y-auto pr-4 custom-scrollbar">
                            <template x-for="h in result.h1" :key="h">
                                <div class="flex items-start">
                                    <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 text-[10px] font-bold rounded mr-3 mt-1">H1</span>
                                    <p class="text-slate-700 text-sm font-bold" x-text="h"></p>
                                </div>
                            </template>
                            <template x-for="h in result.h2" :key="h">
                                <div class="flex items-start">
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-bold rounded mr-3 mt-1">H2</span>
                                    <p class="text-slate-600 text-sm" x-text="h"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-tool-layout>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>
@endsection
