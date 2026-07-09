@props(['categories', 'portofolios'])

<style>
    .port-tab-container-relative {
        position: relative;
        width: 100%;
        min-height: 400px; /* Adjust based on content */
    }
    
    .port-tab-content {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transform: translateY(15px) scale(0.985);
        transition: opacity 0.5s cubic-bezier(0.16, 1, 0.3, 1), 
                    transform 0.5s cubic-bezier(0.16, 1, 0.3, 1),
                    visibility 0.5s;
    }
    
    .port-tab-content.active {
        position: relative;
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        transform: translateY(0) scale(1);
    }
</style>

<section id="showcase-portofolio" class="py-10 lg:py-16 bg-[#2C1A0E] relative">
    <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Header -->
        <div class="text-center mb-12 flex flex-col items-center" data-aos="fade-up">
            <span class="text-[#D4A574] font-bold tracking-widest text-sm uppercase mb-2 block">
                {{ __('EXPLORE OUR CREATIVITY') }}
            </span>
            <h2 class="text-4xl sm:text-5xl lg:text-[64px] font-black leading-none tracking-tighter text-white mb-6">
                {{ __('Showcase Portofolio') }}
            </h2>
            <!-- Ornament line with pointed ends -->
            <div class="flex items-center justify-center mx-auto w-full px-8">
                <svg width="100%" height="1" class="max-w-[400px]" viewBox="0 0 400 1" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="0" y1="0.5" x2="400" y2="0.5" stroke="url(#goldGradPort)" stroke-width="1"/>
                    <defs>
                        <linearGradient id="goldGradPort" x1="0" y1="0" x2="400" y2="0" gradientUnits="userSpaceOnUse">
                            <stop offset="0%" stop-color="#b8860b" stop-opacity="0"/>
                            <stop offset="25%" stop-color="#d4a017"/>
                            <stop offset="50%" stop-color="#f0c040"/>
                            <stop offset="75%" stop-color="#d4a017"/>
                            <stop offset="100%" stop-color="#b8860b" stop-opacity="0"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
        </div>

        <!-- Navigation Buttons as Tabs -->
        <div class="flex justify-center mb-2 w-full" data-aos="fade-up" data-aos-delay="100">
            <div class="inline-flex bg-black/20 border border-white/10 p-1.5 rounded-full shadow-inner backdrop-blur-sm relative">
                <!-- Sliding Background -->
                <div id="port-tab-slider" class="absolute top-1.5 bottom-1.5 bg-white rounded-full transition-all duration-300 ease-out z-0"></div>
                
                <button id="tab-portofolio" class="px-8 py-3 rounded-full text-sm font-bold transition-all duration-300 relative z-10 text-[#2C1A0E]">
                    {{ __('Portofolio') }}
                </button>
                <button id="tab-legalitas" class="px-8 py-3 rounded-full text-sm font-bold transition-all duration-300 relative z-10 text-white/80 hover:text-white">
                    {{ __('Legalitas') }}
                </button>
            </div>
        </div>

        <div class="port-tab-container-relative">
            <!-- Portofolio & See More Container -->
            <div id="portfolio-container" class="port-tab-content active">
                <!-- Portofolio Grid -->
                <div class="hidden grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8" id="portfolio-grid">
                    <!-- Backup of old grid, in case we need it, but we replace it with circular gallery -->
                </div>

                @php
                    $galleryItems = [];
                    foreach($portofolios as $item) {
                        $judulData = $item->judul ?? '';
                        $judulArray = is_string($judulData) && str_starts_with($judulData, '{') ? json_decode($judulData, true) : $judulData;
                        $judulText = is_array($judulArray) ? ($judulArray[app()->getLocale()] ?? $judulArray['id'] ?? collect($judulArray)->first() ?? '') : $judulArray;
                        
                        $image = '';
                        if($item->gambar) {
                            $image = asset('storage/image_portofolio/' . $item->gambar);
                        } elseif($item->firstImage) {
                            $image = asset('storage/' . $item->firstImage->image);
                        } else {
                            $image = 'https://picsum.photos/seed/' . $item->id . '/800/600?grayscale';
                        }
                        
                        $galleryItems[] = [
                            'image' => $image,
                            'text' => $judulText,
                            'category' => $item->kategori ?? 'Portofolio',
                            'date' => $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : ($item->created_at ? $item->created_at->format('d M Y') : ''),
                            'url' => route('portofolio.detail', $item->id)
                        ];
                    }
                @endphp

                <!-- Circular Gallery Canvas Container -->
                <div id="circular-gallery-container" style="height: 500px; width: 100%; position: relative; cursor: grab; overflow: hidden; outline: none; border-radius: 1.5rem;" tabindex="0"></div>

                <script type="module">
                    document.addEventListener("DOMContentLoaded", function() {
                        const items = @json($galleryItems);
                        const container = document.getElementById('circular-gallery-container');
                        
                        if(container && window.IntersectionObserver) {
                            const observer = new IntersectionObserver((entries, obs) => {
                                entries.forEach(async entry => {
                                    if(entry.isIntersecting) {
                                        // Dynamically import the gallery script only when visible
                                        if(!window.CircularGalleryApp) {
                                            try {
                                                // We use Vite's dynamic import capabilities
                                                await import('{{ Vite::asset('resources/js/circular-gallery.js') }}');
                                            } catch (e) {
                                                console.error("Failed to load 3D gallery module:", e);
                                            }
                                        }
                                        
                                        setTimeout(() => {
                                            if(window.CircularGalleryApp && !window.portofolioApp) {
                                                window.portofolioApp = new window.CircularGalleryApp(container, {
                                                    items: items,
                                                    bend: 2, 
                                                    textColor: '#ffffff',
                                                    borderRadius: 0.05,
                                                    font: 'bold 30px sans-serif'
                                                });
                                            }
                                        }, 100);
                                        obs.unobserve(entry.target);
                                    }
                                });
                            }, { rootMargin: '200px' });
                            
                            observer.observe(container);
                        }
                    });
                </script>

                <!-- See More Button Container -->
                <div class="mt-12 text-center" id="see-more-container" data-aos="fade-up" data-aos-offset="0">
                    <a href="{{ route('portofolio') }}" id="see-more-btn" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-transparent border-2 border-[#D4A574] text-[#D4A574] rounded-full font-bold uppercase tracking-wider text-sm whitespace-nowrap hover:bg-[#D4A574] hover:text-[#2C1A0E] transition-all duration-300 group shadow-[0_0_15px_rgba(212,165,116,0.2)] hover:shadow-[0_0_25px_rgba(212,165,116,0.4)]">
                        {{ __('See More Portofolio') }}
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Legality Grid (Hidden by default) -->
            <div id="legality-grid" class="port-tab-content">
                @php
                    $legalities = \App\Models\Legality::where('is_active', true)->orderBy('sort_order')->get();
                    $legalitasItems = [];
                    foreach($legalities as $leg) {
                        $legalitasItems[] = [
                            'image' => $leg->image ? asset('storage/' . $leg->image) : '',
                            'text' => app()->getLocale() == 'en' ? $leg->name_en : $leg->name_id,
                            'category' => 'LG',
                            'date' => app()->getLocale() == 'en' ? $leg->description_en : $leg->description_id,
                            'url' => '#'
                        ];
                    }
                @endphp

                <!-- Circular Gallery Canvas Container for Legality -->
                <div id="circular-gallery-legality-container" style="height: 500px; width: 100%; position: relative; cursor: grab; overflow: hidden; outline: none; border-radius: 1.5rem;" tabindex="0"></div>

                <script type="module">
                    document.addEventListener("DOMContentLoaded", function() {
                        const items = @json($legalitasItems);
                        const container = document.getElementById('circular-gallery-legality-container');
                        
                        if(container && window.IntersectionObserver) {
                            const observer = new IntersectionObserver((entries, obs) => {
                                entries.forEach(async entry => {
                                    if(entry.isIntersecting) {
                                        // Initialize only when visible
                                        if(!window.CircularGalleryApp) {
                                            try {
                                                await import('{{ Vite::asset('resources/js/circular-gallery.js') }}');
                                            } catch (e) {
                                                console.error("Failed to load 3D gallery module:", e);
                                            }
                                        }
                                        setTimeout(() => {
                                            if(window.CircularGalleryApp && !window.legalityApp) {
                                                window.legalityApp = new window.CircularGalleryApp(container, {
                                                    items: items,
                                                    bend: 2, 
                                                    textColor: '#ffffff',
                                                    borderRadius: 0.05,
                                                    font: 'bold 30px sans-serif',
                                                    showButton: false
                                                });
                                            }
                                        }, 100);
                                        obs.unobserve(entry.target);
                                    }
                                });
                            }, { rootMargin: '200px' });
                            
                            observer.observe(container);
                        }
                    });
                </script>
            </div>
        </div>
        </div> <!-- End of Tab Container Wrapper -->

        <!-- Empty State Message -->
        <div id="empty-state" class="text-center py-10" style="display: none;">
            <i class="fas fa-box-open text-4xl text-gray-500 mb-3"></i>
            <p class="text-gray-400 font-medium">{{ __('Belum ada portofolio di kategori ini.') }}</p>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const portfolioCards = document.querySelectorAll('.portfolio-card');
        const emptyState = document.getElementById('empty-state');
        const seeMoreContainer = document.getElementById('see-more-container');
        const legalityGrid = document.getElementById('legality-grid');
        const portfolioGrid = document.getElementById('portfolio-grid');
        
        const tabPortofolio = document.getElementById('tab-portofolio');
        const tabLegalitas = document.getElementById('tab-legalitas');
        const slider = document.getElementById('port-tab-slider');

        // Add keyframes for fadeIn dynamically if not exists
        if (!document.getElementById('portfolio-keyframes')) {
            const style = document.createElement('style');
            style.id = 'portfolio-keyframes';
            style.innerHTML = `
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(10px); }
                    to { opacity: 1; transform: translateY(0); }
                }
            `;
            document.head.appendChild(style);
        }

        // Initialize setup for Portofolio tab content
        let visibleCount = 0;
        portfolioCards.forEach(card => {
            if (visibleCount < 6) {
                card.style.display = 'block';
                card.style.animation = `fadeIn 0.5s ease forwards ${visibleCount * 0.1}s`;
                card.style.opacity = '0';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const portfolioContainer = document.getElementById('portfolio-container');

        if (tabPortofolio && tabLegalitas && slider) {
            function updateSlider(element) {
                if(!element) return;
                
                requestAnimationFrame(() => {
                    const rect = element.getBoundingClientRect();
                    const parentRect = element.parentElement.getBoundingClientRect();
                    
                    requestAnimationFrame(() => {
                        slider.style.width = `${rect.width}px`;
                        slider.style.left = `${rect.left - parentRect.left}px`;
                    });
                });
            }

            setTimeout(() => updateSlider(tabPortofolio), 100);

            window.addEventListener('resize', () => {
                const activeBtn = tabPortofolio.classList.contains('text-[#2C1A0E]') ? tabPortofolio : tabLegalitas;
                updateSlider(activeBtn);
            });

            tabPortofolio.addEventListener('click', function() {
                tabPortofolio.classList.remove('text-white/80', 'hover:text-white');
                tabPortofolio.classList.add('text-[#2C1A0E]');
                
                tabLegalitas.classList.remove('text-[#2C1A0E]');
                tabLegalitas.classList.add('text-white/80', 'hover:text-white');

                updateSlider(tabPortofolio);

                if (portfolioContainer && legalityGrid) {
                    legalityGrid.classList.remove('active');
                    portfolioContainer.classList.add('active');
                }
            });

            tabLegalitas.addEventListener('click', function() {
                tabLegalitas.classList.remove('text-white/80', 'hover:text-white');
                tabLegalitas.classList.add('text-[#2C1A0E]');
                
                tabPortofolio.classList.remove('text-[#2C1A0E]');
                tabPortofolio.classList.add('text-white/80', 'hover:text-white');

                updateSlider(tabLegalitas);

                if (portfolioContainer && legalityGrid) {
                    portfolioContainer.classList.remove('active');
                    legalityGrid.classList.add('active');
                }
            });
        }

        // Add ResizeObserver to auto-fix WebGL canvas dimensions
        // whenever the tab containers are shown/hidden or resized.
        setTimeout(() => {
            if (window.ResizeObserver) {
                const resizeObserver = new ResizeObserver(() => {
                    if (window.portofolioApp && typeof window.portofolioApp.onResize === 'function') {
                        window.portofolioApp.onResize();
                    }
                    if (window.legalityApp && typeof window.legalityApp.onResize === 'function') {
                        window.legalityApp.onResize();
                    }
                });
                
                const container1 = document.getElementById('circular-gallery-container');
                const container2 = document.getElementById('circular-gallery-legality-container');
                
                if (container1) resizeObserver.observe(container1);
                if (container2) resizeObserver.observe(container2);
            }
        }, 1000);
    });
</script>
