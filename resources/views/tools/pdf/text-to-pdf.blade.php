@extends('layouts.app')

@section('title', 'Text to PDF Converter - ToolOrbit')
@section('meta_description', 'Convert your plain text or notes into a professional PDF document instantly. Free, secure, and easy to use.')

@section('content')
<x-tool-layout 
    title="Text to PDF" 
    description="Transform your text notes into high-quality PDF documents with one click."
    category="PDF Utilities"
>
    <div class="p-8">
        <form action="/pdf/text-to-pdf" method="POST" class="max-w-4xl mx-auto space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Enter your Text:</label>
                <textarea 
                    name="text" 
                    rows="15" 
                    required
                    placeholder="Type or paste your content here..." 
                    class="w-full p-8 bg-slate-50 border border-slate-200 rounded-[40px] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 text-slate-900 transition-all leading-relaxed"
                ></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Filename (Optional):</label>
                    <input type="text" name="filename" placeholder="my-document" class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-indigo-500">
                </div>
                <button type="submit" class="btn-primary py-4 rounded-2xl flex items-center justify-center space-x-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Generate PDF</span>
                </button>
            </div>
        </form>

        <div class="mt-12 max-w-4xl mx-auto p-8 bg-amber-50 rounded-[32px] border border-amber-100 flex items-start space-x-4">
            <svg class="w-6 h-6 text-amber-600 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm text-amber-800 leading-relaxed">
                <strong>Privacy Note:</strong> Your content is processed instantly on our server to generate the PDF and is never stored. All files are served over a secure connection.
            </p>
        </div>
    </div>
</x-tool-layout>
@endsection
