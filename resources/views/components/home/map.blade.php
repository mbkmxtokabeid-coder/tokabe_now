<style>
    @keyframes slideInUpSmoothMap {
        0% { opacity: 0; transform: translateY(60px); filter: blur(5px); }
        100% { opacity: 1; transform: translateY(0); filter: blur(0); }
    }
    .smooth-element-map {
        opacity: 0; 
        transform: translateY(60px); 
        backface-visibility: hidden;
    }
    .smooth-active-map {
        animation: slideInUpSmoothMap 1.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .delay-map-1 { animation-delay: 0.1s; }
    .delay-map-2 { animation-delay: 0.3s; }
    .delay-map-3 { animation-delay: 0.5s; }
    
    /* Custom Scrollbar for Map Locations */
    .map-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .map-scrollbar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05); 
        border-radius: 4px;
    }
    .map-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(212, 165, 116, 0.5); 
        border-radius: 4px;
    }
    .map-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(212, 165, 116, 0.8); 
    }
</style>

<section class="w-full py-10 lg:py-16 bg-[#2C1A0E] overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12 flex flex-col items-center">
            <h2 class="reveal-target-map smooth-element-map delay-map-1 text-3xl md:text-4xl font-extrabold text-[#f2ebe2] mb-6 tracking-tight uppercase">
                {{ __('LOKASI PERIKLANAN DI PULAU SUMATERA') }}
            </h2>
            <!-- Ornament line with pointed ends -->
            <div class="reveal-target-map smooth-element-map delay-map-2 flex items-center justify-center mx-auto w-full px-8 mb-6">
                <svg width="100%" height="1" class="max-w-[400px]" viewBox="0 0 400 1" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="0" y1="0.5" x2="400" y2="0.5" stroke="url(#goldGradMap)" stroke-width="1"/>
                    <defs>
                        <linearGradient id="goldGradMap" x1="0" y1="0" x2="400" y2="0" gradientUnits="userSpaceOnUse">
                            <stop offset="0%" stop-color="#b8860b" stop-opacity="0"/>
                            <stop offset="25%" stop-color="#d4a017"/>
                            <stop offset="50%" stop-color="#f0c040"/>
                            <stop offset="75%" stop-color="#d4a017"/>
                            <stop offset="100%" stop-color="#b8860b" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="reveal-target-map smooth-element-map delay-map-3 flex items-center justify-center mt-2">
                <div class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-[#2C1A0E] via-[#5C3317] to-[#2C1A0E] border border-[#D4A574]/50 rounded-full shadow-[0_0_15px_rgba(212,165,116,0.3)]">
                    <div class="relative flex h-5 w-5 justify-center items-center">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#F0C97A] opacity-75"></span>
                        <i class="fas fa-hand-pointer relative inline-flex text-[#F0C97A] text-lg"></i>
                    </div>
                    <p class="text-base md:text-lg text-[#f2ebe2] font-semibold tracking-wide">
                        {{ __('Click on a province to view OOH/DOOH data.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 items-stretch justify-center">
            
            <!-- Map Container -->
            <div class="w-full lg:w-7/12 bg-gradient-to-br from-[#2C1A0E] via-[#5C3317] to-[#8B5E3C] border border-white/25 p-3 rounded-3xl shadow-xl flex flex-col relative overflow-hidden">
                <!-- Loading Spinner / Indicator -->
                <div id="mapLoader" class="absolute inset-0 flex flex-col items-center justify-center gap-3 bg-[#2C1A0E]/80 backdrop-blur-sm z-20 transition-opacity duration-500">
                    <div class="w-10 h-10 border-4 border-[#D4A574]/30 border-t-[#F0C97A] rounded-full animate-spin"></div>
                    <span class="text-xs font-semibold tracking-wider text-[#F0C97A] uppercase">Memuat Peta Sumatra...</span>
                </div>

                <div class="w-full flex-grow relative min-h-[400px] lg:min-h-[450px]">
                    <svg id="sumatraSvg" class="w-full h-full absolute inset-0 block rounded-xl"></svg>
                </div>
            </div>

            <!-- Detail Info Panel -->
            <aside id="mapInfo" class="w-full lg:w-5/12 bg-gradient-to-br from-[#2C1A0E] via-[#5C3317] to-[#8B5E3C] border border-white/25 p-6 rounded-3xl shadow-xl flex flex-col justify-center">
                <div id="mapInfoContent" class="font-sans text-sm w-full">
                    <div class="font-bold text-2xl text-white mb-1">{{ __('Select a province on the map') }}</div>
                    <div class="text-gray-300">{{ __('OOH/DOOH information will be displayed here') }}</div>
                </div>
            </aside>

        </div>
    </div>
</section>

<script>
let mapInitialized = false;

function loadD3Script(callback) {
    if (typeof window.d3 !== 'undefined') {
        callback();
        return;
    }
    const script = document.createElement('script');
    script.src = "https://cdnjs.cloudflare.com/ajax/libs/d3/7.9.0/d3.min.js";
    script.onload = callback;
    script.onerror = function() {
        // Fallback CDN if cloudflare fails
        const fallbackScript = document.createElement('script');
        fallbackScript.src = "https://d3js.org/d3.v7.min.js";
        fallbackScript.onload = callback;
        document.head.appendChild(fallbackScript);
    };
    document.head.appendChild(script);
}

function initMap() {
    if (mapInitialized) return;
    mapInitialized = true;

    loadD3Script(async function() {
        // Use lightweight Sumatra-only GeoJSON (239 KB vs 2.56 MB full ID)
        const primaryGeoJsonUrl = '{{ asset('geojson/sumatra.json') }}';
        const fallbackGeoJsonUrl = '{{ asset('geojson/id.json') }}';
        const apiUrl = '/api/map-data';

        const sumatraProvNames = [
            'Aceh','Sumatera Utara','Sumatera Barat','Riau','Kepulauan Riau',
            'Jambi','Bengkulu','Sumatera Selatan','Bangka Belitung','Lampung','Bangka-Belitung',
        ];

        const svg = d3.select('#sumatraSvg');
        // Clear any old group if reloaded
        svg.selectAll('*').remove();
        const g = svg.append('g');
        const projection = d3.geoMercator();
        const pathGen = d3.geoPath().projection(projection);
        let fc = null; 

        function showInfo(props, data) {
            const name = props.NAME_1 || props.name || props.provinsi || '';
            const found = data.find(item => item.provinsi && name.toLowerCase().includes(item.provinsi.toLowerCase()));
            
            const billboards = found ? found.billboards : 0;
            const videotron = found ? found.videotron : 0;
            const allLocations = [...(found?.lokasi_ooh || []), ...(found?.lokasi_videotron || [])];
            const topLocations = allLocations.length > 0 ? allLocations.slice(0, 4) : ['{{ __('Location data is currently unavailable') }}'];

            const contentEl = document.getElementById('mapInfoContent');
            if (!contentEl) return;

            contentEl.innerHTML = `
                <div class="font-sans text-[15px] leading-relaxed text-gray-300">
                    <div class="font-bold text-2xl text-white">${name}</div>
                    <div class="text-[#F0C97A] text-xs font-semibold uppercase tracking-wider mt-1 mb-4">{{ __('OOH/DOOH Information') }}</div>
                    <div class="border-t border-white/20 pt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-300">{{ __('Billboard') }}</span><strong class="text-lg text-white">${billboards}</strong>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-gray-300">{{ __('Videotron') }}</span><strong class="text-lg text-white">${videotron}</strong>
                        </div>
                        <div class="mt-4">
                            <strong class="text-white">{{ __('Top Locations') }}</strong>
                            <ul class="mt-3 space-y-2 max-h-36 overflow-y-auto pr-2 map-scrollbar">
                                ${topLocations.map(l => `
                                    <li class="relative pl-5 text-gray-300 text-xs sm:text-sm">
                                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-2 h-2 bg-[#D4A574] rounded-full"></span>
                                        ${l}
                                    </li>`).join('')}
                            </ul>
                        </div>
                        <a href="/discover?region=${encodeURIComponent(name)}" class="inline-flex items-center gap-2 mt-6 px-6 py-2.5 bg-gradient-to-r from-[#C8902A] via-[#F0C97A] to-[#C8902A] text-[#1F1611] font-extrabold rounded-full shadow-[0_0_15px_rgba(212,165,105,0.6)] hover:shadow-[0_0_25px_rgba(240,201,122,0.8)] hover:from-[#F0C97A] hover:to-[#C8902A] transform hover:-translate-y-0.5 hover:scale-105 transition-all duration-300">
                            {{ __('Discover More') }} <i class="fas fa-arrow-right text-sm"></i>
                        </a>
                    </div>
                </div>`;
        }

        try {
            // Fetch geojson (prefer lightweight sumatra.json, fallback to id.json)
            const [apiData, geojson] = await Promise.all([
                fetch(apiUrl).then(r => r.ok ? r.json() : []).catch(() => []),
                fetch(primaryGeoJsonUrl)
                    .then(r => r.ok ? r.json() : fetch(fallbackGeoJsonUrl).then(fr => fr.json()))
                    .catch(() => fetch(fallbackGeoJsonUrl).then(fr => fr.json()))
            ]);

            const features = (geojson.features || []).filter(f => {
                const n = (f.properties.NAME_1 || f.properties.name || f.properties.provinsi || '').toString();
                return sumatraProvNames.some(s => n.toLowerCase().includes(s.toLowerCase()));
            });

            fc = { type: 'FeatureCollection', features };

            function renderMap() {
                if (!fc || !svg.node()) return;
                const container = svg.node().getBoundingClientRect();
                const w = container.width > 0 ? container.width : 500;
                const h = container.height > 100 ? container.height : 450;
                projection.fitSize([w, h], fc);
                g.selectAll('path').attr('d', pathGen);
            }

            // Initial projection sizing
            const initialBbox = svg.node().getBoundingClientRect();
            const initialW = initialBbox.width > 0 ? initialBbox.width : 500;
            const initialH = initialBbox.height > 100 ? initialBbox.height : 450;
            projection.fitSize([initialW, initialH], fc);

            // Render path elements immediately with d attribute
            const paths = g.selectAll('path')
                .data(fc.features)
                .enter()
                .append('path')
                .attr('d', pathGen)
                .attr('fill', '#ffffff')
                .attr('stroke', '#8B5E3C')
                .attr('stroke-width', 1.5)
                .style('cursor', 'pointer')
                .style('transition', 'fill 0.2s ease')
                .on('mouseenter', function() { 
                    const isSelected = d3.select(this).attr('data-selected') === 'true';
                    if(!isSelected) d3.select(this).attr('fill', '#E5D5C5'); 
                })
                .on('mouseleave', function() { 
                    const isSelected = d3.select(this).attr('data-selected') === 'true';
                    if(!isSelected) d3.select(this).attr('fill', '#ffffff'); 
                })
                .on('click', function(event, d) {
                    g.selectAll('path').attr('stroke', '#8B5E3C').attr('stroke-width', 1.5).attr('fill', '#ffffff').attr('data-selected', 'false');
                    d3.select(this).attr('stroke', '#5C3317').attr('stroke-width', 2.5).attr('fill', '#D4A574').attr('data-selected', 'true');
                    showInfo(d.properties, apiData);
                });

            // Hide loader smoothly
            const loader = document.getElementById('mapLoader');
            if (loader) {
                loader.style.opacity = '0';
                loader.style.pointerEvents = 'none';
                setTimeout(() => loader.remove(), 400);
            }

            // Auto-select Sumatera Utara by default on load
            const sumutPath = paths.filter(d => {
                const name = (d.properties.NAME_1 || d.properties.name || d.properties.provinsi || '').toString();
                return name.toLowerCase().includes('sumatera utara');
            });

            if (!sumutPath.empty()) {
                sumutPath.attr('stroke', '#5C3317').attr('stroke-width', 2.5).attr('fill', '#D4A574').attr('data-selected', 'true');
                showInfo(sumutPath.datum().properties, apiData);
            } else if (fc.features.length > 0) {
                // Fallback select first feature
                paths.filter((d, i) => i === 0).attr('stroke', '#5C3317').attr('stroke-width', 2.5).attr('fill', '#D4A574').attr('data-selected', 'true');
                showInfo(fc.features[0].properties, apiData);
            }

            // Resize listeners
            setTimeout(renderMap, 100);
            window.addEventListener('resize', renderMap);
            if (window.ResizeObserver) {
                const containerParent = document.getElementById('mapInfo')?.parentElement;
                if (containerParent) {
                    const observer = new ResizeObserver(() => renderMap());
                    observer.observe(containerParent);
                }
            }

        } catch (error) {
            console.error("Error loading map data:", error);
            const loader = document.getElementById('mapLoader');
            if (loader) {
                loader.innerHTML = '<span class="text-xs text-red-300">Gagal memuat peta. Silakan muat ulang halaman.</span>';
            }
        }
    });
}

// ⚙️ INITIALIZATION TRIGGER
document.addEventListener("DOMContentLoaded", function() {
    // Eager IntersectionObserver with generous rootMargin (350px before entering viewport)
    if ('IntersectionObserver' in window) {
        const observerMap = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('smooth-active-map');
                    obs.unobserve(entry.target); 
                    initMap(); 
                }
            });
        }, { root: null, rootMargin: '350px 0px', threshold: 0.01 });

        document.querySelectorAll('.reveal-target-map, #sumatraSvg').forEach(el => observerMap.observe(el));
    }

    // Safety fallback: if user is on desktop or observer doesn't fire, init within 2.5s anyway
    setTimeout(function() {
        if (!mapInitialized) {
            initMap();
        }
    }, 2500);
});
</script>