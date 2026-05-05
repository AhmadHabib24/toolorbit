@extends('layouts.app')

@section('title', 'FAQ Schema Generator - ToolOrbit')
@section('meta_description', 'Generate JSON-LD FAQ schema for your website to get rich snippets in search results.')

@section('content')
<x-tool-layout 
    title="FAQ Schema Generator" 
    description="Build professional JSON-LD FAQ schema to boost your visibility in Google search."
    category="SEO Tools"
>
    <div x-data="{ 
        faqs: [
            { question: '', answer: '' }
        ],
        addFaq() {
            this.faqs.push({ question: '', answer: '' });
        },
        removeFaq(index) {
            if (this.faqs.length > 1) {
                this.faqs.splice(index, 1);
            }
        },
        get result() {
            const schema = {
                '{{ '@' }}context': 'https://schema.org',
                '{{ '@' }}type': 'FAQPage',
                'mainEntity': this.faqs.filter(f => f.question && f.answer).map(f => ({
                    '{{ '@' }}type': 'Question',
                    'name': f.question,
                    'acceptedAnswer': {
                        '{{ '@' }}type': 'Answer',
                        'text': f.answer
                    }
                }))
            };
            return JSON.stringify(schema, null, 2);
        },
        copy() {
            navigator.clipboard.writeText(this.result);
            alert('Schema copied to clipboard!');
        }
    }" class="p-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="space-y-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-bold text-slate-700">Questions & Answers</h3>
                    <button type="button" @click="addFaq()" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">+ Add Question</button>
                </div>
                
                <template x-for="(faq, index) in faqs" :key="index">
                    <div class="p-6 bg-slate-50 rounded-3xl border border-slate-100 relative group">
                        <button type="button" @click="removeFaq(index)" class="absolute top-4 right-4 text-slate-300 hover:text-red-500 transition-colors opacity-0 group-hover:opacity-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Question #<span x-text="index + 1"></span></label>
                                <input type="text" x-model="faq.question" placeholder="e.g. What is ToolOrbit?" class="w-full p-4 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Answer</label>
                                <textarea x-model="faq.answer" rows="3" placeholder="e.g. ToolOrbit is a free SEO tools platform..." class="w-full p-4 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500"></textarea>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">JSON-LD Output:</label>
                <div class="relative">
                    <pre class="w-full p-6 bg-slate-900 text-indigo-300 rounded-2xl overflow-x-auto text-xs font-mono min-h-[400px]" x-text="result"></pre>
                    <div class="absolute top-4 right-4">
                        <button type="button" @click="copy()" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl text-xs font-bold transition-colors">Copy Schema</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-tool-layout>
@endsection
