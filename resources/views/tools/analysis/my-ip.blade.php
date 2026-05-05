@extends('layouts.app')

@section('title', 'What is My IP - ToolOrbit')
@section('meta_description', 'Find out your public IP address and basic location information instantly.')

@section('content')
<x-tool-layout 
    title="What is My IP?" 
    description="Your public IP address and connection details."
    category="Website Tracking"
>
    <div class="p-12 text-center">
        <div class="inline-block px-8 py-10 bg-indigo-50 rounded-[40px] border border-indigo-100 shadow-xl mb-8">
            <div class="text-xs font-black text-indigo-400 uppercase tracking-widest mb-4">Your IP Address is</div>
            <div class="text-5xl md:text-7xl font-black text-indigo-600 font-mono">{{ $ip }}</div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto">
            <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
                <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <div class="text-left">
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Location</div>
                    <div class="font-bold text-slate-900">Detected Automatically</div>
                </div>
            </div>
            <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
                <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div class="text-left">
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Browser</div>
                    <div class="font-bold text-slate-900">Chrome / Safari</div>
                </div>
            </div>
        </div>
    </div>
</x-tool-layout>
@endsection
