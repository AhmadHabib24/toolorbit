@extends('layouts.app')

@section('title', 'HTML Entity Encoder & Decoder - ToolOrbit')
@section('meta_description', 'Convert special characters to HTML entities and back. Secure your web input and handle character encoding correctly.')

@section('content')
<x-tool-layout 
    title="HTML Entity Converter" 
    description="Safely encode special characters for HTML or decode entities back to readable text."
    category="Developer Tools"
>
    <div x-data="{ 
        text: '',
        result: '',
        async process(type) {
            if (!this.text.trim()) return;
            
            const response = await fetch('/dev/html-entities', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                },
                body: JSON.stringify({ text: this.text, type: type })
            });
            
            const data = await response.json();
            this.result = data.result;
        }
    }" class="p-8">
        
        <div class="max-w-4xl mx-auto space-y-8">
            <div class="space-y-4">
                <label class="block text-sm font-bold text-slate-700">Enter Text / Entities:</label>
                <textarea 
                    x-model="text" 
                    rows="8" 
                    placeholder="e.g. <script>alert('Hello')</script>" 
                    class="w-full p-6 bg-slate-50 border border-slate-200 rounded-[32px] focus:ring-2 focus:ring-indigo-500 transition-all text-lg"
                ></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <button @click="process('encode')" class="btn-primary py-4 rounded-2xl font-bold flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                    Encode to Entities
                </button>
                <button @click="process('decode')" class="bg-slate-900 text-white py-4 rounded-2xl font-bold hover:bg-slate-800 transition-all flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Decode to Text
                </button>
            </div>

            <template x-if="result">
                <div class="space-y-4 animate-in fade-in zoom-in duration-300">
                    <label class="block text-sm font-bold text-slate-700">Result:</label>
                    <div class="relative group">
                        <textarea 
                            x-model="result" 
                            readonly 
                            class="w-full p-8 bg-indigo-50 border-2 border-indigo-200 rounded-[32px] font-mono text-indigo-700 focus:ring-0"
                            rows="6"
                        ></textarea>
                        <button @click="navigator.clipboard.writeText(result); alert('Copied!')" class="absolute top-4 right-4 p-3 bg-white text-indigo-600 rounded-xl shadow-sm opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</x-tool-layout>
@endsection
