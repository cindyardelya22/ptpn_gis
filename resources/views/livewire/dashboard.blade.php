<div class="p-3">
    <div class="w-full h-[655px] rounded-2xl overflow-hidden shadow-lg">
        <div wire:ignore id="map" class="w-full h-full"></div>
    </div>
</div>

<script>
    document.addEventListener("livewire:navigated", initMap);
    document.addEventListener("livewire:load", initMap);

    function initMap() {

        if (window.mapInitialized) return;
        window.mapInitialized = true;

        const map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    source: new ol.source.OSM()
                })
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([101.7068, 0.2933]), // Riau
                zoom: 9
            })
        });

        // ===== DATA 3 BLOK LAHAN =====
        const blocks = [{
                name: "Lahan Sawit Blok A",
                url: "/blok-a",
                coords: [
                    [101.60, 0.40],
                    [101.65, 0.42],
                    [101.68, 0.38],
                    [101.62, 0.36],
                    [101.60, 0.40]
                ]
            },
            {
                name: "Lahan Sawit Blok B",
                url: "/blok-b",
                coords: [
                    [101.70, 0.35],
                    [101.75, 0.37],
                    [101.78, 0.34],
                    [101.73, 0.32],
                    [101.70, 0.35]
                ]
            },
            {
                name: "Lahan Sawit Blok C",
                url: "/blok-c",
                coords: [
                    [101.65, 0.30],
                    [101.70, 0.33],
                    [101.72, 0.31],
                    [101.68, 0.28],
                    [101.65, 0.30]
                ]
            }
        ];

        const features = blocks.map(block => {
            const polygon = new ol.Feature({
                geometry: new ol.geom.Polygon([block.coords.map(c => ol.proj.fromLonLat(c))]),
                name: block.name,
                url: block.url
            });
            polygon.setStyle(new ol.style.Style({
                stroke: new ol.style.Stroke({
                    color: '#16a34a', // hijau
                    width: 2
                }),
                fill: new ol.style.Fill({
                    color: 'rgba(22, 163, 74, 0.3)'
                })
            }));
            return polygon;
        });

        const vectorLayer = new ol.layer.Vector({
            source: new ol.source.Vector({
                features: features
            })
        });

        map.addLayer(vectorLayer);

        // ===== Tooltip =====
        const tooltip = document.createElement('div');
        tooltip.className = "bg-white px-2 py-1 rounded shadow text-sm";
        tooltip.style.position = "absolute";
        tooltip.style.display = "none";
        document.body.appendChild(tooltip);

        map.on('pointermove', function(evt) {
            const feature = map.forEachFeatureAtPixel(evt.pixel, f => f);

            if (feature) {
                tooltip.style.display = "block";
                tooltip.style.left = evt.originalEvent.pageX + 10 + "px";
                tooltip.style.top = evt.originalEvent.pageY + 10 + "px";
                tooltip.innerHTML = feature.get("name");

                // === cursor jadi pointer saat hover polygon ===
                map.getTargetElement().style.cursor = 'pointer';
            } else {
                tooltip.style.display = "none";

                // === kembalikan cursor default ===
                map.getTargetElement().style.cursor = '';
            }
        });

        // ===== Click Redirect =====
        map.on('click', function(evt) {
            const feature = map.forEachFeatureAtPixel(evt.pixel, f => f);

            if (feature) {
                window.location.href = feature.get("url");
            }
        });

    }
</script>