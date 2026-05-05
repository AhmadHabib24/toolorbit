@extends('layouts.app')

@section('title', 'Website Screenshot Generator - ToolOrbit')
@section('meta_description', 'Generate a high-quality screenshot of any website URL instantly. Perfect for portfolios and design mockups.')

@section('content')
<x-tool-layout 
    title="Website Screenshot" 
    description="Capture a full-size screenshot of any website by simply entering its URL."
    category="Visual Tools"
>
    <div x-data="{ 
        url: '',
        loading: false,
        imgUrl: '',
        generate() {
            if (!this.url.trim()) return;
            this.loading = true;
            this.imgUrl = '';
            
            // Clean URL
            let cleanUrl = this.url.trim().replace(/^https?:\/\//, '');
            this.imgUrl = `https://s0.wp.com/mshots/v1/https://${cleanUrl}?w=1280&h=960`;
            
            // Artificial delay for effect
            setTimeout(() => { this.loading = false; }, 2000);
        },
        download() {
            if (!this.imgUrl) return;
            const a = document.createElement('a');
            a.href = this.imgUrl;
            a.download = 'screenshot.jpg';
            a.target = '_blank';
            a.click();
        }
    }" class="p-8">
        
        <div class="max-w-4xl mx-auto space-y-8">
            <div class="flex space-x-2">
                <input type="text" x-model="url" @keyup.enter="generate()" placeholder="https://google.com" class="flex-1 p-6 bg-slate-50 border border-slate-200 rounded-[32px] focus:ring-2 focus:ring-indigo-500 transition-all text-lg">
                <button @click="generate()" :disabled="loading" class="btn-primary px-10">
                    <span x-show="!loading">Capture</span>
                    <svg x-show="loading" class="animate-spin h-6 w-6" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </div>

            <!-- Preview -->
            <div class="relative min-h-[400px] bg-slate-100 rounded-[48px] border-8 border-white shadow-2xl overflow-hidden flex items-center justify-center">
                <template x-if="imgUrl && !loading">
                    <img :src="imgUrl" class="w-full h-full object-cover animate-in zoom-in-95 duration-700" @load="loading = false">
                </template>
                <template x-if="!imgUrl && !loading">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-white rounded-3xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">Enter URL to capture</p>
                    </div>
                </template>
                <div x-show="loading" class="flex flex-col items-center">
                    <div class="w-16 h-16 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin mb-4"></div>
                    <p class="text-indigo-600 font-bold">Capturing Screenshot...</p>
                </div>
            </div>

            <div x-show="imgUrl && !loading" class="flex justify-center">
                <button @click="download()" class="btn-primary py-4 px-12 rounded-2xl flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <span>Download Screenshot</span>
                </button>
            </div>
        </div>
    </div>
</x-tool-layout>
@endsection
