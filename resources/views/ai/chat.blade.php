@extends('layouts.app')

@section('title', 'OrbitAI - Your SEO Chatbot Assistant')
@section('meta_description', 'Chat with OrbitAI to get instant answers about SEO, domain tracking, and website optimization.')

@section('content')
<div class="h-[calc(100vh-80px)] bg-slate-50 overflow-hidden" x-data="{ 
    message: '',
    messages: [
        { role: 'assistant', text: 'Hello! I am OrbitAI. I can help you with SEO tips, domain lookups, or explain how any of our tools work. How can I help you today?' }
    ],
    loading: false,
    async sendMessage() {
        if (!this.message.trim() || this.loading) return;
        
        const userText = this.message;
        this.messages.push({ role: 'user', text: userText });
        this.message = '';
        this.loading = true;

        // Scroll to bottom
        this.$nextTick(() => { this.scrollToBottom() });

        try {
            const response = await fetch('/ai/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                },
                body: JSON.stringify({ message: userText })
            });
            
            const data = await response.json();
            if (data.reply) {
                this.messages.push({ role: 'assistant', text: data.reply });
            }
        } catch (e) {
            this.messages.push({ role: 'assistant', text: 'Sorry, I encountered an error. Please try again.' });
        } finally {
            this.loading = false;
            this.$nextTick(() => { this.scrollToBottom() });
        }
    },
    scrollToBottom() {
        const container = document.getElementById('chat-container');
        container.scrollTop = container.scrollHeight;
    }
}">
    <div class="max-w-5xl mx-auto h-full p-4 md:p-8 flex flex-col">
        <!-- Chat Header -->
        <div class="flex items-center space-x-4 mb-6">
            <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900 leading-none mb-1">OrbitAI</h1>
                <div class="flex items-center text-xs font-bold text-emerald-500 uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                    Assistant Online
                </div>
            </div>
        </div>

        <!-- Messages Container -->
        <div id="chat-container" class="flex-grow overflow-y-auto space-y-6 pr-4 custom-scrollbar mb-6">
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="msg.role === 'user' 
                        ? 'bg-indigo-600 text-white rounded-[24px] rounded-tr-none shadow-indigo-100 shadow-xl' 
                        : 'bg-white text-slate-700 rounded-[24px] rounded-tl-none shadow-sm border border-slate-100'"
                        class="max-w-[80%] p-5 text-sm md:text-base leading-relaxed animate-in slide-in-from-bottom-2 duration-300">
                        <p x-text="msg.text"></p>
                    </div>
                </div>
            </template>
            
            <!-- Typing Indicator -->
            <div x-show="loading" class="flex justify-start">
                <div class="bg-white p-5 rounded-[24px] rounded-tl-none shadow-sm border border-slate-100">
                    <div class="flex space-x-1">
                        <div class="w-2 h-2 bg-slate-300 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-slate-300 rounded-full animate-bounce [animation-delay:-0.15s]"></div>
                        <div class="w-2 h-2 bg-slate-300 rounded-full animate-bounce [animation-delay:-0.3s]"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="relative group">
            <input 
                type="text" 
                x-model="message" 
                @keyup.enter="sendMessage()"
                placeholder="Ask me anything about SEO or our tools..." 
                class="w-full h-16 pl-6 pr-20 bg-white border-none rounded-3xl shadow-premium focus:ring-2 focus:ring-indigo-500 text-slate-900 transition-all"
            >
            <button @click="sendMessage()" class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 bg-indigo-600 text-white rounded-2xl flex items-center justify-center hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
        <p class="text-center text-[10px] text-slate-400 mt-4 font-medium uppercase tracking-widest">OrbitAI is currently in Beta. Powered by ToolOrbit.</p>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
</style>
@endsection
