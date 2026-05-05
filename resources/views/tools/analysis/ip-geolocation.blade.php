@extends('layouts.app')

@section('title', 'IP Geolocation - ToolOrbit')
@section('meta_description', 'Find the exact location, ISP, and network details for any IP address with our free geolocation tool.')

@section('content')
<x-tool-layout 
    title="IP Geolocation" 
    description="Track the origin and network details of any IP address instantly."
    category="Website Tracking"
>
    <div x-data="{ 
        ip: '',
        loading: false,
        error: '',
        result: null,
        async lookup() {
            this.loading = true;
            this.error = '';
            this.result = null;
            
            try {
                const response = await fetch('/analysis/ip-geolocation', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                    },
                    body: JSON.stringify({ ip: this.ip })
                });
                
                const data = await response.json();
                if (!response.ok) throw new Error(data.error || 'Failed to fetch data');
                this.result = data;
                
                // Trigger map update
                window.dispatchEvent(new CustomEvent('update-map', { 
                    detail: { lat: data.lat, lon: data.lon, city: data.city } 
                }));
            } catch (e) {
                this.error = e.message;
            } finally {
                this.loading = false;
            }
        }
    }" x-init="lookup()" class="p-8">
        
        <div class="max-w-2xl mx-auto mb-12">
            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Check IP Address:</label>
            <div class="flex space-x-2">
                <input type="text" x-model="ip" placeholder="e.g. 8.8.8.8 (Leave blank for yours)" class="input-base">
                <button @click="lookup()" :disabled="loading" class="btn-primary">
                    <span x-show="!loading">Locate</span>
                    <svg x-show="loading" class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </div>
            <p x-show="error" x-text="error" class="mt-2 text-sm text-red-500 font-medium"></p>
        </div>

        <template x-if="result">
            <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="p-6 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm">
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Country</div>
                        <div class="font-bold text-slate-900 dark:text-white flex items-center">
                            <span class="mr-2" x-text="result.country"></span>
                            <span class="text-xs text-slate-400 dark:text-slate-500" x-text="result.countryCode"></span>
                        </div>
                    </div>
                    <div class="p-6 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm">
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">City / Region</div>
                        <div class="font-bold text-slate-900 dark:text-white" x-text="`${result.city}, ${result.regionName}`"></div>
                    </div>
                    <div class="p-6 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm">
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">ISP / Organization</div>
                        <div class="font-bold text-slate-900 dark:text-white truncate" x-text="result.isp"></div>
                    </div>
                    <div class="p-6 bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm">
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Timezone</div>
                        <div class="font-bold text-slate-900 dark:text-white" x-text="result.timezone"></div>
                    </div>
                </div>

                <!-- Map and Details Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Detailed Table -->
                    <div class="lg:col-span-1 bg-white dark:bg-slate-800 rounded-[32px] border border-slate-100 dark:border-slate-700 shadow-premium overflow-hidden">
                        <table class="w-full text-left h-full">
                            <tbody class="divide-y divide-slate-50 dark:divide-slate-700">
                                <tr>
                                    <td class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 bg-slate-50/50 dark:bg-slate-900/50 w-1/3">Coordinates</td>
                                    <td class="px-6 py-4 text-xs text-slate-700 dark:text-slate-300 font-mono" x-text="`${result.lat}, ${result.lon}`"></td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 bg-slate-50/50 dark:bg-slate-900/50">Zip Code</td>
                                    <td class="px-6 py-4 text-xs text-slate-700 dark:text-slate-300" x-text="result.zip || 'N/A'"></td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 bg-slate-50/50 dark:bg-slate-900/50">AS (Network)</td>
                                    <td class="px-6 py-4 text-xs text-slate-700 dark:text-slate-300" x-text="result.as"></td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-400 bg-slate-50/50 dark:bg-slate-900/50">IP Address</td>
                                    <td class="px-6 py-4 text-xs font-bold text-indigo-600 dark:text-indigo-400" x-text="result.query"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Interactive Map -->
                    <div class="lg:col-span-2 h-[400px] bg-slate-100 dark:bg-slate-800 rounded-[32px] border border-slate-100 dark:border-slate-700 overflow-hidden relative shadow-premium">
                        <div id="map" class="w-full h-full z-10"></div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-tool-layout>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let map;
    let marker;

    function initMap(lat, lon, city) {
        if (!map) {
            map = L.map('map').setView([lat, lon], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
        } else {
            map.setView([lat, lon], 13);
        }

        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lon]).addTo(map)
            .bindPopup(city)
            .openPopup();
    }

    document.addEventListener('alpine:init', () => {
        // Watch for result changes in Alpine
    });

    // Listen for custom event from Alpine
    window.addEventListener('update-map', (e) => {
        setTimeout(() => {
            initMap(e.detail.lat, e.detail.lon, e.detail.city);
        }, 100);
    });
</script>
@endpush
@endsection
