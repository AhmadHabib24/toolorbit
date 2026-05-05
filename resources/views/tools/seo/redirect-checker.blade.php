@extends('layouts.app')

@section('title', 'Redirect & Status Code Checker - ToolOrbit')
@section('meta_description', 'Trace URL redirect chains (301, 302) and find the final destination status. Essential for fixing broken links and migration audits.')

@section('content')
<x-tool-layout 
    title="Redirect Chain Checker" 
    description="Analyze redirect paths and verify HTTP status codes for any URL."
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
                const response = await fetch('/technical-seo/redirect-checker', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ url: this.url })
                });
                
                const data = await response.json();
                if (!response.ok) throw new Error(data.error || 'Failed to trace redirects');
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
                <input type="text" x-model="url" @keyup.enter="check()" placeholder="https://example.com/old-page" class="flex-1 p-6 bg-slate-50 border border-slate-200 rounded-[32px] focus:ring-2 focus:ring-indigo-500 transition-all text-lg">
                <button @click="check()" :disabled="loading" class="btn-primary px-10 rounded-[32px]">
                    <span x-show="!loading">Trace Path</span>
                    <svg x-show="loading" class="animate-spin h-6 w-6" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </div>
            <p x-show="error" x-text="error" class="mt-4 text-center text-red-500 font-bold"></p>
        </div>

        <template x-if="result">
            <div class="max-w-4xl mx-auto space-y-12 animate-in fade-in slide-in-from-bottom-4 duration-500">
                
                <!-- Visualization -->
                <div class="relative">
                    <div class="flex flex-col items-center space-y-8">
                        <!-- Origin -->
                        <div class="w-full max-w-lg p-6 bg-white border border-slate-100 rounded-3xl shadow-sm">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Origin URL</label>
                            <p class="text-slate-900 font-medium truncate" x-text="url"></p>
                        </div>

                        <!-- Redirect Info -->
                        <div class="flex flex-col items-center space-y-2">
                            <div class="w-1 h-12 bg-indigo-200 rounded-full"></div>
                            <div class="px-6 py-2 bg-indigo-600 text-white rounded-full text-sm font-black uppercase tracking-widest shadow-lg shadow-indigo-500/20">
                                <span x-text="result.redirect_count"></span> Redirects Found
                            </div>
                            <div class="w-1 h-12 bg-indigo-200 rounded-full"></div>
                        </div>

                        <!-- Destination -->
                        <div class="w-full max-w-lg p-10 bg-indigo-600 rounded-[40px] shadow-2xl shadow-indigo-500/30 text-center">
                            <label class="text-[10px] font-black text-indigo-200 uppercase tracking-widest block mb-2">Final Destination</label>
                            <p class="text-white font-bold text-xl mb-6 break-all" x-text="result.final_url"></p>
                            <div class="inline-flex items-center px-6 py-2 bg-white/20 text-white rounded-2xl font-black text-lg">
                                HTTP <span class="ml-2" x-text="result.status_code"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="p-8 bg-slate-50 rounded-3xl border border-slate-100 flex items-start space-x-4">
                    <svg class="w-6 h-6 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h4 class="font-bold text-slate-900 mb-2">Why check redirects?</h4>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Redirect chains can slow down your website and dilute SEO link equity (Link Juice). Ensuring a 1-step redirect directly to the final URL is a best practice for technical SEO.
                        </p>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-tool-layout>
@endsection
