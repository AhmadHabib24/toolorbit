@extends('layouts.app')

@section('title', 'Binary Converter - ToolOrbit')
@section('meta_description', 'Convert text to binary and binary to text with our free online converter. Quick, easy, and accurate.')

@section('content')
<x-tool-layout 
    title="Binary Converter" 
    description="Easily translate between human-readable text and computer binary code."
    category="Developer Utilities"
>
    <div x-data="{ 
        input: '',
        output: '',
        mode: 'textToBinary',
        process() {
            if (!this.input) {
                this.output = '';
                return;
            }
            
            if (this.mode === 'textToBinary') {
                this.output = this.input.split('').map(char => {
                    return char.charCodeAt(0).toString(2).padStart(8, '0');
                }).join(' ');
            } else {
                try {
                    const binary = this.input.replace(/\s/g, '');
                    let res = '';
                    for (let i = 0; i < binary.length; i += 8) {
                        res += String.fromCharCode(parseInt(binary.substr(i, 8), 2));
                    }
                    this.output = res;
                } catch (e) {
                    this.output = 'Invalid binary sequence';
                }
            }
        },
        copy() {
            if (!this.output) return;
            navigator.clipboard.writeText(this.output);
            alert('Copied to clipboard!');
        }
    }" class="p-8">
        
        <div class="space-y-6">
            <div class="flex justify-center mb-8">
                <div class="inline-flex p-1 bg-slate-100 rounded-2xl">
                    <button @click="mode = 'textToBinary'; process()" :class="mode === 'textToBinary' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500'" class="px-8 py-2 rounded-xl text-sm font-bold transition-all">Text to Binary</button>
                    <button @click="mode = 'binaryToText'; process()" :class="mode === 'binaryToText' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500'" class="px-8 py-2 rounded-xl text-sm font-bold transition-all">Binary to Text</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2" x-text="mode === 'textToBinary' ? 'Your Text:' : 'Binary Code:'"></label>
                    <textarea 
                        x-model="input" 
                        @input="process()"
                        rows="12" 
                        :placeholder="mode === 'textToBinary' ? 'Type your message here...' : 'e.g. 01001000 01100101 01101100 01101100 01101111'" 
                        class="w-full p-6 bg-slate-50 border border-slate-200 rounded-[32px] focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 transition-all font-mono"
                    ></textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Output:</label>
                    <div class="relative h-full">
                        <textarea 
                            x-model="output" 
                            readonly
                            rows="12" 
                            class="w-full h-[324px] p-6 bg-slate-900 text-cyan-300 font-mono text-sm rounded-[32px] border-none focus:ring-0"
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
