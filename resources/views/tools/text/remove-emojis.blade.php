@extends('layouts.app')

@section('title', 'Remove Emojis - ToolOrbit')
@section('meta_description', 'Clean your text by removing all emojis and special icons instantly with our free online tool.')

@section('content')
<x-tool-layout 
    title="Remove Emojis" 
    description="Clean your text from emojis and icons for professional use."
    category="Text Analysis"
>
    <div x-data="{ 
        text: '',
        removeEmojis() {
            if (!this.text) return;
            // Comprehensive regex for emojis
            this.text = this.text.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDC00-\uDFFF])/g, '');
        },
        copy() {
            navigator.clipboard.writeText(this.text);
            alert('Copied to clipboard!');
        }
    }" class="p-8">
        
        <div class="mb-8">
            <label for="text-input" class="block text-sm font-bold text-slate-700 mb-2">Text with emojis:</label>
            <textarea 
                id="text-input" 
                x-model="text" 
                rows="10" 
                class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 transition-all"
                placeholder="Paste your text with emojis here... 🚀🔥✨"
            ></textarea>
        </div>

        <div class="flex justify-between items-center">
            <button @click="removeEmojis()" class="btn-primary">Remove All Emojis</button>
            <button @click="copy()" class="btn-secondary">Copy Clean Text</button>
        </div>
    </div>
</x-tool-layout>
@endsection
