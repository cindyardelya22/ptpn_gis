<div x-data="{
    selectedBlock: null,
    closeDetail() { this.selectedBlock = null; }
}" class="p-6 space-y-6 max-w-7xl mx-auto relative">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100 tracking-tight">Status Kesuburan Tanah</h1>
            <p class="text-slate-500 text-sm">Ringkasan kondisi hara dan prediksi panen estate saat ini.</p>
        </div>
        <div class="flex items-center gap-3">
            <span
                class="flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-full text-xs font-bold border border-emerald-100">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                Live Analytics
            </span>
            <button
                class="p-2 md:px-4 md:py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 rounded-xl text-slate-600 dark:text-slate-300 text-sm font-semibold hover:bg-slate-50 dark:bg-slate-700/50 transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4R" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <span class="hidden md:inline">Export Report</span>
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div
            class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total Blok</p>
            <div class="flex items-end justify-between">
                <h3 class="text-2xl font-black text-slate-800 dark:text-slate-100">{{ $summary['total_blocks'] }}</h3>
                <span class="text-[10px] px-2 py-0.5 bg-slate-100 text-slate-500 rounded-lg font-bold">128.5 Ha</span>
            </div>
        </div>
        <div
            class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow border-l-4 border-l-emerald-500">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Avg Ton/Ha</p>
            <div class="flex items-end justify-between">
                <h3 class="text-2xl font-black text-slate-800 dark:text-slate-100">
                    {{ number_format($summary['avg_ton_per_ha'], 1) }}</h3>
                <div class="flex flex-col items-end">
                    <span class="text-[10px] text-emerald-600 font-bold">+2.4% yield</span>
                </div>
            </div>
        </div>
        <div
            class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow border-l-4 border-l-amber-500">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Best Yield</p>
            <div class="flex items-end justify-between">
                <h3 class="text-2xl font-black text-slate-800 dark:text-slate-100">{{ $summary['best_yield_block'] }}
                </h3>
                <span class="text-[10px] text-amber-600 font-bold">{{ $summary['best_yield_val'] ?? 0 }} Ton</span>
            </div>
        </div>
        <div class="bg-slate-900 p-5 rounded-3xl shadow-xl shadow-slate-200 text-white border-l-4 border-l-emerald-400">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Est. Total Panen (Year)</p>
            <div class="flex items-end justify-between">
                <h3 class="text-2xl font-black">{{ number_format($summary['estimated_total_yield']) }}</h3>
                <span class="text-[10px] font-bold text-emerald-400">TON</span>
            </div>
        </div>
    </div>

    <!-- Main Content Grid: Map & Trends -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Map View (Takes 2 columns) -->
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden relative"
                style="height: 500px;">
                <div id="map" class="w-full h-full" wire:ignore></div>

                <!-- Map Overlay Legend -->
                <div
                    class="absolute bottom-6 right-6 p-4 bg-white/90 dark:bg-slate-800/90 backdrop-blur-md rounded-2xl shadow-xl border border-white/50 z-10">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Indikator Kesuburan
                    </p>
                    <div class="space-y-2">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-emerald-500 shadow-sm shadow-emerald-200"></span>
                            <span class="text-[11px] font-bold text-slate-700 dark:text-slate-200">Subur</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-amber-500 shadow-sm shadow-amber-200"></span>
                            <span class="text-[11px] font-bold text-slate-700 dark:text-slate-200">Cukup Subur</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-rose-500 shadow-sm shadow-rose-200"></span>
                            <span class="text-[11px] font-bold text-slate-700 dark:text-slate-200">Kurang Subur</span>
                        </div>
                    </div>
                </div>

                <!-- Map Controls (Minimalist) -->

            </div>
        </div>

        <!-- Charts & Side Info -->
        <div class="space-y-6">
            <!-- Harvest Trend Chart -->
            <div
                class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h4 class="text-sm font-black text-slate-800 dark:text-slate-100 uppercase tracking-tight">Tren
                            Panen 12 Bulan</h4>
                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Est. Produksi (Ton)</p>
                    </div>
                </div>

                <div class="h-48 mb-4 w-full relative">
                    <canvas id="harvestChart"></canvas>
                </div>
            </div>

            <!-- Fertility Distribution -->
            <div
                class="bg-white dark:bg-slate-800 p-6 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700">
                <h4 class="text-sm font-black text-slate-800 dark:text-slate-100 uppercase tracking-tight mb-6">
                    Distribusi Kesuburan</h4>
                <div class="space-y-4">
                    @foreach ($summary['distribution'] as $status => $count)
                        @php
                            $color = $status === 'Subur' ? 'emerald' : ($status === 'Cukup Subur' ? 'amber' : 'rose');
                            $percentage = ($count / $summary['total_blocks']) * 100;
                        @endphp
                        <div class="space-y-1.5">
                            <div class="flex justify-between text-[11px] font-bold">
                                <span
                                    class="text-slate-600 dark:text-slate-300 uppercase tracking-wider">{{ $status }}</span>
                                <span class="text-slate-400">{{ $count }} Blok ({{ round($percentage) }}%)</span>
                            </div>
                            <div class="h-2 w-full bg-slate-50 dark:bg-slate-700/50 rounded-full overflow-hidden">
                                <div class="h-full bg-{{ $color }}-500 rounded-full"
                                    style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Estate Status Table -->
    <div
        class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
        <div class="p-8 border-b border-slate-50 dark:border-slate-700 flex items-center justify-between">
            <h4 class="text-sm font-black text-slate-800 dark:text-slate-100 uppercase tracking-tight">Status
                Operasional Per Blok</h4>
            <div class="flex gap-2">
                <input type="text" placeholder="Cari blok..."
                    class="text-[11px] font-bold px-4 py-2 border border-slate-200 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Identitas
                            Blok</th>
                        <th
                            class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">
                            Umur Tanaman</th>
                        <th
                            class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">
                            Status</th>
                        <th
                            class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                            Ton/Ha</th>
                        <th
                            class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                            Total Est. Year</th>
                        <th
                            class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($blocks as $block)
                        <tr class="group hover:bg-slate-50 dark:bg-slate-700/50 transition-colors cursor-pointer"
                            @click="selectedBlock = {{ json_encode($block) }}; setTimeout(() => window.initDetailChart(selectedBlock), 100);">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold bg-{{ $block['color_name'] }}-500 shadow-lg shadow-{{ $block['color_name'] }}-100">
                                        {{ explode(' ', $block['name'])[1] }}
                                    </div>
                                    <div>
                                        <p class="text-[13px] font-bold text-slate-800 dark:text-slate-100">
                                            {{ $block['name'] }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold">{{ $block['area_ha'] }} Ha</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span class="text-[11px] font-bold text-slate-600 dark:text-slate-300 italic">
                                    {{ $block['prediction']['age_years'] }} Tahun
                                    <span
                                        class="ml-1 text-[9px] text-slate-400 uppercase">({{ substr($block['prediction']['status_label'], 0, 5) }}..)</span>
                                </span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-{{ $block['color_name'] }}-50 text-{{ $block['color_name'] }}-700 border border-{{ $block['color_name'] }}-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-{{ $block['color_name'] }}-500"></span>
                                    {{ $block['status'] }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right font-black text-[13px] text-slate-800 dark:text-slate-100">
                                {{ $block['ton_per_ha'] }}</td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex flex-col items-end">
                                    <span
                                        class="text-[13px] font-black text-slate-800 dark:text-slate-100">{{ number_format($block['yield']) }}</span>
                                    <span
                                        class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">TON</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div
                                    class="w-8 h-8 rounded-full flex items-center justify-center bg-slate-100 text-slate-400 group-hover:bg-slate-900 group-hover:text-white transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- DETAIL PANEL (OVERLAY) -->
    <template x-if="selectedBlock">
        <div class="fixed inset-0 z-[100] flex items-center justify-end p-4 bg-slate-900/40 backdrop-blur-sm transition-all duration-300"
            @click.self="closeDetail()">

            <div x-show="selectedBlock" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                class="w-full max-w-md h-full bg-white dark:bg-slate-800 shadow-2xl rounded-3xl overflow-hidden flex flex-col relative">

                <!-- Close Button -->
                <button @click="closeDetail()"
                    class="absolute top-6 right-6 p-2 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 transition-colors z-20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Header -->
                <div
                    class="p-8 pb-6 bg-gradient-to-br from-slate-50 to-white border-b border-slate-100 dark:border-slate-700">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white font-bold"
                            :class="'bg-' + selectedBlock.color_name + '-500 shadow-lg shadow-' + selectedBlock.color_name +
                                '-100'">
                            <span x-text="selectedBlock.name.split(' ')[1]"></span>
                        </div>
                        <div>
                            <h2 class="text-2xl font-extrabold text-slate-800 dark:text-slate-100"
                                x-text="selectedBlock.name"></h2>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"
                                x-text="'Plant age ' + selectedBlock.prediction.age_years + ' Yrs | ' + selectedBlock.area_ha + ' Ha'">
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Stats Content -->
                <div class="flex-1 overflow-y-auto p-8 space-y-8">
                    <!-- Prediction Card -->
                    <div class="p-6 bg-slate-900 rounded-[2rem] text-white relative overflow-hidden">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Estimasi Hasil
                            Panen Tahunan</p>
                        <div class="flex items-end gap-2">
                            <h4 class="text-4xl font-extrabold"
                                x-text="parseFloat(selectedBlock.yield).toLocaleString()"></h4>
                            <span class="text-lg font-bold text-slate-400 mb-1">TON</span>
                        </div>
                        <div class="mt-4 pt-4 border-t border-white/10 flex justify-between">
                            <div>
                                <p class="text-[9px] text-slate-400 uppercase font-black">Efisiensi Lahan</p>
                                <p class="text-sm font-bold" x-text="selectedBlock.ton_per_ha + ' Ton/Ha'"></p>
                            </div>
                            <div class="text-right">
                                <p class="text-[9px] text-slate-400 uppercase font-black">Status Umur</p>
                                <p class="text-sm font-bold text-emerald-400"
                                    x-text="selectedBlock.prediction.status_label"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Trend Small Bar Chart -->
                    <div>
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4">Prediksi Panen
                            Bulanan</p>
                        <div class="h-32 mb-4 w-full relative">
                            <canvas id="detailHarvestChart"></canvas>
                        </div>
                    </div>

                    <!-- Nutrients Grid -->
                    <div>
                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3">Kondisi Hara
                            Terakhir</p>
                        <div class="grid grid-cols-2 gap-2">
                            <div
                                class="bg-slate-50 dark:bg-slate-700/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-700 transition-all hover:bg-white dark:bg-slate-800 hover:shadow-md">
                                <p class="text-[9px] font-bold text-slate-400 uppercase mb-1">Nitrogen (N)</p>
                                <p class="text-base font-extrabold text-slate-800 dark:text-slate-100"
                                    x-text="selectedBlock.raw_nutrients.nitrogen + '%'"></p>
                            </div>
                            <div
                                class="bg-slate-50 dark:bg-slate-700/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-700 transition-all hover:bg-white dark:bg-slate-800 hover:shadow-md">
                                <p class="text-[9px] font-bold text-slate-400 uppercase mb-1">Fosfor (P)</p>
                                <p class="text-base font-extrabold text-slate-800 dark:text-slate-100"
                                    x-text="selectedBlock.raw_nutrients.phosphorus + ' ppm'"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Recommendation -->
                    <div class="p-6 bg-emerald-50 rounded-2xl border border-emerald-100">
                        <h5
                            class="text-xs font-black text-emerald-800 uppercase tracking-widest mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Rekomendasi Agronomi
                        </h5>
                        <p class="text-xs text-emerald-700 leading-relaxed"
                            x-text="selectedBlock.status === 'Subur' ? 'Pertahankan pemupukan standar. Monitor serangan hama pada daun.' : 'Segera lakukan pemupukan tambahan Nitrogen dan Fosfor. Perbaiki drainase di area rendah.'">
                        </p>
                    </div>
                </div>

                <!-- Footer Action -->
                <div class="p-8 border-t border-slate-50 dark:border-slate-700 bg-slate-50/30">
                    <button
                        class="w-full bg-emerald-500 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-emerald-200 hover:bg-emerald-600 transition-all active:scale-[0.98]">
                        Download Full Report
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("livewire:navigated", initApp);
    document.addEventListener("DOMContentLoaded", initApp);

    function initApp() {
        initMap();
        initChart();
    }

    function initChart() {
        const ctx = document.getElementById('harvestChart');
        if (!ctx) return;

        if (window.harvestChartInstance) {
            window.harvestChartInstance.destroy();
        }

        const rawData = @json($harvestTrend);

        const yields = rawData.map(item => item.yield);
        const maxYield = Math.max(...yields, 1);

        const backgroundColors = yields.map(val => {
            const ratio = val / maxYield;
            const alpha = 0.2 + (ratio * 0.8);
            return `rgba(16, 185, 129, ${alpha})`;
        });

        const hoverColors = yields.map(() => '#047857');

        window.harvestChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: rawData.map(item => item.month.substring(0, 3).toUpperCase()),
                datasets: [{
                    label: 'Est. Produksi (Ton)',
                    data: yields,
                    backgroundColor: backgroundColors,
                    hoverBackgroundColor: hoverColors,
                    borderRadius: 4,
                    borderWidth: 0,
                    barPercentage: 0.7,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: {
                            size: 10,
                            family: 'sans-serif'
                        },
                        bodyFont: {
                            size: 11,
                            weight: 'bold',
                            family: 'sans-serif'
                        },
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' Ton';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 9,
                                weight: 'bold',
                                family: 'sans-serif'
                            },
                            color: '#94a3b8'
                        }
                    },
                    y: {
                        display: false,
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function initMap() {

        const mapContainer = document.getElementById('map');
        if (!mapContainer || mapContainer.innerHTML.trim() !== '') return;

        const map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.XYZ({
                        url: 'https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}' // Satellite
                    })
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([101.7068, 0.2933]), // Riau
                zoom: 12
            })
        });

        const blocks = @json($blocks).map(b => ({
            id: b.id,
            name: b.name,
            coords: b.coords,
            color: b.color_name === 'emerald' ? '#10b981' : (b.color_name === 'amber' ? '#fbbf24' :
                '#f43f5e'),
            rawData: b
        }));

        const features = [];
        blocks.forEach(block => {
            if (block.coords && Array.isArray(block.coords) && block.coords.length > 0) {
                const polygon = new ol.Feature({
                    geometry: new ol.geom.Polygon([block.coords.map(c => ol.proj.fromLonLat(c))]),
                    name: block.name,
                    rawData: block.rawData
                });
                polygon.setStyle(new ol.style.Style({
                    stroke: new ol.style.Stroke({
                        color: block.color,
                        width: 3
                    }),
                    fill: new ol.style.Fill({
                        color: block.color + '44'
                    }) // 27% alpha
                }));
                features.push(polygon);
            }
        });

        const vectorSource = new ol.source.Vector({
            features: features
        });
        map.addLayer(new ol.layer.Vector({
            source: vectorSource
        }));

        const tooltip = document.createElement('div');
        tooltip.className =
            "bg-slate-900 px-3 py-1.5 rounded-lg shadow-2xl text-[11px] font-bold text-white pointer-events-none z-50";
        tooltip.style.position = "absolute";
        tooltip.style.display = "none";
        document.body.appendChild(tooltip);

        map.on('pointermove', function(evt) {
            const feature = map.forEachFeatureAtPixel(evt.pixel, f => f);
            if (feature) {
                tooltip.style.display = "block";
                tooltip.style.left = evt.originalEvent.pageX + 15 + "px";
                tooltip.style.top = evt.originalEvent.pageY + 15 + "px";
                tooltip.innerHTML = feature.get("name");
                map.getTargetElement().style.cursor = 'pointer';
            } else {
                tooltip.style.display = "none";
                map.getTargetElement().style.cursor = '';
            }
        });

        // CLICK INTERACTION
        map.on('click', function(evt) {
            const feature = map.forEachFeatureAtPixel(evt.pixel, f => f);
            if (feature) {
                const data = feature.get("rawData");
                // Access Alpine component
                const component = document.querySelector('[x-data]');
                if (component && component.__x) {
                    component.__x.$data.selectedBlock = data;
                } else {
                    // Modern Alpine handling
                    const alpineData = Alpine.$data(component);
                    alpineData.selectedBlock = data;
                }
                setTimeout(() => window.initDetailChart(data), 100);
            }
        });

        // Center map on features directly without animation
        const extent = vectorSource.getExtent();
        if (!ol.extent.isEmpty(extent)) {
            map.getView().fit(extent, {
                padding: [100, 100, 100, 100]
            });
        }
    }

    window.initDetailChart = function(data) {
        const ctx = document.getElementById('detailHarvestChart');
        if (!ctx) return;

        if (window.detailChartInstance) {
            window.detailChartInstance.destroy();
        }

        const rawData = data.prediction.monthly_trend;
        const yields = rawData.map(item => item.yield);
        const maxYield = Math.max(...yields, 1);

        const backgroundColors = yields.map(val => {
            const ratio = val / maxYield;
            const alpha = 0.2 + (ratio * 0.8);
            return `rgba(16, 185, 129, ${alpha})`;
        });

        const hoverColors = yields.map(() => '#047857');

        window.detailChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: rawData.map(item => item.month.substring(0, 3).toUpperCase()),
                datasets: [{
                    label: 'Est. Produksi (Ton)',
                    data: yields,
                    backgroundColor: backgroundColors,
                    hoverBackgroundColor: hoverColors,
                    borderRadius: 3,
                    borderWidth: 0,
                    barPercentage: 0.8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: {
                            size: 9,
                            family: 'sans-serif'
                        },
                        bodyFont: {
                            size: 10,
                            weight: 'bold',
                            family: 'sans-serif'
                        },
                        padding: 8,
                        cornerRadius: 6,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' Ton';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                size: 8,
                                weight: 'bold',
                                family: 'sans-serif'
                            },
                            color: '#94a3b8'
                        }
                    },
                    y: {
                        display: false,
                        beginAtZero: true
                    }
                }
            }
        });
    }
</script>
