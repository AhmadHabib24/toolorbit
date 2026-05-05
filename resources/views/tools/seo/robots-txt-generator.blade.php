@extends('layouts.app')

@section('title', 'Robots.txt Generator - ToolOrbit')
@section('meta_description', 'Create a perfect robots.txt file for your website to control search engine crawlers.')

@section('content')
<x-tool-layout 
    title="Robots.txt Generator" 
    description="Control how search engines crawl your website with a custom robots.txt file."
    category="SEO Tools"
>
    <div x-data="{ 
        allowAll: true,
        delay: 'none',
        sitemap: '',
        restrictedPaths: '/admin/\n/temp/',
        get result() {
            let res = 'User-agent: *\n';
            if (this.delay !== 'none') res += `Crawl-delay: ${this.delay}\n`;
            
            if (this.allowAll) {
                res += 'Allow: /\n';
            } else {
                res += 'Disallow: /\n';
            }

            const paths = this.restrictedPaths.split('\n').filter(p => p.trim());
            paths.forEach(p => {
                res += `Disallow: ${p.trim()}\n`;
            });

            if (this.sitemap) res += `Sitemap: ${this.sitemap}\n`;
            
            return res;
        },
        copy() {
            navigator.clipboard.writeText(this.result);
            alert('Copied to clipboard!');
        }
    }" class="p-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Default Crawler Access:</label>
                    <select x-model="allowAll" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                        <option :value="true">Allow all crawlers</option>
                        <option :value="false">Disallow all crawlers</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Crawl Delay:</label>
                    <select x-model="delay" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                        <option value="none">No Delay</option>
                        <option value="5">5 Seconds</option>
                        <option value="10">10 Seconds</option>
                        <option value="20">20 Seconds</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Sitemap URL (Optional):</label>
                    <input type="text" x-model="sitemap" placeholder="https://example.com/sitemap.xml" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Restricted Directories (one per line):</label>
                    <textarea x-model="restrictedPaths" rows="4" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Generated Robots.txt:</label>
                <div class="relative">
                    <pre class="w-full h-full p-6 bg-slate-900 text-green-400 rounded-2xl overflow-x-auto text-sm font-mono min-h-[300px]" x-text="result"></pre>
                    <button @click="copy()" class="absolute top-4 right-4 bg-white/10 hover:bg-white/20 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">Copy</button>
                </div>
            </div>
        </div>
    </div>
</x-tool-layout>
@endsection
