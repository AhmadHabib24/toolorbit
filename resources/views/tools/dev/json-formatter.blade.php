@extends('layouts.app')

@section('title', 'JSON Formatter & Validator - ToolOrbit')
@section('meta_description', 'Format, prettify, and validate your JSON data instantly. Fix syntax errors and make your JSON readable for developers.')

@section('content')
<x-tool-layout 
    title="JSON Formatter" 
    description="Prettify messy JSON strings into a clean, readable format with one click."
    category="Developer Tools"
>
    <div x-data="{ 
        input: '',
        output: '',
        error: '',
        async process() {
            if (!this.input.trim()) return;
            this.error = '';
            
            try {
                const response = await fetch('/dev/json-formatter', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ json: this.input })
                });
                
                const data = await response.json();
                if (!response.ok) throw new Error(data.error);
                this.output = data.result;
            } catch (e) {
                this.error = e.message;
                this.output = '';
            }
        },
        copy() {
            if (!this.output) return;
            navigator.clipboard.writeText(this.output);
            alert('JSON copied!');
        }
    }" class="p-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-4">
                <label class="block text-sm font-bold text-slate-700">Input JSON:</label>
                <textarea 
                    x-model="input" 
                    rows="15" 
                    placeholder='{"id":1,"name":"John Doe","active":true}' 
                    class="w-full p-6 bg-slate-50 border border-slate-200 rounded-[32px] focus:ring-2 focus:ring-indigo-500 transition-all font-mono text-sm"
                ></textarea>
                <button @click="process()" class="w-full btn-primary py-4 rounded-2xl font-bold">Format & Validate</button>
                <p x-show="error" x-text="error" class="text-sm text-red-500 font-bold mt-2"></p>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <label class="text-sm font-bold text-slate-700">Formatted Result:</label>
                    <button x-show="output" @click="copy()" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Copy Result</button>
                </div>
                <div class="relative group h-[400px]">
                    <textarea 
                        x-model="output" 
                        readonly
                        class="w-full h-full p-8 bg-slate-900 text-indigo-300 font-mono text-xs rounded-[32px] border-none focus:ring-0 overflow-y-auto"
                    ></textarea>
                </div>
            </div>
        </div>

        <div class="mt-12 p-8 bg-indigo-50 rounded-[32px] border border-indigo-100">
            <h4 class="font-bold text-indigo-900 mb-2">Pro Tip for Developers</h4>
            <p class="text-sm text-indigo-700 leading-relaxed">
                Our formatter uses `JSON_PRETTY_PRINT` with unescaped slashes, making it perfect for formatting URLs and complex data objects directly for your documentation or code.
            </p>
        </div>
    </div>
</x-tool-layout>
@endsection
