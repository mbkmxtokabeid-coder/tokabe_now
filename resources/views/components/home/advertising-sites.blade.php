@props(['lokasi', 'lokasiooh'])

@php
    // SIHIR MIMI: Kita buat data dummy cadangan biar 3 kotak tetap terisi penuh dan estetik jika data OOH kosong!
    $dummyOoh = [
        (object)[
            'id' => 1,
            'nama' => 'Jl. Gatot Subroto (Simpang Majestik)',
            'kota' => 'Medan Prime',
            'tipe' => 'Videotron',
            'ukuran' => '4m x 8m',
            'gambar' => 'https://images.unsplash.com/photo-1506146332389-18140dc7b2fb?q=80&w=800&auto=format&fit=crop'
        ],
        (object)[
            'id' => 2,
            'nama' => 'Jl. Jend. Sudirman (Kawasan CBD)',
            'kota' => 'Medan Center',
            'tipe' => 'Billboard',
            'ukuran' => '5m x 10m',
            'gambar' => 'https://images.unsplash.com/photo-1542204165-65bf26472b9b?q=80&w=800&auto=format&fit=crop'
        ],
        (object)[
            'id' => 3,
            'nama' => 'Jl. S. Parman (Cambridge Area)',
            'kota' => 'Medan Premium',
            'tipe' => 'Videotron',
            'ukuran' => '4m x 6m',
            'gambar' => 'https://images.unsplash.com/photo-1517502884422-41eaead166d4?q=80&w=800&auto=format&fit=crop'
        ]
    ];

    $activeOoh = collect($lokasiooh)->where('status', 'Aktif');
    $oohData = $activeOoh->isNotEmpty() ? $activeOoh->take(3) : $dummyOoh;
@endphp

<style>
    .tab-container-relative {
        position: relative;
        width: 100%;
    }
    
    /* Tab Transitions (Buttery-Smooth Cross-Fade) */
    .tab-content {
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
        display: block;
    }
    
    .tab-content.active {
        position: relative;
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        transform: translateY(0) scale(1);
    }

    /* Custom styles for Swiper Pagination */
    .adv-swiper-dooh .swiper-pagination, .adv-swiper-ooh .swiper-pagination {
        bottom: 0px !important;
        position: relative !important;
        margin-top: 24px;
    }
    .adv-swiper-dooh .swiper-pagination-bullet, .adv-swiper-ooh .swiper-pagination-bullet {
        width: 12px !important;
        height: 12px !important;
        margin: 0 12px !important;
        padding: 8px; /* Touch area */
        box-sizing: content-box;
        background-clip: content-box; /* Ensures padding is transparent */
        background-color: #9CA3AF; /* gray-400 */
        opacity: 0.6;
        transition: all 0.3s ease;
        border-radius: 9999px !important;
    }
    
    .adv-swiper-dooh .swiper-pagination-bullet-active, .adv-swiper-ooh .swiper-pagination-bullet-active {
        background-color: #D4A574; /* gold */
        opacity: 1;
        width: 24px !important;
        border-radius: 9999px !important;
    }

    /* Tab switcher pill styling */
    .tab-btn {
        transition: all 0.3s ease;
    }
    
    @keyframes slideInUpAdv {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    @keyframes scaleInAdv {
        0% { opacity: 0; transform: scale(0.9); }
        100% { opacity: 1; transform: scale(1); }
    }
    @keyframes cardRevealAdv {
        0% { opacity: 0; transform: translateY(50px) scale(0.95); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    .adv-observe {
        opacity: 0;
        visibility: hidden;
    }
    .adv-element { transform: translateY(30px); }
    .adv-scale-element { transform: scale(0.9); }
    .adv-card-element { transform: translateY(50px) scale(0.95); }

    .adv-active {
        visibility: visible;
        animation: slideInUpAdv 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .adv-scale-active {
        visibility: visible;
        animation: scaleInAdv 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .adv-card-active {
        visibility: visible;
        animation: cardRevealAdv 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .adv-delay-1 { animation-delay: 0s; }
    .adv-delay-2 { animation-delay: 0.05s; }
    .adv-delay-3 { animation-delay: 0.1s; }
    .adv-delay-4 { animation-delay: 0.15s; }
</style>

<section id="advertising-inventory" class="py-10 lg:py-16 bg-[#2C1A0E] overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Section Header -->
        <div class="text-center mb-10 flex flex-col items-center">
            <span class="adv-observe adv-element adv-delay-1 text-[#D4A574] font-bold tracking-widest text-sm uppercase mb-2 block">
                {{ __('PREMIUM INVENTORY') }}
            </span>
            <h2 class="adv-observe adv-element adv-delay-2 text-4xl sm:text-5xl lg:text-[64px] font-black leading-none tracking-tighter text-white mb-6">
                {{ __('LOKASI PERIKLANAN DI PULAU SUMATERA') }}
            </h2>
            <!-- Ornament line with pointed ends -->
            <div class="adv-observe adv-element adv-delay-3 flex items-center justify-center mx-auto w-full px-8">
                <svg width="100%" height="1" class="max-w-[400px]" viewBox="0 0 400 1" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="0" y1="0.5" x2="400" y2="0.5" stroke="url(#goldGradAdv)" stroke-width="1"/>
                    <defs>
                        <linearGradient id="goldGradAdv" x1="0" y1="0" x2="400" y2="0" gradientUnits="userSpaceOnUse">
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

        <!-- Filter Buttons Custom UI -->
        <div class="adv-observe adv-scale-element adv-delay-4 flex justify-center mb-12 px-4">
            <div class="flex p-1.5 bg-black/20 border border-white/10 backdrop-blur-md rounded-full shadow-inner relative w-full max-w-[340px]">
                <!-- Sliding Background -->
                <div id="tab-slider" class="absolute top-1.5 bottom-1.5 left-1.5 w-[calc(50%-6px)] bg-white rounded-full transition-transform duration-300 ease-out z-0 translate-x-0"></div>
                
                <button id="btn-dooh" onclick="switchTab('dooh')" class="flex-1 py-2.5 sm:py-3 text-[10px] sm:text-sm font-bold uppercase tracking-wider rounded-full relative z-10 text-[#2C1A0E] transition-colors duration-300">
                    DOOH (Digital)
                </button>
                <button id="btn-ooh" onclick="switchTab('ooh')" class="flex-1 py-2.5 sm:py-3 text-[10px] sm:text-sm font-bold uppercase tracking-wider rounded-full relative z-10 text-white/80 hover:text-white transition-colors duration-300">
                    OOH (Billboard)
                </button>
            </div>
        </div>

        <!-- Tab Content Wrapper -->
        <div class="tab-container-relative">
            <!-- DOOH Content Tab -->
            <div id="content-dooh" class="tab-content active">
                <div class="swiper adv-swiper-dooh w-full !pt-6 !pb-12 !-mt-6 !-mb-12">
                    <div class="swiper-wrapper">
                        @php
                            $activeDooh = collect($lokasi)->where('status', 'Aktif')->take(3);
                        @endphp
                        @foreach($activeDooh as $index => $item)
                        @php
                            $namaData = $item->nama ?: ($item->getRawOriginal ? $item->getRawOriginal('nama') : '');
                            $namaArray = is_string($namaData) && str_starts_with($namaData, '{') ? json_decode($namaData, true) : $namaData;
                            $namaDOOH = is_array($namaArray) ? ($namaArray[app()->getLocale()] ?? $namaArray['id'] ?? $namaArray['en'] ?? collect($namaArray)->first() ?? '') : $namaArray;
                            if (empty(trim($namaDOOH))) {
                                $namaDOOH = ($item->provinsi ?? '') . ' - ' . ($item->media ?? '');
                            }
                            $isAvailable = ($item->availability ?? 'Available') !== 'Not Available';
                        @endphp
                        <div class="swiper-slide !h-auto flex w-full sm:w-1/2 lg:w-1/3">
                            <div onclick="window.location.href='{{ route('dooh.detail', $item->id) }}'" 
                                 class="w-full h-full cursor-pointer bg-gradient-to-br from-[#2C1A0E] via-[#5C3317] to-[#8B5E3C] rounded-3xl overflow-hidden shadow-xl border border-white/25 hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 group flex flex-col justify-between">
                    <div>
                        <div class="w-full aspect-[16/10] overflow-hidden bg-[#2C1A0E] relative">
                            <!-- Premium Skeleton Loader -->
                            <div class="absolute inset-0 bg-gradient-to-br from-[#3E2718] to-[#2C1A0E] flex items-center justify-center skeleton-loader" style="z-index: 1;">
                                <div class="absolute inset-0 bg-black/20 animate-pulse"></div>
                                <div class="relative flex flex-col items-center gap-3 animate-pulse">
                                    <i class="fas fa-image text-[#D4A574]/30 text-5xl"></i>
                                    <div class="h-2 w-24 bg-[#D4A574]/20 rounded-full"></div>
                                </div>
                            </div>
                            
                            <img src="{{ $item->gambar ? (Str::startsWith($item->gambar, 'http') ? $item->gambar : asset('storage/image_lokasi/' . $item->gambar)) : 'https://images.unsplash.com/photo-1542204165-65bf26472b9b?q=80&w=600&auto=format&fit=crop' }}" 
                                 onload="this.previousElementSibling.style.display='none'"
                                 alt="{{ \App\Helpers\SeoHelper::getImageAlt('dooh', $namaDOOH, $item->kota ?? 'Medan') }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 relative" style="z-index: 2; {{ !$isAvailable ? 'filter: grayscale(100%);' : '' }}" loading="lazy">
                            
                            @if(!$isAvailable)
                            <div class="absolute inset-0 flex items-center justify-center bg-black/40" style="z-index: 10; pointer-events: none;">
                                <div class="transform -rotate-45 border-4 border-red-600 rounded-lg px-4 py-2 bg-black/50 backdrop-blur-sm">
                                    <span class="text-red-500 text-2xl md:text-3xl font-black uppercase tracking-widest" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">
                                        Not Available
                                    </span>
                                </div>
                            </div>
                            @endif
                            
                            <span class="absolute top-4 left-4 px-3 py-1.5 bg-black/70 backdrop-blur-md text-[#D4A574] text-xs font-bold uppercase tracking-widest rounded-full shadow-md" style="z-index: 3;">
                                {{ $item->wilayah ?? $item->kota ?? 'Medan' }}
                            </span>
                        </div>

                        <div class="p-6 md:p-4">
                            <h3 class="text-lg md:text-sm font-bold text-white mb-3 md:mb-2 line-clamp-2 uppercase tracking-wide group-hover:text-[#D4A574] transition-colors">
                                {{ __($namaDOOH) }}
                            </h3>
                            <div class="flex flex-col gap-3 border-t border-white/20 pt-4 md:pt-3 text-xs md:text-[11px] xl:text-xs text-gray-200">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-layer-group text-[#D4A574]"></i>
                                    <span>{{ $item->media ?? $item->tipe ?? $item->type ?? 'Videotron' }}</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-expand-arrows-alt text-[#D4A574] mt-0.5"></i>
                                    <span class="leading-snug">{{ $item->size ?? $item->ukuran ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 pb-6 md:px-4 md:pb-4 pt-1">
                        <a href="{{ route('dooh.detail', $item->id) }}" class="whitespace-nowrap w-full inline-flex items-center justify-center gap-2 md:gap-1.5 px-6 py-3 md:px-2 md:py-2 bg-gradient-to-r from-[#F5E6C8] to-[#D4A569] text-[#1F1611] font-bold text-sm md:text-[11px] uppercase tracking-wider rounded-full hover:from-[#D4A569] hover:to-[#C8902A] hover:scale-105 hover:shadow-lg hover:shadow-[#D4A569]/40 transition-all duration-300 group/btn shadow-sm">
                            <span>{{ __('View Detail') }}</span>
                            <i class="fas fa-arrow-right text-xs md:text-[10px] transition-transform duration-300 group-hover/btn:translate-x-1"></i>
                        </a>
                    </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination dooh-pagination"></div>
                </div>
            </div>

            <!-- OOH Content Tab -->
            <div id="content-ooh" class="tab-content">
                <div class="swiper adv-swiper-ooh w-full !pt-6 !pb-12 !-mt-6 !-mb-12">
                    <div class="swiper-wrapper">
                        @foreach($oohData as $index => $item)
                        @php
                            $namaData = $item->nama ?: ($item->getRawOriginal ? $item->getRawOriginal('nama') : '');
                            $namaArray = is_string($namaData) && str_starts_with($namaData, '{') ? json_decode($namaData, true) : $namaData;
                            $namaOOH = is_array($namaArray) ? ($namaArray[app()->getLocale()] ?? $namaArray['id'] ?? $namaArray['en'] ?? collect($namaArray)->first() ?? '') : $namaArray;
                            if (empty(trim($namaOOH))) {
                                $namaOOH = ($item->provinsi ?? '') . ' - ' . ($item->media ?? '');
                            }
                            $isAvailable = ($item->availability ?? 'Available') !== 'Not Available';
                        @endphp
                        <div class="swiper-slide !h-auto flex w-full sm:w-1/2 lg:w-1/3">
                            <div onclick="window.location.href='{{ route('ooh.detail', $item->id) }}'" 
                                 class="w-full h-full cursor-pointer bg-gradient-to-br from-[#2C1A0E] via-[#5C3317] to-[#8B5E3C] rounded-3xl overflow-hidden shadow-xl border border-white/25 hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 group flex flex-col justify-between">
                    <div>
                        <div class="w-full aspect-[16/10] overflow-hidden bg-[#2C1A0E] relative">
                            <!-- Premium Skeleton Loader -->
                            <div class="absolute inset-0 bg-gradient-to-br from-[#3E2718] to-[#2C1A0E] flex items-center justify-center skeleton-loader" style="z-index: 1;">
                                <div class="absolute inset-0 bg-black/20 animate-pulse"></div>
                                <div class="relative flex flex-col items-center gap-3 animate-pulse">
                                    <i class="fas fa-image text-[#D4A574]/30 text-5xl"></i>
                                    <div class="h-2 w-24 bg-[#D4A574]/20 rounded-full"></div>
                                </div>
                            </div>
                            
                            <img src="{{ Str::startsWith($item->gambar, 'http') ? $item->gambar : asset('storage/image_lokasiooh/' . $item->gambar) }}" 
                                 onload="this.previousElementSibling.style.display='none'"
                                 alt="{{ \App\Helpers\SeoHelper::getImageAlt('ooh', $namaOOH, $item->kota ?? 'Medan') }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 relative" style="z-index: 2; {{ !$isAvailable ? 'filter: grayscale(100%);' : '' }}" loading="lazy">
                            
                            @if(!$isAvailable)
                            <div class="absolute inset-0 flex items-center justify-center bg-black/40" style="z-index: 10; pointer-events: none;">
                                <div class="transform -rotate-45 border-4 border-red-600 rounded-lg px-4 py-2 bg-black/50 backdrop-blur-sm">
                                    <span class="text-red-500 text-2xl md:text-3xl font-black uppercase tracking-widest" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">
                                        Not Available
                                    </span>
                                </div>
                            </div>
                            @endif
                            
                            <span class="absolute top-4 left-4 px-3 py-1.5 bg-black/70 backdrop-blur-md text-[#D4A574] text-xs font-bold uppercase tracking-widest rounded-full shadow-md" style="z-index: 3;">
                                {{ $item->kota ?? 'Medan' }}
                            </span>
                        </div>

                        <div class="p-6 md:p-4">
                            <h3 class="text-lg md:text-sm font-bold text-white mb-3 md:mb-2 line-clamp-2 uppercase tracking-wide group-hover:text-[#D4A574] transition-colors">
                                {{ __($namaOOH) }}
                            </h3>
                            <div class="flex flex-col gap-3 border-t border-white/20 pt-4 md:pt-3 text-xs md:text-[11px] xl:text-xs text-gray-200">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-layer-group text-[#D4A574]"></i>
                                    <span>{{ $item->tipe ?? $item->type ?? 'Billboard' }}</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <i class="fas fa-expand-arrows-alt text-[#D4A574] mt-0.5"></i>
                                    <span class="leading-snug">{{ $item->ukuran ?? $item->size ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 pb-6 md:px-4 md:pb-4 pt-1">
                        <a href="{{ route('ooh.detail', $item->id) }}" class="whitespace-nowrap w-full inline-flex items-center justify-center gap-2 md:gap-1.5 px-6 py-3 md:px-2 md:py-2 bg-gradient-to-r from-[#F5E6C8] to-[#D4A569] text-[#1F1611] font-bold text-sm md:text-[11px] uppercase tracking-wider rounded-full hover:from-[#D4A569] hover:to-[#C8902A] hover:scale-105 hover:shadow-lg hover:shadow-[#D4A569]/40 transition-all duration-300 group/btn shadow-sm">
                            <span class="whitespace-nowrap">{{ __('View Detail') }}</span>
                            <i class="fas fa-arrow-right text-xs md:text-[10px] transition-transform duration-300 group-hover/btn:translate-x-1"></i>
                        </a>
                    </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination ooh-pagination"></div>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
    function switchTab(type) {
        const btnDooh = document.getElementById('btn-dooh');
        const btnOoh = document.getElementById('btn-ooh');
        const contentDooh = document.getElementById('content-dooh');
        const contentOoh = document.getElementById('content-ooh');
        const slider = document.getElementById('tab-slider');

        if (type === 'dooh') {
            btnDooh.classList.remove('text-white/80', 'hover:text-white');
            btnDooh.classList.add('text-[#2C1A0E]');
            btnOoh.classList.remove('text-[#2C1A0E]');
            btnOoh.classList.add('text-white/80', 'hover:text-white');
            
            if(slider) {
                slider.classList.remove('translate-x-full');
            }

            contentOoh.classList.remove('active');
            contentDooh.classList.add('active');
        } else {
            btnOoh.classList.remove('text-white/80', 'hover:text-white');
            btnOoh.classList.add('text-[#2C1A0E]');
            btnDooh.classList.remove('text-[#2C1A0E]');
            btnDooh.classList.add('text-white/80', 'hover:text-white');
            
            if(slider) {
                slider.classList.add('translate-x-full');
            }

            contentDooh.classList.remove('active');
            contentOoh.classList.add('active');
        }
    }

    // Intersection Observer for Animation
    document.addEventListener("DOMContentLoaded", function() {
        const advTargets = document.querySelectorAll('.adv-observe');
        const observerOptions = { root: null, threshold: 0.1 };

        const advObserver = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (entry.target.classList.contains('adv-scale-element')) {
                        entry.target.classList.add('adv-scale-active');
                    } else if (entry.target.classList.contains('adv-card-element')) {
                        entry.target.classList.add('adv-card-active');
                    } else {
                        entry.target.classList.add('adv-active');
                    }
                    obs.unobserve(entry.target); 
                }
            });
        }, observerOptions);

        advTargets.forEach(target => {
            advObserver.observe(target);
        });

        // Initialize Swiper for DOOH and OOH tabs
        const initAdvSwiper = () => {
            const swiperConfig = {
                loop: true,
                slidesPerView: 1, 
                spaceBetween: 20,
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 24,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 40,
                    }
                }
            };

            if (typeof Swiper !== 'undefined') {
                swiperConfig.pagination = { el: '.dooh-pagination', clickable: true };
                new Swiper('.adv-swiper-dooh', swiperConfig);
                
                swiperConfig.pagination = { el: '.ooh-pagination', clickable: true };
                new Swiper('.adv-swiper-ooh', swiperConfig);
            } else {
                // If Swiper isn't loaded globally, load it (fallback)
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css';
                document.head.appendChild(link);

                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js';
                script.onload = () => {
                    swiperConfig.pagination = { el: '.dooh-pagination', clickable: true };
                    new Swiper('.adv-swiper-dooh', swiperConfig);
                    
                    swiperConfig.pagination = { el: '.ooh-pagination', clickable: true };
                    new Swiper('.adv-swiper-ooh', swiperConfig);
                };
                document.body.appendChild(script);
            }
        };

        initAdvSwiper();
    });
</script>
