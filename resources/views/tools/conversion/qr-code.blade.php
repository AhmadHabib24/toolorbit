@extends('layouts.app')

@section('title', 'QR Code Generator - ToolOrbit')
@section('meta_description', 'Generate custom QR codes for URLs, text, or phone numbers instantly. Free, high-quality, and easy to download.')

@section('content')
<x-tool-layout 
    title="QR Code Generator" 
    description="Create instant QR codes for your marketing and personal needs."
    category="Utilities"
>
    <div x-data="{ 
        text: '',
        size: 200,
        margin: 1,
        get qrUrl() {
            if (!this.text.trim()) return '';
            return `https://api.qrserver.com/v1/create-qr-code/?size=${this.size}x${this.size}&data=${encodeURIComponent(this.text)}&margin=${this.margin}`;
        },
        download() {
            if (!this.qrUrl) return;
            const a = document.createElement('a');
            a.href = this.qrUrl;
            a.download = 'qrcode.png';
            a.target = '_blank';
            a.click();
        }
    }" class="p-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Enter Content (URL or Text):</label>
                    <textarea 
                        x-model="text" 
                        rows="4" 
                        placeholder="https://toolorbit.com" 
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all"
                    ></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Size (px):</label>
                        <select x-model="size" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                            <option value="150">150 x 150</option>
                            <option value="200">200 x 200</option>
                            <option value="300">300 x 300</option>
                            <option value="400">400 x 400</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Margin:</label>
                        <select x-model="margin" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                            <option value="0">No Margin</option>
                            <option value="1">Small</option>
                            <option value="4">Large</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="bg-white rounded-[40px] border border-slate-100 shadow-premium p-10 text-center flex flex-col items-center">
                <div class="w-64 h-64 bg-slate-50 rounded-3xl mb-8 flex items-center justify-center overflow-hidden border-2 border-dashed border-slate-200">
                    <template x-if="qrUrl">
                        <img :src="qrUrl" alt="QR Code" class="w-full h-full object-contain p-2">
                    </template>
                    <template x-if="!qrUrl">
                        <div class="text-slate-300 text-sm font-bold">QR Code Preview</div>
                    </template>
                </div>
                
                <button @click="download()" :disabled="!qrUrl" class="w-full btn-primary py-4 rounded-2xl flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <span>Download PNG</span>
                </button>
            </div>
        </div>
    </div>
</x-tool-layout>
@endsection
