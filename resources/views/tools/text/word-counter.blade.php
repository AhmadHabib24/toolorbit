@extends('layouts.app')

@section('title', 'Word Counter - ToolOrbit')
@section('meta_description', 'Count words, characters, sentences, and paragraphs in your text instantly with our free word counter tool.')

@section('content')
<x-tool-layout 
    title="Word Counter" 
    description="Analyze your text length and structure in real-time."
    category="Text Analysis"
>
    <div x-data="{ 
        text: '',
        get wordCount() { return this.text.trim() ? this.text.trim().split(/\s+/).length : 0 },
        get charCount() { return this.text.length },
        get charNoSpaces() { return this.text.replace(/\s/g, '').length },
        get sentenceCount() { return this.text.split(/[.!?]+/).filter(Boolean).length },
        get paragraphCount() { return this.text.split(/\n+/).filter(Boolean).length },
        clear() { this.text = '' }
    }" class="p-8">
        
        <div class="mb-8">
            <label for="text-input" class="block text-sm font-bold text-slate-700 mb-2">Paste your text here:</label>
            <textarea 
                id="text-input" 
                x-model="text" 
                rows="10" 
                class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 transition-all"
                placeholder="Start typing or paste your content..."
            ></textarea>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <div class="p-4 bg-indigo-50 rounded-2xl text-center">
                <div class="text-2xl font-black text-indigo-600" x-text="wordCount">0</div>
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Words</div>
            </div>
            <div class="p-4 bg-cyan-50 rounded-2xl text-center">
                <div class="text-2xl font-black text-cyan-600" x-text="charCount">0</div>
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Chars</div>
            </div>
            <div class="p-4 bg-slate-50 rounded-2xl text-center">
                <div class="text-2xl font-black text-slate-600" x-text="charNoSpaces">0</div>
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">No Spaces</div>
            </div>
            <div class="p-4 bg-slate-50 rounded-2xl text-center">
                <div class="text-2xl font-black text-slate-600" x-text="sentenceCount">0</div>
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Sentences</div>
            </div>
            <div class="p-4 bg-slate-50 rounded-2xl text-center">
                <div class="text-2xl font-black text-slate-600" x-text="paragraphCount">0</div>
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Paragraphs</div>
            </div>
        </div>

        <div class="flex justify-between items-center">
            <button @click="clear()" class="btn-secondary">Clear Text</button>
            <div class="text-xs text-slate-400 font-medium italic">Automatically updates as you type</div>
        </div>
    </div>
</x-tool-layout>
@endsection
