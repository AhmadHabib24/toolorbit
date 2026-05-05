@extends('layouts.app')

@section('title', 'Placeholder Image Generator - ToolOrbit')
@section('meta_description', 'Generate custom placeholder images for your web designs. Choose size, color, and text instantly.')

@section('content')
<x-tool-layout 
    title="Placeholder Generator" 
    description="Create custom dummy images for your design mockups and prototypes."
    category="Design Utilities"
>
    <div x-data="{ 
        width: 800,
        height: 450,
        bgColor: '6366f1',
        textColor: 'ffffff',
        text: '',
        get imgUrl() {
            let url = `https://placehold.co/${this.width}x${this.height}/${this.bgColor}/${this.textColor}`;
            if (this.text) url += `?text=${encodeURIComponent(this.text)}`;
            return url;
        },
        copy() {
            navigator.clipboard.writeText(this.imgUrl);
            alert('URL copied!');
        }
    }" class="p-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <!-- Controls -->
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Width (px):</label>
                        <input type="number" x-model="width" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Height (px):</label>
                        <input type="number" x-model="height" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Custom Text (Optional):</label>
                    <input type="text" x-model="text" placeholder="800 x 450" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Background Color:</label>
                        <div class="flex space-x-2">
                            <input type="color" x-model="bgColor" @input="bgColor = $event.target.value.replace('#', '')" class="w-14 h-14 p-1 rounded-xl cursor-pointer">
                            <input type="text" x-model="bgColor" class="flex-1 p-4 bg-slate-50 border border-slate-200 rounded-2xl font-mono">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Text Color:</label>
                        <div class="flex space-x-2">
                            <input type="color" x-model="textColor" @input="textColor = $event.target.value.replace('#', '')" class="w-14 h-14 p-1 rounded-xl cursor-pointer">
                            <input type="text" x-model="textColor" class="flex-1 p-4 bg-slate-50 border border-slate-200 rounded-2xl font-mono">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview -->
            <div class="bg-white rounded-[40px] border border-slate-100 shadow-premium p-10 text-center">
                <div class="aspect-video w-full bg-slate-50 rounded-[32px] mb-8 overflow-hidden border-2 border-dashed border-slate-200 flex items-center justify-center">
                    <img :src="imgUrl" class="max-w-full max-h-full shadow-lg">
                </div>
                
                <div class="flex flex-col space-y-3">
                    <button @click="copy()" class="btn-primary py-4 rounded-2xl flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                        <span>Copy Image URL</span>
                    </button>
                    <a :href="imgUrl" target="_blank" class="text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors">Open in New Tab</a>
                </div>
            </div>
        </div>
    </div>
</x-tool-layout>
@endsection
