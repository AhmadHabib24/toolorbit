@extends('layouts.app')

@section('title', 'RGB to Hex Converter - ToolOrbit')
@section('meta_description', 'Convert RGB color values to Hexadecimal color codes with our free online tool. Includes real-time color preview.')

@section('content')
<x-tool-layout 
    title="RGB to Hex Converter" 
    description="Find the perfect color code for your design projects."
    category="Design Utilities"
>
    <div x-data="{ 
        r: 79,
        g: 70,
        b: 229,
        get hex() {
            const componentToHex = (c) => {
                const hex = parseInt(c).toString(16);
                return hex.length == 1 ? '0' + hex : hex;
            }
            return '#' + componentToHex(this.r) + componentToHex(this.g) + componentToHex(this.b);
        },
        copy() {
            navigator.clipboard.writeText(this.hex.toUpperCase());
            alert('Hex code copied!');
        }
    }" class="p-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Controls -->
            <div class="space-y-8">
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-bold text-slate-700">Red (R)</label>
                        <input type="number" x-model="r" min="0" max="255" class="w-16 p-1 text-center bg-slate-50 border border-slate-200 rounded-lg text-sm font-bold">
                    </div>
                    <input type="range" x-model="r" min="0" max="255" class="w-full h-2 bg-slate-100 rounded-lg appearance-none cursor-pointer accent-red-500">
                </div>
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-bold text-slate-700">Green (G)</label>
                        <input type="number" x-model="g" min="0" max="255" class="w-16 p-1 text-center bg-slate-50 border border-slate-200 rounded-lg text-sm font-bold">
                    </div>
                    <input type="range" x-model="g" min="0" max="255" class="w-full h-2 bg-slate-100 rounded-lg appearance-none cursor-pointer accent-green-500">
                </div>
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-bold text-slate-700">Blue (B)</label>
                        <input type="number" x-model="b" min="0" max="255" class="w-16 p-1 text-center bg-slate-50 border border-slate-200 rounded-lg text-sm font-bold">
                    </div>
                    <input type="range" x-model="b" min="0" max="255" class="w-full h-2 bg-slate-100 rounded-lg appearance-none cursor-pointer accent-blue-500">
                </div>
            </div>

            <!-- Preview Card -->
            <div class="bg-white rounded-[40px] border border-slate-100 shadow-premium p-8 text-center">
                <div class="w-full h-48 rounded-[32px] mb-6 shadow-inner transition-colors duration-200" :style="`background-color: ${hex}`"></div>
                
                <div class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Hexadecimal Code</div>
                <div class="text-4xl font-black text-slate-900 mb-6" x-text="hex.toUpperCase()"></div>
                
                <button @click="copy()" class="w-full btn-primary py-4 rounded-2xl flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                    <span>Copy Hex Code</span>
                </button>
            </div>
        </div>
    </div>
</x-tool-layout>
@endsection
