@extends('layouts.app')

@section('title', 'Strong Password Generator - ToolOrbit')
@section('meta_description', 'Create highly secure, random passwords with our free password generator. Customize length and characters for maximum security.')

@section('content')
<x-tool-layout 
    title="Password Generator" 
    description="Generate secure, random passwords to protect your online accounts."
    category="Security Tools"
>
    <div x-data="{ 
        length: 16,
        includeUppercase: true,
        includeLowercase: true,
        includeNumbers: true,
        includeSymbols: true,
        password: '',
        strength: 0,
        generate() {
            let charset = '';
            if (this.includeUppercase) charset += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            if (this.includeLowercase) charset += 'abcdefghijklmnopqrstuvwxyz';
            if (this.includeNumbers) charset += '0123456789';
            if (this.includeSymbols) charset += '!@#$%^&*()_+~`|}{[]:;?><,./-=';
            
            if (!charset) {
                alert('Please select at least one character type');
                return;
            }

            let res = '';
            for (let i = 0; i < this.length; i++) {
                res += charset.charAt(Math.floor(Math.random() * charset.length));
            }
            this.password = res;
            this.calculateStrength();
        },
        calculateStrength() {
            let score = 0;
            if (this.length > 8) score += 20;
            if (this.length > 12) score += 20;
            if (this.includeUppercase) score += 15;
            if (this.includeLowercase) score += 15;
            if (this.includeNumbers) score += 15;
            if (this.includeSymbols) score += 15;
            this.strength = Math.min(score, 100);
        },
        copy() {
            if (!this.password) return;
            navigator.clipboard.writeText(this.password);
            alert('Password copied!');
        }
    }" x-init="generate()" class="p-8">
        
        <div class="max-w-xl mx-auto">
            <!-- Password Display -->
            <div class="mb-10 p-6 bg-slate-900 rounded-[32px] relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 to-cyan-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="flex items-center justify-between relative z-10">
                    <div class="text-2xl md:text-3xl font-mono text-white break-all pr-4" x-text="password"></div>
                    <div class="flex space-x-2">
                        <button @click="generate()" class="p-3 bg-white/10 hover:bg-white/20 text-white rounded-xl transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </button>
                        <button @click="copy()" class="p-3 bg-white/10 hover:bg-white/20 text-white rounded-xl transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                        </button>
                    </div>
                </div>
                
                <!-- Strength Bar -->
                <div class="mt-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Security Strength</span>
                        <span class="text-[10px] font-black uppercase tracking-widest" :class="strength > 70 ? 'text-emerald-500' : 'text-amber-500'" x-text="strength > 70 ? 'Very Strong' : 'Medium'"></span>
                    </div>
                    <div class="h-1.5 w-full bg-white/10 rounded-full overflow-hidden">
                        <div class="h-full transition-all duration-500 rounded-full" :class="strength > 70 ? 'bg-emerald-500' : 'bg-amber-500'" :style="`width: ${strength}%` "></div>
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <div class="space-y-6">
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <label class="text-sm font-bold text-slate-700">Password Length: <span class="text-indigo-600" x-text="length"></span></label>
                    </div>
                    <input type="range" x-model="length" @input="generate()" min="6" max="64" class="w-full h-2 bg-slate-100 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <label class="flex items-center p-4 bg-slate-50 rounded-2xl cursor-pointer hover:bg-slate-100 transition-colors">
                        <input type="checkbox" x-model="includeUppercase" @change="generate()" class="w-5 h-5 rounded text-indigo-600 focus:ring-indigo-500 border-slate-300">
                        <span class="ml-3 text-sm font-bold text-slate-700">Uppercase</span>
                    </label>
                    <label class="flex items-center p-4 bg-slate-50 rounded-2xl cursor-pointer hover:bg-slate-100 transition-colors">
                        <input type="checkbox" x-model="includeLowercase" @change="generate()" class="w-5 h-5 rounded text-indigo-600 focus:ring-indigo-500 border-slate-300">
                        <span class="ml-3 text-sm font-bold text-slate-700">Lowercase</span>
                    </label>
                    <label class="flex items-center p-4 bg-slate-50 rounded-2xl cursor-pointer hover:bg-slate-100 transition-colors">
                        <input type="checkbox" x-model="includeNumbers" @change="generate()" class="w-5 h-5 rounded text-indigo-600 focus:ring-indigo-500 border-slate-300">
                        <span class="ml-3 text-sm font-bold text-slate-700">Numbers</span>
                    </label>
                    <label class="flex items-center p-4 bg-slate-50 rounded-2xl cursor-pointer hover:bg-slate-100 transition-colors">
                        <input type="checkbox" x-model="includeSymbols" @change="generate()" class="w-5 h-5 rounded text-indigo-600 focus:ring-indigo-500 border-slate-300">
                        <span class="ml-3 text-sm font-bold text-slate-700">Symbols</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</x-tool-layout>
@endsection
