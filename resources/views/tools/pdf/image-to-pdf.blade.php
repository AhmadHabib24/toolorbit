@extends('layouts.app')

@section('title', 'Image to PDF Converter - ToolOrbit')
@section('meta_description', 'Convert your images (JPG, PNG, WEBP) into high-quality PDF documents instantly. Perfect for scanned documents and photos.')

@section('content')
<x-tool-layout 
    title="Image to PDF" 
    description="Easily convert any image file into a professional PDF document."
    category="PDF Utilities"
>
    <div class="p-8">
        <form action="/pdf/image-to-pdf" method="POST" enctype="multipart/form-data" class="max-w-3xl mx-auto space-y-8">
            @csrf
            <div x-data="{ fileName: '' }" class="relative group">
                <input type="file" name="image" required @change="fileName = $event.target.files[0].name" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                <div class="p-16 border-2 border-dashed border-slate-200 rounded-[40px] bg-slate-50 text-center transition-all group-hover:border-indigo-400 group-hover:bg-indigo-50/30">
                    <div class="w-24 h-24 bg-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                        <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h14a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2" x-text="fileName || 'Click to select or drag image'"></h3>
                    <p class="text-slate-500">Supports JPG, PNG, WEBP (Max 5MB)</p>
                </div>
            </div>

            <button type="submit" class="w-full btn-primary py-5 rounded-[24px] text-lg flex items-center justify-center space-x-3 shadow-xl shadow-indigo-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Convert to PDF</span>
            </button>
        </form>

        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm text-center">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4 font-bold">1</div>
                <h4 class="font-bold text-slate-900 mb-2">Upload Image</h4>
                <p class="text-xs text-slate-500">Select any image from your device.</p>
            </div>
            <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm text-center">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4 font-bold">2</div>
                <h4 class="font-bold text-slate-900 mb-2">Instant Conversion</h4>
                <p class="text-xs text-slate-500">Our engine creates a clean A4 PDF.</p>
            </div>
            <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm text-center">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4 font-bold">3</div>
                <h4 class="font-bold text-slate-900 mb-2">Download PDF</h4>
                <p class="text-xs text-slate-500">Your PDF is ready in seconds.</p>
            </div>
        </div>
    </div>
</x-tool-layout>
@endsection
