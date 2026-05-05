@extends('layouts.app')

@section('title', 'Case Converter - ToolOrbit')
@section('meta_description', 'Easily convert text to UPPERCASE, lowercase, Title Case, or Sentence case with our free online tool.')

@section('content')
<x-tool-layout 
    title="Case Converter" 
    description="Change your text case instantly with multiple formatting options."
    category="Text Analysis"
>
    <div x-data="{ 
        text: '',
        convert(type) {
            if (!this.text) return;
            if (type === 'upper') this.text = this.text.toUpperCase();
            if (type === 'lower') this.text = this.text.toLowerCase();
            if (type === 'title') {
                this.text = this.text.toLowerCase().split(' ').map(s => s.charAt(0).toUpperCase() + s.substring(1)).join(' ');
            }
            if (type === 'sentence') {
                this.text = this.text.toLowerCase().replace(/(^\s*\w|[.!?]\s*\w)/g, c => c.toUpperCase());
            }
        },
        copy() {
            navigator.clipboard.writeText(this.text);
            alert('Copied to clipboard!');
        }
    }" class="p-8">
        
        <div class="mb-8">
            <label for="text-input" class="block text-sm font-bold text-slate-700 mb-2">Enter your text:</label>
            <textarea 
                id="text-input" 
                x-model="text" 
                rows="10" 
                class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 transition-all"
                placeholder="Type or paste your text here..."
            ></textarea>
        </div>

        <div class="flex flex-wrap gap-4 mb-8">
            <button @click="convert('upper')" class="btn-primary px-4 py-2 text-sm bg-indigo-600">UPPERCASE</button>
            <button @click="convert('lower')" class="btn-primary px-4 py-2 text-sm bg-indigo-500">lowercase</button>
            <button @click="convert('title')" class="btn-primary px-4 py-2 text-sm bg-indigo-400">Title Case</button>
            <button @click="convert('sentence')" class="btn-primary px-4 py-2 text-sm bg-indigo-300">Sentence case</button>
            <button @click="copy()" class="btn-secondary px-4 py-2 text-sm ml-auto">Copy to Clipboard</button>
        </div>
    </div>
</x-tool-layout>
@endsection
