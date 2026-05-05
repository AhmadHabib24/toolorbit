@extends('layouts.app')

@section('title', 'Dashboard - ToolOrbit')
@section('meta_description', 'Your ToolOrbit dashboard. Access all your tools and manage your account.')

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 transition-colors duration-500 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Welcome Header -->
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 dark:text-white">Welcome back, {{ Auth::user()->name }} 👋</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Access all your tools and manage your account from here.</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="btn-secondary self-start">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Profile Settings
            </a>
        </div>

        <!-- Stats Row -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-premium p-6">
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-2">Account Plan</div>
                <div class="text-2xl font-black text-indigo-600 dark:text-indigo-400">Free</div>
                <p class="text-xs text-slate-400 mt-1">Upgrade for unlimited access</p>
            </div>
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-premium p-6">
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-2">Tools Available</div>
                <div class="text-2xl font-black text-slate-900 dark:text-white">{{ \App\Models\Tool::where('is_active', true)->count() }}+</div>
                <p class="text-xs text-slate-400 mt-1">Free tools accessible now</p>
            </div>
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-premium p-6">
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-2">Member Since</div>
                <div class="text-2xl font-black text-slate-900 dark:text-white">{{ Auth::user()->created_at->format('M Y') }}</div>
                <p class="text-xs text-slate-400 mt-1">{{ Auth::user()->created_at->diffForHumans() }}</p>
            </div>
        </div>

        <!-- Tools Section -->
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-xl font-black text-slate-900 dark:text-white">All Tools</h2>
            <a href="/" class="text-sm font-bold text-indigo-600 hover:underline">Back to Home →</a>
        </div>

        @php $tools = \App\Models\Tool::where('is_active', true)->get(); @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($tools as $tool)
            @php
                $href = $tool->route_name && \Illuminate\Support\Facades\Route::has($tool->route_name)
                    ? route($tool->route_name, [], false)
                    : '/' . $tool->slug;
            @endphp
            <a href="{{ $href }}" class="group block p-6 bg-white dark:bg-slate-900 rounded-[28px] border border-slate-100 dark:border-slate-800 shadow-premium hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative z-10 flex items-start space-x-4">
                    <div class="w-12 h-12 bg-indigo-50 dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tool->icon }}"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[9px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest mb-1 opacity-70">{{ $tool->category }}</div>
                        <h3 class="font-black text-slate-900 dark:text-white group-hover:text-indigo-600 transition-colors truncate">{{ $tool->title }}</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-xs mt-1 leading-relaxed line-clamp-2">{{ $tool->description }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

    </div>
</div>
@endsection

