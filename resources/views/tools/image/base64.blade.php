@extends('layouts.app')

@section('title', 'Image to Base64 Converter - ToolOrbit')
@section('meta_description', 'Convert any image file into a Base64 string instantly. Perfect for embedding images directly in CSS or HTML.')

@section('content')
<x-tool-layout 
    title="Image to Base64" 
    description="Easily convert images to data URI strings for optimized web development."
    category="Image Utilities"
>
    <div x-data="{ 
        base64: '',
        loading: false,
        error: '',
        fileName: '',
        async handleUpload(e) {
            const file = e.target.files[0];
            if (!file) return;
            this.fileName = file.name;
            this.loading = true;
            this.error = '';

            const formData = new FormData();
            formData.append('image', file);

            try {
                const response = await fetch('/image/image-to-base64', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: formData
                });
                
                const data = await response.json();
                if (!response.ok) throw new Error(data.message || 'Upload failed');
                this.base64 = data.base64;
            } catch (e) {
                this.error = e.message;
            } finally {
                this.loading = false;
            }
        },
        copy() {
            if (!this.base64) return;
            navigator.clipboard.writeText(this.base64);
            alert('Base64 string copied!');
        }
    }" class="p-8">
        
        <div class="max-w-3xl mx-auto space-y-8">
            <!-- Upload Area -->
            <div class="relative group">
                <input type="file" @change="handleUpload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                <div class="p-12 border-2 border-dashed border-slate-200 rounded-[40px] bg-slate-50 text-center transition-all group-hover:border-indigo-400 group-hover:bg-indigo-50/30">
                    <div class="w-20 h-20 bg-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                        <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h14a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2" x-text="fileName || 'Click to select or drag image'"></h3>
                    <p class="text-sm text-slate-500">Supports JPG, PNG, GIF, WEBP (Max 2MB)</p>
                </div>
                
                <!-- Loading Overlay -->
                <div x-show="loading" class="absolute inset-0 bg-white/80 rounded-[40px] flex items-center justify-center z-20">
                    <svg class="animate-spin h-10 w-10 text-indigo-600" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </div>
            </div>

            <p x-show="error" x-text="error" class="text-center text-red-500 font-bold"></p>

            <!-- Result -->
            <template x-if="base64">
                <div class="animate-in fade-in slide-in-from-bottom-4 duration-500 space-y-4">
                    <div class="flex justify-between items-center">
                        <label class="text-sm font-bold text-slate-700 uppercase tracking-widest">Base64 Output:</label>
                        <button @click="copy()" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Copy String</button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="md:col-span-1">
                            <div class="sticky top-24">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Preview</label>
                                <img :src="base64" class="w-full h-auto rounded-2xl border border-slate-100 shadow-lg">
                            </div>
                        </div>
                        <div class="md:col-span-3">
                            <textarea readonly x-text="base64" class="w-full h-64 p-6 bg-slate-900 text-indigo-300 font-mono text-xs rounded-[32px] border-none focus:ring-0 overflow-y-auto"></textarea>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</x-tool-layout>
@endsection
