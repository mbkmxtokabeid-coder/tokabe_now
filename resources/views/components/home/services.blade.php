<style>
    /* --- 1. Keyframes & Class buat Judul (Smooth Slide-Up) --- */
    @keyframes slideInUpSmooth {
        0% { opacity: 0; transform: translateY(40px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .smooth-element {
        opacity: 0; /* Sembunyikan sebelum animasi mulai */
    }

    .smooth-active {
        /* Pake timing curve ease-out exponential biar gerakannya "mahal", nge-glide lembut di akhir */
        animation: slideInUpSmooth 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    /* Delay cascaded/berurutan untuk teks judul */
    .title-delay-1 { animation-delay: 0.1s; } /* Subtitle */
    .title-delay-2 { animation-delay: 0.3s; } /* Main H2 */
    .title-delay-3 { animation-delay: 0.5s; } /* Yellow Bar */

    /* Custom styles for Swiper Pagination */
    .services-swiper .swiper-pagination {
        bottom: 0px !important;
        position: relative !important;
        margin-top: 24px;
    }
    .services-swiper .swiper-pagination-bullet {
        cursor: pointer;
        width: 12px !important;
        height: 12px !important;
        margin: 0 12px !important;
        padding: 8px; /* 12 + 16 = 28px touch area */
        box-sizing: content-box;
        background-clip: content-box; /* Ensures padding remains transparent */
        background-color: #9CA3AF;
        opacity: 0.6;
        transition: all 0.3s ease;
        border-radius: 9999px !important;
        outline: none !important;
    }
    .services-swiper .swiper-pagination-bullet:hover {
        opacity: 0.9;
    }
    .services-swiper .swiper-pagination-bullet:focus,
    .services-swiper .swiper-pagination-bullet:focus-visible {
        outline: none !important;
        box-shadow: none !important;
    }
    .services-swiper .swiper-pagination-bullet-active {
        background-color: #D4A574; /* gold */
        opacity: 1;
        width: 24px !important;
        border-radius: 9999px !important;
    }

    /* Custom styles for Mobile Swiper */
    .services-mobile-swiper .swiper-slide {
        height: auto !important;
        display: flex;
        justify-content: center;
    }
    .services-mobile-pagination {
        position: relative !important;
        bottom: 0 !important;
        margin-top: 4px;
        display: flex !important;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .services-mobile-pagination .swiper-pagination-bullet {
        cursor: pointer;
        width: 8px !important;
        height: 8px !important;
        margin: 0 !important;
        background-color: rgba(156, 163, 175, 0.6) !important;
        opacity: 0.6;
        transition: all 0.3s ease;
        border-radius: 9999px !important;
        outline: none !important;
    }
    .services-mobile-pagination .swiper-pagination-bullet:hover {
        opacity: 0.9;
    }
    .services-mobile-pagination .swiper-pagination-bullet-active {
        background-color: #D4A574 !important;
        opacity: 1 !important;
        width: 24px !important;
        height: 8px !important;
        border-radius: 9999px !important;
    }

    /* Hide scrollbar for Chrome, Safari, Edge, Firefox */
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<section id="services" class="py-10 lg:py-16 bg-[#2C1A0E] relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Bagian Judul -->
        <div class="mb-12 lg:mb-16 text-center flex flex-col items-center">
            <div class="reveal-target-service smooth-element title-delay-1">
                <h2 class="text-4xl sm:text-5xl lg:text-[64px] font-black leading-none tracking-tighter text-white mb-6 uppercase">
                    {{ __('Our Service') }}
                </h2>
                <!-- Ornament line with pointed ends -->
                <div class="smooth-element title-delay-3 flex items-center justify-center mx-auto mt-6 w-full px-8">
                    <svg width="100%" height="1" class="max-w-[400px]" viewBox="0 0 400 1" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <line x1="0" y1="0.5" x2="400" y2="0.5" stroke="url(#goldGradSvc)" stroke-width="1"/>
                        <defs>
                            <linearGradient id="goldGradSvc" x1="0" y1="0" x2="400" y2="0" gradientUnits="userSpaceOnUse">
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
        </div>

        <!-- Desktop View (Swiper) -->
        <div class="relative group/slider hidden md:block px-10 lg:px-14 xl:px-16">
            <!-- Container Slider -->
            <div id="services-slider" class="swiper services-swiper w-full !pt-6 !pb-12 !-mt-6 !-mb-12">
                <div class="swiper-wrapper">
                    @foreach($services->chunk(3) as $pageIndex => $chunk)
                    <div class="swiper-slide !h-auto w-full">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 xl:gap-10 w-full h-full items-stretch">
                            @foreach($chunk as $itemIndex => $item)
                            @php
                                // Get title properly handling JSON arrays if any
                                $judul = is_array($item->judul) ? ($item->judul[app()->getLocale()] ?? $item->judul['id'] ?? $item->judul['en'] ?? collect($item->judul)->first() ?? '') : $item->judul;
                                
                                // Get description properly handling JSON arrays if any
                                $deskripsi = is_array($item->deskripsi) ? ($item->deskripsi[app()->getLocale()] ?? $item->deskripsi['id'] ?? $item->deskripsi['en'] ?? collect($item->deskripsi)->first() ?? '') : $item->deskripsi;
                                
                                // Clean description and limit it
                                $cleanDesc = strip_tags($deskripsi);
                                $shortDesc = \Illuminate\Support\Str::limit($cleanDesc, 90, '...');
                            @endphp
                            <div class="h-full flex flex-col {{ $chunk->count() === 1 ? 'md:col-start-2' : '' }}">
                                <div onclick="window.location.href='{{ route('services.show', $item->endpoint) }}'" class="w-full h-full cursor-pointer bg-gradient-to-br from-[#2C1A0E] via-[#5C3317] to-[#8B5E3C] rounded-3xl overflow-hidden shadow-xl border border-white/25 hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 group flex flex-col justify-between">
                                    
                                    <div>
                                        <!-- Bagian Gambar / Media -->
                                        <div class="w-full aspect-[16/10] overflow-hidden bg-[#2C1A0E] relative">
                                            <!-- Premium Skeleton Loader -->
                                            <div class="absolute inset-0 bg-gradient-to-br from-[#3E2718] to-[#2C1A0E] flex items-center justify-center skeleton-loader" style="z-index: 1;">
                                                <div class="absolute inset-0 bg-black/20 animate-pulse"></div>
                                                <div class="relative flex flex-col items-center gap-3 animate-pulse">
                                                    <i class="fas fa-image text-[#D4A574]/30 text-5xl"></i>
                                                    <div class="h-2 w-24 bg-[#D4A574]/20 rounded-full"></div>
                                                </div>
                                            </div>
                                            
                                            @if(Str::endsWith($item->gambar, ['.mp4', '.webm', '.ogg']))
                                                <video autoplay loop muted playsinline class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 relative" style="z-index: 2;" onloadeddata="this.previousElementSibling.style.opacity='0'">
                                                    <source src="{{ asset('storage/image_service/' . $item->gambar) }}" type="video/mp4">
                                                </video>
                                            @elseif($item->gambar)
                                                <img src="{{ asset('storage/image_service/' . $item->gambar) }}" onload="this.previousElementSibling.style.opacity='0'" alt="{{ \App\Helpers\SeoHelper::getImageAlt('service', $judul) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 relative" style="z-index: 2;" loading="lazy">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-[#2C1A0E]">
                                                    <i class="{{ $item->ikon ?? 'fas fa-desktop' }} text-3xl text-white/50"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Bagian Teks -->
                                        <div class="p-6 lg:p-4 xl:p-6">
                                            <h3 class="text-lg lg:text-sm xl:text-lg font-bold text-white mb-3 lg:mb-2 xl:mb-3 line-clamp-2 uppercase tracking-wide group-hover:text-[#D4A574] transition-colors">
                                                {{ $judul }}
                                            </h3>
                                            
                                            <div class="border-t border-white/20 pt-4 lg:pt-3 xl:pt-4 text-xs sm:text-sm lg:text-[10px] xl:text-sm text-gray-200">
                                                <p class="line-clamp-2">
                                                    {{ $shortDesc }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="px-6 pb-6 lg:px-4 lg:pb-4 xl:px-6 xl:pb-6 pt-1 mt-auto">
                                        <a href="{{ route('services.show', $item->endpoint) }}" class="whitespace-nowrap w-full inline-flex items-center justify-center gap-2 px-6 py-3 lg:px-4 lg:py-2 xl:px-6 xl:py-3 bg-gradient-to-r from-[#F5E6C8] to-[#D4A569] text-[#1F1611] font-bold text-sm lg:text-[10px] xl:text-sm uppercase tracking-wider rounded-full hover:from-[#D4A569] hover:to-[#C8902A] hover:scale-105 hover:shadow-lg hover:shadow-[#D4A569]/40 transition-all duration-300 group/btn shadow-sm">
                                            <span>{{ __('Lihat Detail') }}</span>
                                            <i class="fas fa-arrow-right text-xs lg:text-[10px] xl:text-xs transition-transform duration-300 group-hover/btn:translate-x-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination Dots -->
                <div class="swiper-pagination"></div>
            </div>
        
            <!-- Navigation Buttons (Side Left & Right - Separated from cards) -->
            <button class="services-button-prev absolute -left-3 lg:-left-4 xl:-left-6 top-[44%] -translate-y-1/2 z-20 bg-[#1F1611]/90 backdrop-blur-md border border-[#D4A574]/40 text-[#D4A574] w-10 h-10 lg:w-12 lg:h-12 rounded-full shadow-[0_4px_20px_rgba(0,0,0,0.5)] flex items-center justify-center hover:bg-[#D4A574] hover:text-[#1F1611] hover:border-[#D4A574] hover:scale-110 hover:shadow-[0_0_20px_rgba(212,165,116,0.6)] transition-all duration-300 cursor-pointer group focus:outline-none" aria-label="Previous">
                <i class="fas fa-chevron-left text-xs lg:text-sm group-hover:-translate-x-0.5 transition-transform duration-300"></i>
            </button>
            <button class="services-button-next absolute -right-3 lg:-right-4 xl:-right-6 top-[44%] -translate-y-1/2 z-20 bg-[#1F1611]/90 backdrop-blur-md border border-[#D4A574]/40 text-[#D4A574] w-10 h-10 lg:w-12 lg:h-12 rounded-full shadow-[0_4px_20px_rgba(0,0,0,0.5)] flex items-center justify-center hover:bg-[#D4A574] hover:text-[#1F1611] hover:border-[#D4A574] hover:scale-110 hover:shadow-[0_0_20px_rgba(212,165,116,0.6)] transition-all duration-300 cursor-pointer group focus:outline-none" aria-label="Next">
                <i class="fas fa-chevron-right text-xs lg:text-sm group-hover:translate-x-0.5 transition-transform duration-300"></i>
            </button>
        </div>

        <!-- Mobile View (Infinite Loop Horizontal Swiper) -->
        <div class="w-full relative block md:hidden">
            <!-- Swiper Slider Container -->
            <div id="services-mobile-slider" class="swiper services-mobile-swiper w-full overflow-hidden !py-2">
                <div class="swiper-wrapper">
                    @foreach($services as $index => $item)
                    @php
                        $judul = is_array($item->judul) ? ($item->judul[app()->getLocale()] ?? $item->judul['id'] ?? $item->judul['en'] ?? collect($item->judul)->first() ?? '') : $item->judul;
                        $deskripsi = is_array($item->deskripsi) ? ($item->deskripsi[app()->getLocale()] ?? $item->deskripsi['id'] ?? $item->deskripsi['en'] ?? collect($item->deskripsi)->first() ?? '') : $item->deskripsi;
                        $cleanDesc = strip_tags($deskripsi);
                        $shortDesc = \Illuminate\Support\Str::limit($cleanDesc, 90, '...');
                    @endphp
                    <div class="swiper-slide !h-auto flex justify-center">
                        <div onclick="window.location.href='{{ route('services.show', $item->endpoint) }}'" class="w-full max-w-[320px] h-full cursor-pointer bg-gradient-to-br from-[#2C1A0E] via-[#5C3317] to-[#8B5E3C] rounded-3xl overflow-hidden shadow-xl border border-white/20 active:scale-[0.98] transition-transform duration-200 flex flex-col justify-between">
                            <div>
                                <!-- Bagian Gambar / Media -->
                                <div class="w-full aspect-[16/10] overflow-hidden bg-[#2C1A0E] relative">
                                    <!-- Premium Skeleton Loader -->
                                    <div class="absolute inset-0 bg-gradient-to-br from-[#3E2718] to-[#2C1A0E] flex items-center justify-center skeleton-loader" style="z-index: 1;">
                                        <div class="absolute inset-0 bg-black/20 animate-pulse"></div>
                                        <div class="relative flex flex-col items-center gap-3 animate-pulse">
                                            <i class="fas fa-image text-[#D4A574]/30 text-5xl"></i>
                                            <div class="h-2 w-24 bg-[#D4A574]/20 rounded-full"></div>
                                        </div>
                                    </div>
                                    
                                    @if(Str::endsWith($item->gambar, ['.mp4', '.webm', '.ogg']))
                                        <video autoplay loop muted playsinline class="w-full h-full object-cover relative" style="z-index: 2;" onloadeddata="this.previousElementSibling.style.opacity='0'">
                                            <source src="{{ asset('storage/image_service/' . $item->gambar) }}" type="video/mp4">
                                        </video>
                                    @elseif($item->gambar)
                                        <img src="{{ asset('storage/image_service/' . $item->gambar) }}" onload="this.previousElementSibling.style.opacity='0'" alt="{{ \App\Helpers\SeoHelper::getImageAlt('service', $judul) }}" class="w-full h-full object-cover relative" style="z-index: 2;" loading="lazy">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-[#2C1A0E]">
                                            <i class="{{ $item->ikon ?? 'fas fa-desktop' }} text-3xl text-white/50"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Bagian Teks -->
                                <div class="p-5">
                                    <h3 class="text-base font-bold text-white mb-2 line-clamp-2 uppercase tracking-wide">
                                        {{ $judul }}
                                    </h3>
                                    
                                    <div class="border-t border-white/20 pt-3 text-xs text-gray-200">
                                        <p class="line-clamp-2 leading-relaxed">
                                            {{ $shortDesc }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="px-5 pb-5 pt-1 mt-auto">
                                <a href="{{ route('services.show', $item->endpoint) }}" class="whitespace-nowrap w-full inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-[#F5E6C8] to-[#D4A569] text-[#1F1611] font-bold text-xs uppercase tracking-wider rounded-full shadow-sm hover:from-[#D4A569] hover:to-[#C8902A] transition-all">
                                    <span>{{ __('Lihat Detail') }}</span>
                                    <i class="fas fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Mobile Navigation Dots & Swipe Hint -->
            <div class="flex flex-col items-center gap-2 mt-4">
                <div class="swiper-pagination services-mobile-pagination"></div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const textTargets = document.querySelectorAll('.smooth-element');
        
        const observerOptions = {
            root: null,
            threshold: 0.15 // Triggers relatively early so text starts flowing nicely
        };

        const serviceObserver = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    if (entry.target.classList.contains('smooth-element')) {
                         entry.target.classList.add('smooth-active');
                    }
                    obs.unobserve(entry.target);
                }
            });
        }, observerOptions);

        textTargets.forEach(target => {
            serviceObserver.observe(target);
        });

        // Custom Swiper Pagination Click Handler (Mengatasi transisi sirkular loop halaman)
        const setupCustomPagination = (swiperInstance) => {
            const paginationEl = document.querySelector('.services-swiper .swiper-pagination');
            if (!paginationEl) return;

            if (paginationEl._customPaginationHandler) {
                paginationEl.removeEventListener('click', paginationEl._customPaginationHandler);
            }

            paginationEl._customPaginationHandler = (e) => {
                const bullet = e.target.closest('.swiper-pagination-bullet');
                if (!bullet || !swiperInstance || swiperInstance.animating) return;

                const bullets = Array.from(paginationEl.querySelectorAll('.swiper-pagination-bullet'));
                const targetIndex = bullets.indexOf(bullet);
                if (targetIndex === -1) return;

                const activeBullet = paginationEl.querySelector('.swiper-pagination-bullet-active');
                const currentIndex = activeBullet ? bullets.indexOf(activeBullet) : swiperInstance.realIndex;

                if (targetIndex === currentIndex) return;

                const totalBullets = bullets.length;
                if (totalBullets <= 1) return;

                // Hitung langkah terpendek pada sirkular loop
                const forwardSteps = (targetIndex - currentIndex + totalBullets) % totalBullets;
                const backwardSteps = (currentIndex - targetIndex + totalBullets) % totalBullets;

                if (forwardSteps <= backwardSteps) {
                    if (forwardSteps === 1) {
                        swiperInstance.slideNext();
                    } else {
                        swiperInstance.slideToLoop(targetIndex);
                    }
                } else {
                    if (backwardSteps === 1) {
                        swiperInstance.slidePrev();
                    } else {
                        swiperInstance.slideToLoop(targetIndex);
                    }
                }
            };

            paginationEl.addEventListener('click', paginationEl._customPaginationHandler);
        };

        // Swiper Script Loader Helper
        const loadSwiper = (onReady) => {
            if (typeof Swiper !== 'undefined') {
                onReady();
                return;
            }
            if (!document.querySelector('link[href*="swiper-bundle"]')) {
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css';
                document.head.appendChild(link);
            }
            const existingScript = document.querySelector('script[src*="swiper-bundle"]');
            if (existingScript) {
                existingScript.addEventListener('load', onReady);
            } else {
                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js';
                script.onload = onReady;
                document.body.appendChild(script);
            }
        };

        // Desktop Swiper Logic (1 Slide = 1 Halaman berisi hingga 3 Card Layanan)
        let desktopSwiper = null;
        const initDesktopSwiper = () => {
            const sliderEl = document.querySelector('#services-slider');
            if (!sliderEl || desktopSwiper) return;
            const slideCount = sliderEl.querySelectorAll('.swiper-slide').length;

            loadSwiper(() => {
                desktopSwiper = new Swiper('#services-slider', {
                    loop: slideCount > 1,
                    slidesPerView: 1, 
                    slidesPerGroup: 1,
                    spaceBetween: 32,
                    speed: 600,
                    observer: true,
                    observeParents: true,
                    pagination: {
                        el: '#services-slider .swiper-pagination',
                        clickable: false,
                    },
                    navigation: {
                        nextEl: '.services-button-next',
                        prevEl: '.services-button-prev',
                    },
                });
                setupCustomPagination(desktopSwiper);
            });
        };

        // Mobile Swiper Logic (Unlimited / Infinite Loop 1 Card Centered with Peek)
        let mobileSwiper = null;
        const initMobileSwiper = () => {
            const mobileEl = document.querySelector('#services-mobile-slider');
            if (!mobileEl || mobileSwiper) return;
            const mobileSlideCount = mobileEl.querySelectorAll('.swiper-slide').length;

            loadSwiper(() => {
                mobileSwiper = new Swiper('#services-mobile-slider', {
                    loop: mobileSlideCount >= 4,
                    centeredSlides: true,
                    slidesPerView: 1.15,
                    spaceBetween: 16,
                    speed: 400,
                    observer: true,
                    observeParents: true,
                    grabCursor: true,
                    pagination: {
                        el: '.services-mobile-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        400: {
                            slidesPerView: 1.18,
                            spaceBetween: 16,
                        },
                        520: {
                            slidesPerView: 1.35,
                            spaceBetween: 20,
                        },
                        640: {
                            slidesPerView: 1.5,
                            spaceBetween: 20,
                        }
                    }
                });
            });
        };

        // Initialize based on screen size when section approaches viewport
        const startServices = () => {
            if (window.innerWidth >= 768) {
                initDesktopSwiper();
            } else {
                initMobileSwiper();
            }
        };

        const servicesSection = document.getElementById('services');
        if (servicesSection && 'IntersectionObserver' in window) {
            const svcObserver = new IntersectionObserver((entries, obs) => {
                if (entries[0].isIntersecting) {
                    startServices();
                    obs.disconnect();
                }
            }, { rootMargin: '300px 0px' });
            svcObserver.observe(servicesSection);
        } else {
            startServices();
        }

        // Handle resize events
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                if (window.innerWidth >= 768) {
                    initDesktopSwiper();
                    if (desktopSwiper) desktopSwiper.update();
                } else {
                    initMobileSwiper();
                    if (mobileSwiper) mobileSwiper.update();
                }
            }, 200);
        }, { passive: true });
    });
</script>