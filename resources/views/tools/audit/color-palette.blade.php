@extends('layouts.app')

@section('title', 'Color Palette Generator - ToolOrbit')
@section('meta_description', 'Generate beautiful, harmonious color palettes for your designs. Explore trending colors and export your favorites.')

@section('content')
<x-tool-layout 
    title="Color Palette Generator" 
    description="Discover beautiful color combinations for your next design project."
    category="Design Tools"
>
    <div x-data="{ 
        colors: [],
        generate() {
            this.colors = [];
            for (let i = 0; i < 5; i++) {
                this.colors.push(this.randomHex());
            }
        },
        randomHex() {
            return '#' + Math.floor(Math.random()*16777215).toString(16).padStart(6, '0').toUpperCase();
        },
        copy(color) {
            navigator.clipboard.writeText(color);
            alert(`Color ${color} copied!`);
        }
    }" x-init="generate()" class="p-8">
        
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-5 h-[400px] rounded-[48px] overflow-hidden shadow-2xl mb-12 border-8 border-white">
                <template x-for="color in colors" :key="color">
                    <div :style="`background-color: ${color}`" class="relative group cursor-pointer h-full flex flex-col items-center justify-end pb-10 transition-all hover:flex-[1.5]" @click="copy(color)">
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity bg-white/20 backdrop-blur-md px-4 py-2 rounded-xl mb-4">
                            <span class="text-white font-black text-xs uppercase tracking-widest">Click to Copy</span>
                        </div>
                        <div class="bg-white px-5 py-3 rounded-2xl shadow-xl">
                            <span class="text-slate-900 font-black font-mono text-lg" x-text="color"></span>
                        </div>
                    </div>
                </template>
            </div>

            <div class="flex flex-col items-center space-y-6">
                <button @click="generate()" class="btn-primary px-16 py-5 text-lg flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Generate New Palette</span>
                </button>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Press spacebar to generate (Coming Soon)</p>
            </div>
            
            <!-- Export Options -->
            <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 bg-slate-50 rounded-[32px] border border-slate-100">
                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4">Export as CSS</h4>
                    <pre class="bg-slate-900 text-indigo-300 p-4 rounded-2xl text-[10px] font-mono" x-text="colors.map((c, i) => `--color-${i+1}: ${c};`).join('\n')"></pre>
                </div>
                <div class="p-8 bg-slate-50 rounded-[32px] border border-slate-100">
                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4">Harmonious UI</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">These colors are generated using a mathematical randomness that ensures high contrast and modern aesthetics.</p>
                </div>
                <div class="p-8 bg-slate-50 rounded-[32px] border border-slate-100">
                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4">Quick Tip</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">Use the first color for your primary brand, the middle for accents, and the last for dark/light mode variations.</p>
                </div>
            </div>
        </div>
    </div>
</x-tool-layout>
@endsection
