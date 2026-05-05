@extends('layouts.app')

@section('title', 'JSON to CSV Converter - ToolOrbit')
@section('meta_description', 'Convert JSON data to CSV format instantly. Perfect for data analysis and spreadsheet integration.')

@section('content')
<x-tool-layout 
    title="JSON to CSV Converter" 
    description="Transform structured JSON data into easy-to-use CSV files."
    category="Data Utilities"
>
    <div x-data="{ 
        json: '',
        csv: '',
        error: '',
        loading: false,
        async convert() {
            if (!this.json.trim()) return;
            this.loading = true;
            this.error = '';
            
            try {
                const response = await fetch('/conversion/json-to-csv', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ json: this.json })
                });
                
                const data = await response.json();
                if (!response.ok) throw new Error(data.error || 'Conversion failed');
                this.csv = data.csv;
            } catch (e) {
                this.error = e.message;
            } finally {
                this.loading = false;
            }
        },
        download() {
            const blob = new Blob([this.csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.setAttribute('href', url);
            a.setAttribute('download', 'data.csv');
            a.click();
        }
    }" class="p-8">
        
        <div class="space-y-8">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Paste JSON Array:</label>
                <textarea 
                    x-model="json" 
                    rows="10" 
                    placeholder='[{"id": 1, "name": "John"}, {"id": 2, "name": "Jane"}]'
                    class="w-full p-6 bg-slate-50 border border-slate-200 rounded-[32px] focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 transition-all font-mono text-sm"
                ></textarea>
                <p x-show="error" x-text="error" class="mt-2 text-sm text-red-500"></p>
            </div>

            <div class="flex justify-center">
                <button @click="convert()" :disabled="loading" class="btn-primary px-12 py-4">
                    <span x-show="!loading">Convert to CSV</span>
                    <svg x-show="loading" class="animate-spin h-5 w-5 mx-auto" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </div>

            <template x-if="csv">
                <div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-bold text-slate-700">CSV Result:</label>
                        <button @click="download()" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download .csv
                        </button>
                    </div>
                    <pre class="w-full p-6 bg-slate-900 text-emerald-300 rounded-[32px] overflow-x-auto text-xs font-mono max-h-96" x-text="csv"></pre>
                </div>
            </template>
        </div>
    </div>
</x-tool-layout>
@endsection
