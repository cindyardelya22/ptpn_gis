<div class="h-full relative overflow-hidden flex flex-col">
    <!-- Overlay Header -->
    <div class="absolute top-6 left-6 right-6 z-10 flex items-center justify-between gap-4 pointer-events-none">
        <div
            class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-md p-4 rounded-3xl border border-white shadow-2xl shadow-slate-200 pointer-events-auto">
            <h1 class="text-xl font-bold text-slate-800 dark:text-slate-100 tracking-tight">Peta Interaktif Blok</h1>
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mt-0.5">Estate Management GIS</p>
        </div>

        <div class="flex items-center gap-3 pointer-events-auto">
            <div
                class="bg-white/90 dark:bg-slate-800/90 backdrop-blur-md p-2 rounded-2xl border border-white shadow-xl flex items-center gap-2">
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-50 border border-emerald-100">
                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                    <span class="text-[10px] font-bold text-emerald-700 uppercase">Subur</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-100">
                    <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                    <span class="text-[10px] font-bold text-amber-700 uppercase">Cukup Subur</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-rose-50 border border-rose-100">
                    <div class="w-2 h-2 rounded-full bg-rose-500"></div>
                    <span class="text-[10px] font-bold text-rose-700 uppercase">Kurang Subur</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Container -->
    <div id="map" class="flex-1 w-full bg-slate-50 dark:bg-slate-700/50" wire:ignore></div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', initMap);
            document.addEventListener('DOMContentLoaded', initMap);

            function initMap() {
                const mapContainer = document.getElementById('map');
                if (!mapContainer || mapContainer.innerHTML.trim() !== '') return;

                const blocks = @json($blocks);

                // Map Colors
                const colors = {
                    emerald: 'rgba(16, 185, 129, 0.5)',
                    amber: 'rgba(245, 158, 11, 0.5)',
                    rose: 'rgba(244, 63, 94, 0.5)',
                    slate: 'rgba(100, 116, 139, 0.5)'
                };

                const strokeColors = {
                    emerald: '#059669',
                    amber: '#d97706',
                    rose: '#e11d48',
                    slate: '#475569'
                };

                // Setup Map
                const map = new ol.Map({
                    target: 'map',
                    layers: [
                        new ol.layer.Tile({
                            source: new ol.source.XYZ({
                                url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
                                maxZoom: 19
                            })
                        })
                    ],
                    view: new ol.View({
                        center: ol.proj.fromLonLat([101.4478, 0.5071]),
                        zoom: 15
                    })
                });

                // Add Features
                const vectorSource = new ol.source.Vector();

                blocks.forEach(block => {
                    if (block.coords && Array.isArray(block.coords) && block.coords.length > 0) {
                        const feature = new ol.Feature({
                            geometry: new ol.geom.Polygon([block.coords.map(coord => ol.proj.fromLonLat(coord))]),
                            name: block.name,
                            status: block.status,
                            area: block.area_ha,
                            color: block.color
                        });

                        feature.setStyle(new ol.style.Style({
                            fill: new ol.style.Fill({ color: colors[block.color] || colors.slate }),
                            stroke: new ol.style.Stroke({ color: strokeColors[block.color] || strokeColors.slate, width: 2 }),
                            text: new ol.style.Text({
                                text: block.name,
                                font: 'bold 12px Inter, sans-serif',
                                fill: new ol.style.Fill({ color: '#fff' }),
                                stroke: new ol.style.Stroke({ color: '#000', width: 2 }),
                                offsetY: -10
                            })
                        }));

                        vectorSource.addFeature(feature);
                    }
                });

                map.addLayer(new ol.layer.Vector({ source: vectorSource }));

                // Add Tooltip for Hover/Click Interaction
                const tooltip = document.createElement('div');
                tooltip.className = "bg-slate-900 dark:bg-white px-4 py-3 rounded-xl shadow-2xl text-xs font-bold text-white dark:text-slate-900 pointer-events-none z-[100] flex flex-col gap-1.5 transition-opacity duration-200 border border-slate-700 dark:border-slate-200";
                tooltip.style.position = "absolute";
                tooltip.style.opacity = "0";
                tooltip.style.transform = "translate(15px, 15px)";
                document.body.appendChild(tooltip);

                map.on('pointermove', function (evt) {
                    const feature = map.forEachFeatureAtPixel(evt.pixel, f => f);
                    if (feature) {
                        tooltip.style.opacity = "1";
                        tooltip.style.left = evt.originalEvent.pageX + "px";
                        tooltip.style.top = evt.originalEvent.pageY + "px";

                        const colorClass = feature.get('color') === 'emerald' ? 'text-emerald-400 dark:text-emerald-600' :
                            (feature.get('color') === 'amber' ? 'text-amber-400 dark:text-amber-600' : 'text-rose-400 dark:text-rose-600');

                        tooltip.innerHTML = `
                                <div class="flex items-center gap-2 border-b border-slate-700 dark:border-slate-200 pb-2 mb-1">
                                    <div class="w-2 h-2 rounded-full bg-${feature.get('color')}-500"></div>
                                    <span class="text-sm font-black tracking-tight">${feature.get("name")}</span>
                                </div>
                                <div class="flex justify-between gap-4">
                                    <span class="text-slate-400 dark:text-slate-500 uppercase tracking-widest text-[9px]">Status</span>
                                    <span class="${colorClass}">${feature.get("status")}</span>
                                </div>
                                <div class="flex justify-between gap-4">
                                    <span class="text-slate-400 dark:text-slate-500 uppercase tracking-widest text-[9px]">Luas Blok</span>
                                    <span>${feature.get("area")} Ha</span>
                                </div>
                            `;
                        map.getTargetElement().style.cursor = 'pointer';
                    } else {
                        tooltip.style.opacity = "0";
                        map.getTargetElement().style.cursor = '';
                    }
                });

                // Center map on features directly without animation
                const extent = vectorSource.getExtent();
                if (!ol.extent.isEmpty(extent)) {
                    map.getView().fit(extent, { padding: [100, 100, 100, 100] });
                }
            }
        </script>
    @endpush
</div>