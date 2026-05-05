@extends('layouts.app')

@section('title', 'Favicon Tag Generator - ToolOrbit')
@section('meta_description', 'Generate all necessary HTML meta tags for your website favicon including Apple Touch and Manifest tags.')

@section('content')
<x-tool-layout 
    title="Favicon Tag Generator" 
    description="Quickly generate the HTML code to correctly display your favicon across all browsers and devices."
    category="Design Utilities"
>
    <div x-data="{ 
        baseUrl: 'https://example.com',
        color: '#4f46e5',
        get result() {
            const url = this.baseUrl.replace(/\/$/, '');
            let tags = `<!-- Standard Favicon -->\n`;
            tags += `<link rel='icon' type='image/x-icon' href='${url}/favicon.ico'>\n`;
            tags += `<link rel='icon' type='image/png' sizes='32x32' href='${url}/favicon-32x32.png'>\n`;
            tags += `<link rel='icon' type='image/png' sizes='16x16' href='${url}/favicon-16x16.png'>\n\n`;
            
            tags += `<!-- Apple Touch Icon -->\n`;
            tags += `<link rel='apple-touch-icon' sizes='180x180' href='${url}/apple-touch-icon.png'>\n\n`;
            
            tags += `<!-- Android / Web App -->\n`;
            tags += `<link rel='manifest' href='${url}/site.webmanifest'>\n`;
            tags += `<meta name='theme-color' content='${this.color}'>`;
            
            return tags;
        },
        copy() {
            navigator.clipboard.writeText(this.result);
            alert('HTML Tags copied!');
        }
    }" class="p-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Base URL (where files are hosted):</label>
                    <input type="text" x-model="baseUrl" placeholder="https://yourwebsite.com" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Theme Color (for Mobile):</label>
                    <div class="flex space-x-4">
                        <input type="color" x-model="color" class="w-16 h-16 p-1 bg-white border border-slate-200 rounded-xl cursor-pointer">
                        <input type="text" x-model="color" class="flex-1 p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 font-mono">
                    </div>
                </div>

                <div class="p-6 bg-amber-50 rounded-3xl border border-amber-100 flex items-start space-x-4">
                    <svg class="w-6 h-6 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-xs text-amber-800 leading-relaxed font-medium">
                        <strong>Note:</strong> This tool generates the HTML tags. You must still upload your icon files (favicon.ico, favicon-32x32.png, etc.) to your root directory.
                    </p>
                </div>
            </div>

            <!-- Output area -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="text-sm font-bold text-slate-700">HTML Tags:</label>
                    <button @click="copy()" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">Copy to Clipboard</button>
                </div>
                <pre class="w-full p-6 bg-slate-900 text-indigo-300 rounded-[32px] overflow-x-auto text-xs font-mono min-h-[300px]" x-text="result"></pre>
            </div>
        </div>
    </div>
</x-tool-layout>
@endsection
