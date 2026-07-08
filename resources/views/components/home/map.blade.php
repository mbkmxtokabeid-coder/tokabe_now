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
            <p class="reveal-target-map smooth-element-map delay-map-3 text-lg text-gray-300 font-light">
                {{ __('Click on a province to view OOH/DOOH data (sample).') }}
            </p>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 items-stretch justify-center">
            
            <div class="w-full lg:w-7/12 bg-gradient-to-br from-[#2C1A0E] via-[#5C3317] to-[#8B5E3C] border border-white/25 p-3 rounded-3xl shadow-xl flex flex-col">
                <div class="w-full flex-grow relative min-h-[400px] lg:min-h-[450px]">
                    <svg id="sumatraSvg" class="w-full h-full absolute inset-0 block rounded-xl"></svg>
                </div>
            </div>

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
function initMap() {
    if (mapInitialized) return;
    mapInitialized = true;
    
    const script = document.createElement('script');
    script.src = "https://d3js.org/d3.v7.min.js";
    script.onload = async function() {
        const geoJsonUrl = '/geojson/id.json';
        const apiUrl = '/api/map-data';

        const sumatraProvNames = [
            'Aceh','Sumatera Utara','Sumatera Barat','Riau','Kepulauan Riau',
            'Jambi','Bengkulu','Sumatera Selatan','Bangka Belitung','Lampung','Bangka-Belitung',
        ];

        const svg = d3.select('#sumatraSvg');
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
            const topLocations = allLocations.length > 0 ? allLocations.sort(() => 0.5 - Math.random()).slice(0, 3) : ['{{ __('Location data is currently unavailable') }}'];

            document.getElementById('mapInfoContent').innerHTML = `
                <div class="font-sans text-[15px] leading-relaxed text-gray-300">
                    <div class="font-bold text-2xl text-white">${name}</div>
                    <div class="text-gray-300 mt-1 mb-4">{{ __('OOH/DOOH Information') }}</div>
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
                                    <li class="relative pl-5 text-gray-300">
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
            const [apiData, geojson] = await Promise.all([
                fetch(apiUrl).then(r => r.ok ? r.json() : []),
                d3.json(geoJsonUrl)
            ]);

            const features = (geojson.features || []).filter(f => {
                const n = (f.properties.NAME_1 || f.properties.name || f.properties.provinsi || '').toString();
                return sumatraProvNames.some(s => n.toLowerCase().includes(s.toLowerCase()));
            });

            fc = { type: 'FeatureCollection', features };

            function renderMap() {
                if (!fc) return;
                const container = svg.node().getBoundingClientRect();
                if (container.width === 0) return; // Prevent error if hidden
                projection.fitSize([container.width, container.height], fc);
                g.selectAll('path').attr('d', pathGen);
            }

            g.selectAll('path')
                .data(fc.features)
                .enter()
                .append('path')
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

            setTimeout(renderMap, 100);
            window.addEventListener('resize', renderMap);
            const observer = new ResizeObserver(() => renderMap());
            observer.observe(document.getElementById('mapInfo').parentElement);

        } catch (error) {
            console.error("Error loading map data:", error);
        }
    };
    document.head.appendChild(script);
}

// ⚙️ SCRIPT ANIMASI SCROLL (NEW!)
document.addEventListener("DOMContentLoaded", function() {
    const observerOptions = {
        root: null,
        threshold: 0.15 
    };

    const observerMap = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('smooth-active-map');
                obs.unobserve(entry.target); 
                initMap(); // Lazy load the map resources when section becomes visible
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal-target-map, #sumatraSvg').forEach(el => observerMap.observe(el));
});
</script>