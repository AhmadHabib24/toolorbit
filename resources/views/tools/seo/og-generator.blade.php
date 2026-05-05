@extends('layouts.app')

@section('title', 'Open Graph Generator - ToolOrbit')
@section('meta_description', 'Generate Open Graph meta tags for Facebook, LinkedIn, and other social media platforms.')

@section('content')
<x-tool-layout 
    title="Open Graph Generator" 
    description="Control how your content appears on social media platforms."
    category="SEO Tools"
>
    <div x-data="{ 
        title: '',
        description: '',
        url: '',
        siteName: '',
        imageUrl: '',
        type: 'website',
        get result() {
            let tags = `<meta property='og:title' content='${this.title || 'Page Title'}'>\n`;
            tags += `<meta property='og:description' content='${this.description || 'Page Description'}'>\n`;
            tags += `<meta property='og:url' content='${this.url || 'https://example.com'}'>\n`;
            tags += `<meta property='og:site_name' content='${this.siteName || 'Site Name'}'>\n`;
            tags += `<meta property='og:type' content='${this.type}'>\n`;
            if (this.imageUrl) tags += `<meta property='og:image' content='${this.imageUrl}'>\n`;
            
            // Twitter Specific
            tags += `\n<meta name='twitter:card' content='summary_large_image'>\n`;
            tags += `<meta name='twitter:title' content='${this.title || 'Page Title'}'>\n`;
            tags += `<meta name='twitter:description' content='${this.description || 'Page Description'}'>\n`;
            if (this.imageUrl) tags += `<meta name='twitter:image' content='${this.imageUrl}'>\n`;
            
            return tags;
        },
        copy() {
            navigator.clipboard.writeText(this.result);
            alert('Tags copied to clipboard!');
        }
    }" class="p-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Page Title:</label>
                        <input type="text" x-model="title" placeholder="My Awesome Page" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Site Name:</label>
                        <input type="text" x-model="siteName" placeholder="ToolOrbit" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Page URL:</label>
                    <input type="text" x-model="url" placeholder="https://example.com/page" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Image URL:</label>
                    <input type="text" x-model="imageUrl" placeholder="https://example.com/image.jpg" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Description:</label>
                    <textarea x-model="description" rows="3" placeholder="A brief summary of your page content..." class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Type:</label>
                    <select x-model="type" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                        <option value="website">Website</option>
                        <option value="article">Article</option>
                        <option value="profile">Profile</option>
                        <option value="book">Book</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Meta Tags Output:</label>
                <div class="relative">
                    <pre class="w-full p-6 bg-slate-900 text-indigo-300 rounded-2xl overflow-x-auto text-xs font-mono min-h-[400px]" x-text="result"></pre>
                    <div class="absolute top-4 right-4">
                        <button @click="copy()" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl text-xs font-bold transition-colors">Copy Tags</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tool-layout>
@endsection
