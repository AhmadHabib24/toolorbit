@extends('layouts.app')

@section('title', 'XML Sitemap Generator - ToolOrbit')
@section('meta_description', 'Generate a professional XML sitemap for your website to help search engines index your pages better.')

@section('content')
<x-tool-layout 
    title="XML Sitemap Generator" 
    description="Create a sitemap for your website in seconds."
    category="SEO Tools"
>
    <div x-data="{ 
        urls: 'https://example.com/\nhttps://example.com/about\nhttps://example.com/contact',
        priority: '0.8',
        changefreq: 'weekly',
        get result() {
            let res = '<' + '?xml version=\'1.0\' encoding=\'UTF-8\'?' + '>\n';
            res += '<urlset xmlns=\'http://www.sitemaps.org/schemas/sitemap/0.9\'>\n';
            
            const list = this.urls.split('\n').filter(u => u.trim());
            list.forEach(u => {
                res += '  <url>\n';
                res += `    <loc>${u.trim()}</loc>\n`;
                res += `    <lastmod>${new Date().toISOString().split('T')[0]}</lastmod>\n`;
                res += `    <changefreq>${this.changefreq}</changefreq>\n`;
                res += `    <priority>${this.priority}</priority>\n`;
                res += '  </url>\n';
            });

            res += '</urlset>';
            return res;
        },
        copy() {
            navigator.clipboard.writeText(this.result);
            alert('Sitemap copied to clipboard!');
        },
        download() {
            const blob = new Blob([this.result], { type: 'text/xml' });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = 'sitemap.xml';
            a.click();
        }
    }" class="p-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Enter URLs (one per line):</label>
                    <textarea x-model="urls" rows="6" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Priority:</label>
                        <select x-model="priority" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                            <option value="1.0">1.0 (Highest)</option>
                            <option value="0.8">0.8</option>
                            <option value="0.5">0.5 (Default)</option>
                            <option value="0.3">0.3</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Change Freq:</label>
                        <select x-model="changefreq" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                            <option value="always">Always</option>
                            <option value="hourly">Hourly</option>
                            <option value="daily">Daily</option>
                            <option value="weekly" selected>Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Generated XML:</label>
                <div class="relative">
                    <pre class="w-full h-full p-6 bg-slate-900 text-indigo-300 rounded-2xl overflow-x-auto text-xs font-mono min-h-[300px]" x-text="result"></pre>
                    <div class="absolute top-4 right-4 flex space-x-2">
                        <button @click="copy()" class="bg-white/10 hover:bg-white/20 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">Copy</button>
                        <button @click="download()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors shadow-lg shadow-indigo-500/20">Download</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tool-layout>
@endsection
