@extends('layouts.app')

@section('title', 'URL Encoder/Decoder - ToolOrbit')
@section('meta_description', 'Easily encode or decode URLs to make them web-safe. Essential for SEOs and web developers handling parameters.')

@section('content')
<x-tool-layout 
    title="URL Encoder/Decoder" 
    description="Transform any text into a web-safe URL format or decode it back to readable text."
    category="SEO Utilities"
>
    <div x-data="{ 
        input: '',
        output: '',
        mode: 'encode',
        async process() {
            if (!this.input.trim()) {
                this.output = '';
                return;
            }
            
            try {
                const response = await fetch('/audit/url-encoder-decoder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ text: this.input, type: this.mode })
                });
                
                const data = await response.json();
                this.output = data.result;
            } catch (e) {
                this.output = 'Error processing request';
            }
        },
        copy() {
            if (!this.output) return;
            navigator.clipboard.writeText(this.output);
            alert('Result copied!');
        }
    }" class="p-8">
        
        <div class="space-y-6">
            <!-- Mode Switcher -->
            <div class="flex justify-center mb-8">
                <div class="inline-flex p-1 bg-slate-100 rounded-2xl">
                    <button @click="mode = 'encode'; process()" :class="mode === 'encode' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500'" class="px-8 py-2 rounded-xl text-sm font-bold transition-all">Encode</button>
                    <button @click="mode = 'decode'; process()" :class="mode === 'decode' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500'" class="px-8 py-2 rounded-xl text-sm font-bold transition-all">Decode</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Input URL / Text:</label>
                    <textarea 
                        x-model="input" 
                        @input="process()"
                        rows="12" 
                        placeholder="https://example.com/search?q=hello world" 
                        class="w-full p-6 bg-slate-50 border border-slate-200 rounded-[32px] focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 transition-all font-mono"
                    ></textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Result:</label>
                    <div class="relative h-full">
                        <textarea 
                            x-model="output" 
                            readonly
                            rows="12" 
                            class="w-full h-[324px] p-6 bg-slate-900 text-indigo-300 font-mono text-sm rounded-[32px] border-none focus:ring-0"
                        ></textarea>
                        <button @click="copy()" class="absolute bottom-6 right-6 p-4 bg-white/10 hover:bg-white/20 text-white rounded-2xl transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tool-layout>
@endsection
