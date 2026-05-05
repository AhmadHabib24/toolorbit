@extends('layouts.app')

@section('title', 'JavaScript Minifier - ToolOrbit')
@section('meta_description', 'Compress your JavaScript code by removing comments and whitespace. Optimize your JS for production and faster load times.')

@section('content')
<x-tool-layout 
    title="JS Minifier" 
    description="Optimize your JavaScript code for production by stripping unnecessary whitespace and comments."
    category="Developer Tools"
>
    <div x-data="{ 
        code: '',
        result: '',
        loading: false,
        async minify() {
            if (!this.code.trim()) return;
            this.loading = true;
            
            try {
                const response = await fetch('/dev/js-minifier', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ code: this.code })
                });
                
                const data = await response.json();
                this.result = data.result;
            } catch (e) {
                alert('Error minifying code.');
            } finally {
                this.loading = false;
            }
        },
        copy() {
            navigator.clipboard.writeText(this.result);
            alert('Minified code copied!');
        }
    }" class="p-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <label class="text-sm font-bold text-slate-700">Source Code:</label>
                    <button @click="code = ''" class="text-xs text-rose-500 font-bold hover:underline">Clear</button>
                </div>
                <textarea 
                    x-model="code" 
                    rows="15" 
                    placeholder="function hello() {&#10;  console.log('Hello World');&#10;}" 
                    class="w-full p-6 bg-slate-50 border border-slate-200 rounded-[32px] focus:ring-2 focus:ring-indigo-500 transition-all font-mono text-sm"
                ></textarea>
                <button @click="minify()" :disabled="loading" class="w-full btn-primary py-4 rounded-2xl font-bold flex items-center justify-center">
                    <span x-show="!loading">Compress JS</span>
                    <svg x-show="loading" class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <label class="text-sm font-bold text-slate-700">Minified Code:</label>
                    <button x-show="result" @click="copy()" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Copy Minified</button>
                </div>
                <div class="h-[365px] p-8 bg-slate-900 rounded-[32px] overflow-hidden relative group">
                    <textarea 
                        x-model="result" 
                        readonly 
                        class="w-full h-full bg-transparent border-none focus:ring-0 text-emerald-400 font-mono text-xs overflow-y-auto"
                    ></textarea>
                </div>
                
                <template x-if="result">
                    <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center justify-between animate-in fade-in slide-in-from-top-2">
                        <div class="text-xs font-bold text-emerald-700">Optimization Complete</div>
                        <div class="text-[10px] font-black bg-emerald-600 text-white px-2 py-1 rounded">READY FOR PROD</div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-tool-layout>
@endsection
