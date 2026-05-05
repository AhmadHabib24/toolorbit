@extends('layouts.app')

@section('title', 'YouTube Tag Extractor - ToolOrbit')
@section('meta_description', 'Extract tags, keywords, and titles from any YouTube video instantly for free.')

@section('content')
<x-tool-layout 
    title="YouTube Tag Extractor" 
    description="Analyze competitors by extracting their video tags and keywords."
    category="YouTube Tools"
>
    <div x-data="{ 
        url: '',
        loading: false,
        error: '',
        data: null,
        async extract() {
            if (!this.url) return;
            this.loading = true;
            this.error = '';
            this.data = null;
            
            try {
                const response = await fetch('/youtube/tag-extractor', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ url: this.url })
                });
                
                const result = await response.json();
                if (!response.ok) throw new Error(result.error || 'Failed to extract data');
                this.data = result;
            } catch (e) {
                this.error = e.message;
            } finally {
                this.loading = false;
            }
        },
        copyTags() {
            if (!this.data || !this.data.tags) return;
            navigator.clipboard.writeText(this.data.tags.join(', '));
            alert('Tags copied to clipboard!');
        }
    }" class="p-8">
        
        <div class="max-w-2xl mx-auto mb-10">
            <label class="block text-sm font-bold text-slate-700 mb-2">YouTube Video URL:</label>
            <div class="flex space-x-2">
                <input type="text" x-model="url" placeholder="https://www.youtube.com/watch?v=..." class="flex-1 p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                <button @click="extract()" :disabled="loading" class="btn-primary">
                    <span x-show="!loading">Extract Data</span>
                    <svg x-show="loading" class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </div>
            <p x-show="error" x-text="error" class="mt-2 text-sm text-red-500 font-medium"></p>
        </div>

        <template x-if="data">
            <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
                <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Video Title</h4>
                    <div class="text-xl font-bold text-slate-900" x-text="data.title"></div>
                </div>

                <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100">
                    <div class="flex justify-between items-center mb-6">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest">Extracted Tags</h4>
                        <button @click="copyTags()" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Copy All Tags</button>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        <template x-for="tag in data.tags" :key="tag">
                            <span class="px-3 py-1.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-medium shadow-sm" x-text="tag"></span>
                        </template>
                        <template x-if="data.tags.length === 0">
                            <span class="text-slate-400 italic">No tags found for this video.</span>
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-tool-layout>
@endsection
