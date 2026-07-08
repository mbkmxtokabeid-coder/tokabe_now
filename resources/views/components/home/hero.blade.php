@props(['heroes' => []])
<style>
    /* --- Sihir Animasi Masuk (Reveal) --- */
    
    /* Teks Masuk dari Kiri */
    @keyframes revealFromLeft {
        0% { opacity: 0; transform: translateX(-100px) skewX(-10deg); filter: blur(10px); }
        100% { opacity: 1; transform: translateX(0) skewX(0deg); filter: blur(0); }
    }

    /* Kotak Masuk dari Kanan */
    @keyframes revealFromRight {
        0% { opacity: 0; transform: translateX(100px); filter: blur(10px); }
        100% { opacity: 1; transform: translateX(0); filter: blur(0); }
    }

    .reveal-left-hidden { opacity: 0; }
    .reveal-right-hidden { opacity: 0; }

    /* Class Aktif pas di-scroll / load */
    .reveal-left-active {
        animation: revealFromLeft 1.5s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    .reveal-right-active {
        animation: revealFromRight 1.5s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    /* Delay biar munculnya berurutan estetik */
    .delay-text { animation-delay: 0.1s; }
    .delay-box-1 { animation-delay: 0.4s; }
    .delay-box-2 { animation-delay: 0.7s; }
    .delay-btn { animation-delay: 1.0s; }
</style>

<section class="relative w-full h-screen min-h-[600px] overflow-hidden bg-[#2C1A0E]">
    
    <!-- Background Slider -->
    <div id="hero-slider" class="absolute inset-0 flex w-full h-full transition-transform duration-700 ease-in-out">
        @if(count($heroes) > 0)
            @foreach($heroes as $index => $hero)
            @php
                $judul = is_array($hero->judul) ? ($hero->judul[app()->getLocale()] ?? $hero->judul['id'] ?? $hero->judul['en'] ?? '') : $hero->judul;
            @endphp
            <div class="hero-slide w-full h-full flex-shrink-0 relative">
                <div class="absolute inset-0 bg-gradient-to-br from-[#2C1A0E]/85 via-[#1A0F07]/60 to-[#2C1A0E]/80 z-10"></div>
                @if($hero->gambar)
                    <img src="{{ asset('storage/image_hero/' . $hero->gambar) }}" class="w-full h-full object-cover z-0" alt="{{ \App\Helpers\SeoHelper::getImageAlt('hero', $judul) }}" 
                    @if($index === 0) fetchpriority="high" @else loading="lazy" @endif>
                @else
                    <div class="w-full h-full bg-gray-800 z-0"></div>
                @endif
                
                <!-- Content Depan untuk Slide Ini -->
                <div class="absolute inset-0 z-20 flex flex-col items-center justify-center px-4 pt-16">
                    <div class="max-w-[1600px] w-full mx-auto px-6 sm:px-8 lg:px-12 mb-12">
                        @php
                            $hasCounts = $hero->dooh_count > 0 || $hero->ooh_count > 0;
                        @endphp
                        
                        <div class="flex {{ $hasCounts ? 'flex-col lg:flex-row items-center justify-center gap-8 lg:gap-12 max-w-5xl' : 'flex-col items-center justify-center max-w-5xl' }} w-full mx-auto">
                            
                             <!-- Teks -->
                            <div class="reveal-target-left {{ $index === 0 ? 'reveal-left-active' : 'reveal-left-hidden' }} delay-text {{ $hasCounts ? 'text-center lg:text-left flex-1' : 'text-center w-full mb-12' }}">
                                @php
                                    $deskripsi = is_array($hero->deskripsi) ? ($hero->deskripsi[app()->getLocale()] ?? $hero->deskripsi['id'] ?? $hero->deskripsi['en'] ?? collect($hero->deskripsi)->first() ?? '') : $hero->deskripsi;
                                @endphp
                                <h2 class="text-4xl md:text-5xl lg:text-6xl font-semibold text-white leading-snug uppercase tracking-tight drop-shadow-2xl">
                                    {!! $judul !!}
                                </h2>
                                @if($deskripsi)
                                <p class="mt-6 text-base md:text-lg lg:text-xl text-gray-200 font-light drop-shadow-md leading-relaxed {{ !$hasCounts ? 'mx-auto max-w-3xl' : '' }}">
                                    {!! $deskripsi !!}
                                </p>
                                @endif
                            </div>

                            @if($hasCounts)
                            <!-- Kotak Statistik Sebelah Kanan -->
                            <div class="flex-shrink-0 flex flex-wrap justify-center gap-5">
                                @if($hero->dooh_count > 0)
                                <div class="reveal-target-right {{ $index === 0 ? 'reveal-right-active' : 'reveal-right-hidden' }} delay-box-1 bg-white/10 backdrop-blur-md rounded-xl w-44 lg:w-52 aspect-square p-5 border border-white/20 shadow-xl text-center flex flex-col justify-center items-center group hover:-translate-y-2 hover:bg-white/20 hover:border-[#D4A574]/50 transition-all duration-500">
                                    <div class="w-12 h-12 bg-gradient-to-r from-[#8B5E3C] to-[#A0522D] text-white rounded-xl flex items-center justify-center text-xl mb-3 shadow-lg group-hover:scale-110 transition-transform">
                                        <i class="fas fa-tv"></i>
                                    </div>
                                    <div class="flex items-baseline justify-center text-white mb-2">
                                        <span class="rolling-counter text-4xl lg:text-5xl font-black tracking-tight drop-shadow-md" data-target="{{ $hero->dooh_count }}">0</span>
                                        <span class="text-xl font-black text-[#D4A574] ml-1">+</span>
                                    </div>
                                    <h2 class="text-xs font-bold text-gray-200 uppercase tracking-widest group-hover:text-white mt-auto">DOOH / VIDEOTRON</h2>
                                </div>
                                @endif

                                @if($hero->ooh_count > 0)
                                <div class="reveal-target-right {{ $index === 0 ? 'reveal-right-active' : 'reveal-right-hidden' }} delay-box-2 bg-white/10 backdrop-blur-md rounded-xl w-44 lg:w-52 aspect-square p-5 border border-white/20 shadow-xl text-center flex flex-col justify-center items-center group hover:-translate-y-2 hover:bg-white/20 hover:border-[#D4A574]/50 transition-all duration-500">
                                    <div class="w-12 h-12 bg-gradient-to-r from-[#8B5E3C] to-[#A0522D] text-white rounded-xl flex items-center justify-center text-xl mb-3 shadow-lg group-hover:scale-110 transition-transform">
                                        <i class="fas fa-layer-group"></i>
                                    </div>
                                    <div class="flex items-baseline justify-center text-white mb-2">
                                        <span class="rolling-counter text-4xl lg:text-5xl font-black tracking-tight drop-shadow-md" data-target="{{ $hero->ooh_count }}">0</span>
                                        <span class="text-xl font-black text-[#D4A574] ml-1">+</span>
                                    </div>
                                    <h2 class="text-xs font-bold text-gray-200 uppercase tracking-widest group-hover:text-white mt-auto">OOH / BILLBOARD</h2>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <!-- Fallback if no heroes found -->
            <div class="w-full h-full flex-shrink-0 relative">
                <div class="absolute inset-0 bg-gradient-to-br from-[#2C1A0E]/85 via-[#1A0F07]/60 to-[#2C1A0E]/80 z-10"></div>
                <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover z-0" alt="{{ \App\Helpers\SeoHelper::getImageAlt('hero', 'Jasa Iklan Billboard dan Videotron Tokabe') }}">
            </div>
        @endif
    </div>

    <!-- Tombol Contact Us Tetap di Tengah Bawah -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-30">
        @php
            $heroPhone = isset($globalContact) && $globalContact->phone ? $globalContact->phone : '628115239999';
            $heroMessage = isset($globalContact) && $globalContact->message ? urlencode($globalContact->message) : 'Halo%20Admin';
            $heroUrl = "https://api.whatsapp.com/send/?phone={$heroPhone}&text={$heroMessage}";
        @endphp
        <a href="{{ $heroUrl }}" target="_blank" class="px-5 py-2.5 sm:px-8 sm:py-3.5 bg-gradient-to-r from-[#C8902A] via-[#F0C97A] to-[#C8902A] text-[#1F1611] font-bold text-sm sm:text-base rounded-full hover:from-[#F0C97A] hover:to-[#C8902A] shadow-[0_0_25px_rgba(212,165,105,0.6)] hover:shadow-[0_0_40px_rgba(240,201,122,0.8)] flex items-center justify-center gap-2 sm:gap-3 transition-all duration-300 hover:scale-105 hover:-translate-y-1 whitespace-nowrap w-max mx-auto">
            <i class="fa-brands fa-whatsapp text-lg sm:text-xl"></i> {{ strip_tags(__('Contact Us')) }}
        </a>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const slidesContainer = document.getElementById('hero-slider');
            const slides = document.querySelectorAll('.hero-slide');
            const totalSlides = slides.length;
            
            if (totalSlides === 0) return;

            let currentSlide = 0;

            const startCounting = (slide) => {
                const counters = slide.querySelectorAll('.rolling-counter');
                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-target');
                    const duration = 2500; 
                    const countPerFrame = target / (duration / 16); 
                    let current = 0;
                    counter.innerText = '0'; // reset
                    const updateCounter = () => {
                        current += countPerFrame;
                        if (current >= target) { 
                            counter.innerText = target; 
                        } else { 
                            counter.innerText = Math.floor(current); 
                            requestAnimationFrame(updateCounter); 
                        }
                    };
                    requestAnimationFrame(updateCounter);
                });
            };

            const triggerAnimations = (slideIndex) => {
                // Reset all animations
                slides.forEach(slide => {
                    slide.querySelectorAll('.reveal-target-left').forEach(el => el.classList.remove('reveal-left-active'));
                    slide.querySelectorAll('.reveal-target-right').forEach(el => el.classList.remove('reveal-right-active'));
                });

                // Trigger active slide animations
                const activeSlide = slides[slideIndex];
                setTimeout(() => {
                    activeSlide.querySelectorAll('.reveal-target-left').forEach(el => el.classList.add('reveal-left-active'));
                    activeSlide.querySelectorAll('.reveal-target-right').forEach(el => el.classList.add('reveal-right-active'));
                    
                    setTimeout(() => startCounting(activeSlide), 500); 
                }, 100);
            };

            // Initialize first slide
            triggerAnimations(currentSlide);

            if (totalSlides > 1) {
                setInterval(() => {
                    currentSlide = (currentSlide + 1) % totalSlides;
                    slidesContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
                    triggerAnimations(currentSlide);
                }, 8000); // Diperlambat jadi 8 detik
            }
        });
    </script>
</section>