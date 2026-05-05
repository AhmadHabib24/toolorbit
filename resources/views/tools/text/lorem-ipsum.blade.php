@extends('layouts.app')

@section('title', 'Lorem Ipsum Generator - ToolOrbit')
@section('meta_description', 'Generate placeholder text for your designs and layouts with our free online Lorem Ipsum generator.')

@section('content')
<x-tool-layout 
    title="Lorem Ipsum Generator" 
    description="Generate standard placeholder text for your projects."
    category="Text Analysis"
>
    <div x-data="{ 
        paragraphs: 3,
        result: '',
        generate() {
            const text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
            this.result = Array(parseInt(this.paragraphs)).fill(text).join('\n\n');
        },
        copy() {
            navigator.clipboard.writeText(this.result);
            alert('Copied to clipboard!');
        }
    }" x-init="generate()" class="p-8">
        
        <div class="flex items-center space-x-6 mb-8">
            <div class="flex-1">
                <label for="paragraphs" class="block text-sm font-bold text-slate-700 mb-2">Number of paragraphs:</label>
                <input type="number" id="paragraphs" x-model="paragraphs" min="1" max="50" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 transition-all">
            </div>
            <div class="pt-6">
                <button @click="generate()" class="btn-primary py-4">Generate Text</button>
            </div>
        </div>

        <div class="mb-8">
            <label class="block text-sm font-bold text-slate-700 mb-2">Result:</label>
            <textarea 
                x-model="result" 
                rows="10" 
                readonly
                class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl text-slate-600 font-serif leading-relaxed"
            ></textarea>
        </div>

        <div class="flex justify-end">
            <button @click="copy()" class="btn-secondary">Copy to Clipboard</button>
        </div>
    </div>
</x-tool-layout>
@endsection
