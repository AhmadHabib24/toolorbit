@extends('layouts.app')

@section('title', 'Meta Tag Generator - ToolOrbit')
@section('meta_description', 'Generate SEO-friendly meta tags for your website including Title, Description, Keywords, and Robots instructions.')

@section('content')
<x-tool-layout 
    title="Meta Tag Generator" 
    description="Generate high-quality meta tags to improve your search engine rankings."
    category="SEO Tools"
>
    <div x-data="{ 
        title: '',
        description: '',
        keywords: '',
        robots: 'index, follow',
        author: '',
        get result() {
            let tags = `<title>${this.title || 'Page Title'}</title>\n`;
            tags += `<meta name='description' content='${this.description || 'Page Description'}'>\n`;
            if (this.keywords) tags += `<meta name='keywords' content='${this.keywords}'>\n`;
            tags += `<meta name='robots' content='${this.robots}'>\n`;
            if (this.author) tags += `<meta name='author' content='${this.author}'>\n`;
            return tags;
        },
        copy() {
            navigator.clipboard.writeText(this.result);
            alert('Copied to clipboard!');
        }
    }" class="p-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Site Title:</label>
                    <input type="text" x-model="title" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Site Description:</label>
                    <textarea x-model="description" rows="3" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Keywords (comma separated):</label>
                    <input type="text" x-model="keywords" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Author:</label>
                    <input type="text" x-model="author" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Generated Meta Tags:</label>
                <div class="relative">
                    <pre class="w-full h-full p-6 bg-slate-900 text-indigo-300 rounded-2xl overflow-x-auto text-sm font-mono min-h-[300px]" x-text="result"></pre>
                    <button @click="copy()" class="absolute top-4 right-4 bg-white/10 hover:bg-white/20 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">Copy</button>
                </div>
            </div>
        </div>
    </div>
</x-tool-layout>
@endsection
