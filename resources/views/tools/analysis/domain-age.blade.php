@extends('layouts.app')

@section('title', 'Domain Age Checker - ToolOrbit')
@section('meta_description', 'Find out the exact age of any domain name. Useful for SEO and domain research.')

@section('content')
<x-tool-layout 
    title="Domain Age Checker" 
    description="Check how old a domain is and when it was first registered."
    category="Website Tracking"
>
    <div x-data="{ 
        domain: '',
        loading: false,
        error: '',
        result: null,
        async check() {
            if (!this.domain) return;
            this.loading = true;
            this.error = '';
            this.result = null;
            
            try {
                const response = await fetch('/analysis/domain-age-checker', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ domain: this.domain })
                });
                
                const data = await response.json();
                if (!response.ok) throw new Error(data.error || 'Failed to fetch data');
                this.result = data;
            } catch (e) {
                this.error = e.message;
            } finally {
                this.loading = false;
            }
        }
    }" class="p-8">
        
        <div class="max-w-2xl mx-auto mb-12">
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Enter Domain Name:</label>
            <div class="flex space-x-2">
                <input type="text" x-model="domain" placeholder="google.com" class="input-base">
                <button @click="check()" :disabled="loading" class="btn-primary">
                    <span x-show="!loading">Check Age</span>
                    <svg x-show="loading" class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </div>
            <p x-show="error" x-text="error" class="mt-2 text-sm text-red-500 font-medium"></p>
        </div>

        <template x-if="result">
            <div class="max-w-3xl mx-auto animate-in fade-in slide-in-from-bottom-4 duration-500">
                <div class="bg-white dark:bg-slate-900 rounded-[40px] border border-slate-100 dark:border-slate-800 shadow-premium p-10 text-center">
                    <div class="text-[10px] font-black text-indigo-400 dark:text-indigo-500 uppercase tracking-widest mb-4">Domain Age for <span class="text-slate-900 dark:text-white" x-text="result.domain"></span></div>
                    
                    <div class="flex justify-center items-center space-x-6 mb-10">
                        <div class="text-center">
                            <div class="text-5xl font-black text-indigo-600 dark:text-indigo-400" x-text="result.age.years"></div>
                            <div class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase">Years</div>
                        </div>
                        <div class="text-4xl font-light text-slate-200 dark:text-slate-700">/</div>
                        <div class="text-center">
                            <div class="text-5xl font-black text-indigo-600 dark:text-indigo-400" x-text="result.age.months"></div>
                            <div class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase">Months</div>
                        </div>
                        <div class="text-4xl font-light text-slate-200 dark:text-slate-700">/</div>
                        <div class="text-center">
                            <div class="text-5xl font-black text-indigo-600 dark:text-indigo-400" x-text="result.age.days"></div>
                            <div class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase">Days</div>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-slate-50 dark:border-slate-800 flex justify-center space-x-12">
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase mb-1">Created On</div>
                            <div class="font-bold text-slate-900 dark:text-white" x-text="new Date(result.created).toLocaleDateString(undefined, { dateStyle: 'long' })"></div>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase mb-1">Status</div>
                            <div class="flex items-center text-emerald-500 font-bold">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span>
                                Active
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-tool-layout>
@endsection
