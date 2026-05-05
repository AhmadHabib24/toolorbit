@extends('layouts.app')

@section('title', 'MD5 Hash Generator - ToolOrbit')
@section('meta_description', 'Generate MD5 hashes for any text string instantly. Free, secure, and easy-to-use MD5 generator.')

@section('content')
<x-tool-layout 
    title="MD5 Hash Generator" 
    description="Generate a unique 32-character MD5 hash for any string."
    category="Security Tools"
>
    <div x-data="{ 
        text: '',
        hash: '',
        async generate() {
            if (!this.text) {
                this.hash = '';
                return;
            }
            
            try {
                const response = await fetch('/security/md5-generator', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ text: this.text })
                });
                const data = await response.json();
                this.hash = data.hash;
            } catch (e) {
                console.error(e);
            }
        },
        copy() {
            if (!this.hash) return;
            navigator.clipboard.writeText(this.hash);
            alert('Hash copied!');
        }
    }" class="p-8">
        
        <div class="space-y-8">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Input String:</label>
                <textarea 
                    x-model="text" 
                    @input="generate()"
                    rows="6" 
                    placeholder="Enter the text you want to hash..." 
                    class="w-full p-6 bg-slate-50 border border-slate-200 rounded-[32px] focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 transition-all"
                ></textarea>
            </div>

            <template x-if="hash">
                <div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Generated MD5 Hash:</label>
                    <div class="relative group">
                        <div class="w-full p-6 bg-indigo-600 text-white font-mono text-xl md:text-2xl break-all rounded-[32px] shadow-xl shadow-indigo-100" x-text="hash"></div>
                        <button @click="copy()" class="absolute top-1/2 -translate-y-1/2 right-4 p-3 bg-white/10 hover:bg-white/20 text-white rounded-2xl transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                        </button>
                    </div>
                </div>
            </template>

            <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100">
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">What is MD5?</h4>
                <p class="text-sm text-slate-600 leading-relaxed">
                    MD5 (Message-Digest algorithm 5) is a widely used cryptographic hash function that produces a 128-bit hash value. While no longer considered secure for cryptographic purposes, it is still frequently used to verify data integrity and for non-sensitive identification.
                </p>
            </div>
        </div>
    </div>
</x-tool-layout>
@endsection
