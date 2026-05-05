@extends('layouts.app')

@section('title', 'WHOIS Lookup - ToolOrbit')
@section('meta_description', 'Check domain registration details, owner information, expiry dates, and name servers with our free WHOIS lookup tool.')

@section('content')
<x-tool-layout 
    title="WHOIS Lookup" 
    description="Retrieve comprehensive registration data for any domain name."
    category="Website Tracking"
>
    <div x-data="{ 
        domain: '',
        loading: false,
        error: '',
        result: null,
        async lookup() {
            if (!this.domain) return;
            this.loading = true;
            this.error = '';
            this.result = null;
            
            try {
                const response = await fetch('/analysis/whois-lookup', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ domain: this.domain })
                });
                
                const data = await response.json();
                if (!response.ok) throw new Error(data.error || 'Failed to fetch WHOIS data');
                this.result = data;
            } catch (e) {
                this.error = e.message;
            } finally {
                this.loading = false;
            }
        }
    }" class="p-8">
        
        <div class="max-w-2xl mx-auto mb-12">
            <label class="block text-sm font-bold text-slate-700 mb-2">Enter Domain Name:</label>
            <div class="flex space-x-2">
                <input type="text" x-model="domain" placeholder="example.com" class="flex-1 p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                <button @click="lookup()" :disabled="loading" class="btn-primary">
                    <span x-show="!loading">Lookup</span>
                    <svg x-show="loading" class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </div>
            <p x-show="error" x-text="error" class="mt-2 text-sm text-red-500 font-medium"></p>
        </div>

        <template x-if="result">
            <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-6 bg-indigo-50 rounded-3xl border border-indigo-100">
                        <div class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Registrar</div>
                        <div class="font-bold text-slate-900 truncate" x-text="result.registrar || 'N/A'"></div>
                    </div>
                    <div class="p-6 bg-cyan-50 rounded-3xl border border-cyan-100">
                        <div class="text-[10px] font-black text-cyan-400 uppercase tracking-widest mb-1">Creation Date</div>
                        <div class="font-bold text-slate-900" x-text="result.createdDate ? new Date(result.createdDate).toLocaleDateString() : 'N/A'"></div>
                    </div>
                    <div class="p-6 bg-emerald-50 rounded-3xl border border-emerald-100">
                        <div class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-1">Expiry Date</div>
                        <div class="font-bold text-slate-900" x-text="result.expiresDate ? new Date(result.expiresDate).toLocaleDateString() : 'N/A'"></div>
                    </div>
                </div>

                <!-- Full Raw Data -->
                <div class="p-6 bg-slate-900 rounded-3xl overflow-hidden">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest">Raw WHOIS Data</h4>
                        <button @click="navigator.clipboard.writeText(result.rawText); alert('Copied!')" class="text-[10px] font-bold text-indigo-400 hover:text-indigo-300">Copy Raw Text</button>
                    </div>
                    <pre class="text-xs font-mono text-indigo-300 overflow-x-auto whitespace-pre-wrap max-h-96" x-text="result.rawText || 'No raw data available'"></pre>
                </div>
            </div>
        </template>
    </div>
</x-tool-layout>
@endsection
