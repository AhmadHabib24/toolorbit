@extends('layouts.app')

@section('title', 'SSL Certificate Checker - ToolOrbit')
@section('meta_description', 'Verify SSL certificate status, expiry date, and issuer information for any website. Ensure your site is secure.')

@section('content')
<x-tool-layout 
    title="SSL Certificate Checker" 
    description="Analyze SSL certificate details and check validity of any domain."
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
                const response = await fetch('/technical-seo/ssl-checker', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ url: this.url })
                });
                
                const data = await response.json();
                if (!response.ok) throw new Error(data.error || 'Failed to check SSL');
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
                <input type="text" x-model="url" @keyup.enter="check()" placeholder="example.com" class="flex-1 p-6 bg-slate-50 border border-slate-200 rounded-[32px] focus:ring-2 focus:ring-indigo-500 transition-all text-lg">
                <button @click="check()" :disabled="loading" class="btn-primary px-10 rounded-[32px]">
                    <span x-show="!loading">Check SSL</span>
                    <svg x-show="loading" class="animate-spin h-6 w-6" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </div>
            <p x-show="error" x-text="error" class="mt-4 text-center text-red-500 font-bold"></p>
        </div>

        <template x-if="result">
            <div class="max-w-4xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-500">
                <div class="p-1 rounded-[40px] bg-gradient-to-br from-indigo-500 to-cyan-500 shadow-2xl">
                    <div class="bg-white rounded-[39px] p-10">
                        <div class="flex items-center justify-between mb-10 pb-10 border-b border-slate-100">
                            <div>
                                <h3 class="text-3xl font-black text-slate-900" x-text="result.subject"></h3>
                                <p class="text-slate-500">Certificate Status</p>
                            </div>
                            <div :class="result.is_valid ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'" class="px-6 py-2 rounded-full font-black text-sm uppercase tracking-widest">
                                <span x-text="result.is_valid ? 'Secure / Valid' : 'Invalid / Expired'"></span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-6">
                                <div>
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Issuer Name</label>
                                    <p class="text-slate-700 font-bold" x-text="result.issuer"></p>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Signature Type</label>
                                    <p class="text-slate-700 font-bold" x-text="result.signature_type"></p>
                                </div>
                            </div>
                            <div class="space-y-6">
                                <div>
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Valid From</label>
                                    <p class="text-slate-700 font-bold" x-text="result.valid_from"></p>
                                </div>
                                <div>
                                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Expiry Date</label>
                                    <p class="text-rose-600 font-black" x-text="result.valid_until"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-tool-layout>
@endsection
