@extends('layouts.app')

@section('title', 'YouTube Thumbnail Downloader - ToolOrbit')
@section('meta_description', 'Download high-quality thumbnails from any YouTube video for free. Just paste the URL and save.')

@section('content')
<x-tool-layout 
    title="YouTube Thumbnail Downloader" 
    description="Get high-resolution thumbnails from any YouTube video in one click."
    category="YouTube Tools"
>
    <div x-data="{ 
        url: '',
        loading: false,
        error: '',
        data: null,
        async fetchThumbnails() {
            if (!this.url) return;
            this.loading = true;
            this.error = '';
            this.data = null;
            
            try {
                const response = await fetch('/youtube/thumbnail-downloader', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ url: this.url })
                });
                
                const result = await response.json();
                if (!response.ok) throw new Error(result.error || 'Failed to fetch thumbnails');
                this.data = result;
            } catch (e) {
                this.error = e.message;
            } finally {
                this.loading = false;
            }
        },
        download(url, filename) {
            fetch(url).then(t => t.blob().then(b => {
                const a = document.createElement('a');
                a.href = URL.createObjectURL(b);
                a.setAttribute('download', filename);
                a.click();
            }));
        }
    }" class="p-8">
        
        <div class="max-w-2xl mx-auto mb-10">
            <label class="block text-sm font-bold text-slate-700 mb-2">YouTube Video URL:</label>
            <div class="flex space-x-2">
                <input type="text" x-model="url" placeholder="https://www.youtube.com/watch?v=..." class="flex-1 p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                <button @click="fetchThumbnails()" :disabled="loading" class="btn-primary flex items-center justify-center">
                    <template x-if="!loading"><span>Get Thumbnails</span></template>
                    <template x-if="loading"><svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></template>
                </button>
            </div>
            <p x-show="error" x-text="error" class="mt-2 text-sm text-red-500 font-medium"></p>
        </div>

        <template x-if="data">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <h4 class="font-bold text-slate-900 mb-4">Maximum Quality (1280x720)</h4>
                        <img :src="data.thumbnails.maxres" class="w-full rounded-xl shadow-lg mb-4" alt="Maxres">
                        <button @click="download(data.thumbnails.maxres, 'youtube-thumbnail-maxres.jpg')" class="w-full btn-secondary text-sm">Download Maxres</button>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <h4 class="font-bold text-slate-900 mb-4">High Quality (480x360)</h4>
                        <img :src="data.thumbnails.high" class="w-full rounded-xl shadow-md mb-4" alt="High">
                        <button @click="download(data.thumbnails.high, 'youtube-thumbnail-high.jpg')" class="w-full btn-secondary text-sm">Download High Quality</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-tool-layout>
@endsection
