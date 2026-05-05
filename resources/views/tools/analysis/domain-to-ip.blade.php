@extends('layouts.app')

@section('title', 'Domain to IP Converter - ToolOrbit')
@section('meta_description', 'Convert any domain name to its corresponding IP address instantly with our free online tool.')

@section('content')
<x-tool-layout 
    title="Domain to IP" 
    description="Find the IP address of any website or domain name."
    category="Website Tracking"
>
    <div x-data="{ 
        domain: '',
        loading: false,
        error: '',
        result: null,
        async process() {
            if (!this.domain) return;
            this.loading = true;
            this.error = '';
            this.result = null;
            
            try {
                const response = await fetch('/analysis/domain-to-ip', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ domain: this.domain })
                });
                
                const data = await response.json();
                if (!response.ok) throw new Error(data.error || 'Failed to resolve domain');
                this.result = data;
            } catch (e) {
                this.error = e.message;
            } finally {
                this.loading = false;
            }
        }
    }" class="p-8">
        
        <div class="max-w-xl mx-auto mb-12">
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Enter Domain Name:</label>
            <div class="flex space-x-2">
                <input type="text" x-model="domain" placeholder="example.com" class="input-base">
                <button @click="process()" :disabled="loading" class="btn-primary">
                    <span x-show="!loading">Convert</span>
                    <svg x-show="loading" class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </div>
            <p x-show="error" x-text="error" class="mt-2 text-sm text-red-500"></p>
        </div>

        <template x-if="result">
            <div class="bg-indigo-50 dark:bg-indigo-900/30 p-8 rounded-3xl border border-indigo-100 dark:border-indigo-800 text-center max-w-lg mx-auto">
                <div class="text-[10px] font-bold text-indigo-400 dark:text-indigo-500 uppercase tracking-widest mb-2">IP Address for <span x-text="result.domain"></span></div>
                <div class="text-4xl font-black text-indigo-600 dark:text-indigo-400 font-mono" x-text="result.ip"></div>
            </div>
        </template>
    </div>
</x-tool-layout>
@endsection
