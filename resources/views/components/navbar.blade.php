@props(['theme' => 'transparent'])

<style>
    /* ─── Navbar scroll effect ──────── */
    #main-navbar { 
        transition: background 0.4s, box-shadow 0.4s, padding 0.4s; 
    }
    #main-navbar.scrolled { 
        background: rgba(46,30,16,0.97) !important; 
        box-shadow: 0 2px 32px rgba(0,0,0,0.35); 
        padding-top: 1.2rem; 
        padding-bottom: 1.2rem; 
    }

    /* Dropdown CSS for Desktop */
    .dropdown-container:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    .dropdown-container:hover .dropdown-arrow {
        transform: rotate(180deg);
    }
    .dropdown-menu {
        opacity: 0; 
        visibility: hidden;
        transform: translateY(-8px);
        transition: all 0.25s ease;
        position: absolute; 
        top: calc(100% + 24px); 
        left: -24px;
        background: #2e1e10; 
        border: 1px solid rgba(212,160,23,0.2);
        min-width: 200px; 
        z-index: 999; 
        padding: 0.5rem 0;
    }
    /* Invisible bridge to maintain hover state when moving mouse to the dropdown */
    .dropdown-menu::before {
        content: '';
        position: absolute;
        top: -30px;
        left: 0;
        right: 0;
        height: 30px;
        background: transparent;
    }
    .dropdown-menu a { 
        display: block; 
        padding: 0.6rem 1.25rem; 
        color: #e4d4be; 
        font-size: 0.85rem; 
        transition: all 0.2s; 
    }
    @media (hover: hover) {
        .dropdown-menu a:hover { 
            background: rgba(212,160,23,0.1); 
            color: #d4a017; 
            padding-left: 1.6rem; 
        }
    }
    /* ... keep the rest ... */
    .btn-cut-corner {
        clip-path: polygon(15px 0, 100% 0, 100% calc(100% - 15px), calc(100% - 15px) 100%, 0 100%, 0 15px);
    }
    
    .active-menu-item {
        background: rgba(212,160,23,0.1); 
        color: #d4a017 !important; 
        padding-left: 1.6rem !important;
    }
    
    /* Menghapus outline dan underline */
    #main-navbar a, #main-navbar button {
        text-decoration: none !important;
        outline: none !important;
    }
</style>

<nav id="main-navbar" class="fixed top-0 left-0 right-0 w-full z-50 px-6 py-7 transition-all duration-300 {{ $theme == 'dark' ? 'scrolled' : '' }}" data-theme="{{ $theme }}">
    <div class="max-w-[1600px] mx-auto flex items-center justify-between gap-4 sm:gap-8">
        
        <!-- Logo -->
        <a href="/" class="flex-shrink-0 flex items-center group">
            <img src="{{ asset('images/logo-tokabe.png') }}" 
                 alt="{{ \App\Helpers\SeoHelper::getImageAlt('logo', 'Logo Tokabe.id') }}" 
                 width="160" height="48" loading="lazy"
                 class="h-12 w-auto object-contain filter drop-shadow-md onError-fallback"
                 onerror="this.style.display='none'; document.getElementById('logo-text-fallback').style.display='block';">
            <span id="logo-text-fallback" class="hidden text-xl font-bold text-white tracking-tight drop-shadow-md">
                Tokabe<span class="text-[#D4A574]">.id</span>
            </span>
        </a>

        <!-- Desktop Navigation Menu -->
        <div class="hidden xl:flex items-center gap-8 ml-auto mr-8"> 
            <a href="{{ route('home') }}" class="text-[#f2ebe2] hover:text-[#D4A574] transition-colors text-sm font-medium tracking-wide drop-shadow-sm">{{ __('Home') }}</a>
            
            <!-- Layanan Dropdown -->
            <div class="relative dropdown-container">
                <button class="dropdown-btn inline-flex items-center text-[#f2ebe2] hover:text-[#D4A574] text-sm font-medium tracking-wide transition-colors drop-shadow-sm focus:outline-none gap-1 group h-8">
                    {{ __('Layanan') }}
                    <svg class="dropdown-arrow w-3.5 h-3.5 mt-0.5 transition-transform duration-300 transform group-hover:text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="dropdown-menu">
                    @php
                        // Ambil data service dinamis tanpa filter
                        $layananServices = \App\Models\Service::all();
                    @endphp
                    @foreach($layananServices as $s)
                        @php
                            $serviceTitle = is_array($s->judul) ? ($s->judul[app()->getLocale()] ?? $s->judul['id'] ?? collect($s->judul)->first() ?? '') : $s->judul;
                        @endphp
                        <a href="{{ route('services.show', $s->id) }}">{{ $serviceTitle }}</a>
                    @endforeach
                </div>
            </div>

            <!-- Periklanan Dropdown -->
            <div class="relative dropdown-container">
                <button class="dropdown-btn inline-flex items-center text-[#f2ebe2] hover:text-[#D4A574] text-sm font-medium tracking-wide transition-colors drop-shadow-sm focus:outline-none gap-1 group h-8">
                    {{ __('Periklanan') }}
                    <svg class="dropdown-arrow w-3.5 h-3.5 mt-0.5 transition-transform duration-300 transform group-hover:text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="dropdown-menu">
                    <a href="{{ route('periklanan.show', 1) }}">{{ __('DOOH – Digital Out-of-Home') }}</a>
                    <a href="{{ route('periklanan.show', 2) }}">{{ __('OOH – Out-of-Home') }}</a>
                </div>
            </div>

            <a href="{{ route('portofolio') }}" class="text-[#f2ebe2] hover:text-[#D4A574] transition-colors text-sm font-medium tracking-wide drop-shadow-sm">{{ __('Portofolio') }}</a>
            <a href="{{ route('legalitas') }}" class="text-[#f2ebe2] hover:text-[#D4A574] transition-colors text-sm font-medium tracking-wide drop-shadow-sm">{{ __('Legality') }}</a>
            
            <a href="{{ route('contact') }}" class="text-[#f2ebe2] hover:text-[#D4A574] transition-colors text-sm font-medium tracking-wide drop-shadow-sm">{{ __('Contact') }}</a>
        </div>

        <!-- Desktop Language & Career Menu -->
        <div class="hidden xl:flex items-center gap-6"> 
            
            <div class="relative dropdown-container">
                <button class="dropdown-btn inline-flex items-center text-[#f2ebe2] hover:text-[#D4A574] text-sm font-medium tracking-wide transition-colors drop-shadow-sm focus:outline-none gap-1 group h-8">
                    <i class="fas fa-globe text-[#D4A574] text-sm mr-1"></i>
                    {{ app()->getLocale() == 'en' ? 'EN' : 'ID' }}
                    <svg class="dropdown-arrow w-3.5 h-3.5 mt-0.5 transition-transform duration-300 transform group-hover:text-[#D4A574]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div class="dropdown-menu" style="left: auto; right: -24px; min-width: 140px;">
                    <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'active-menu-item' : '' }}">English</a>
                    <a href="{{ route('lang.switch', 'id') }}" class="{{ app()->getLocale() == 'id' ? 'active-menu-item' : '' }}">Indonesia</a>
                </div>
            </div>

            <a href="https://drive.google.com/file/d/1tjBPWl-gIRPUJhSGqP3-ZdFsq_hXCkOI/view?usp=sharing" target="_blank" rel="noopener noreferrer" id="btn-compro-navbar" data-gtm-event="download_company_profile" class="px-4 py-2 bg-white/10 hover:bg-[#D4A574]/20 text-[#F0C97A] hover:text-white border border-[#D4A574]/40 hover:border-[#F0C97A] text-xs font-semibold rounded-full shadow-sm transition-all duration-300 flex items-center gap-1.5 whitespace-nowrap">
                <i class="fa-solid fa-file-pdf"></i> {{ __('Company Profile') }}
            </a>

            <a href="https://loker.tokabe.id/" target="_blank" class="px-6 py-2.5 bg-gradient-to-r from-[#C8902A] via-[#F0C97A] to-[#C8902A] text-[#2C1A0E] text-sm font-bold tracking-wide btn-cut-corner shadow-[0_0_15px_rgba(212,165,105,0.6)] hover:shadow-[0_0_25px_rgba(240,201,122,0.8)] hover:from-[#F0C97A] hover:to-[#C8902A] transform hover:scale-105 transition-all duration-300 flex items-center gap-2">
                {{ strtoupper(__('Career')) }}
            </a>
        </div>

        <!-- Mobile Hamburger & Lang Switcher -->
        <div class="xl:hidden flex items-center gap-3.5">
            <div class="flex items-center text-[13px] font-semibold text-white bg-white/10 backdrop-blur-md py-1 px-3 rounded-full border border-white/10 shadow-sm">
                <a href="{{ route('lang.switch', 'en') }}" class="transition-colors {{ app()->getLocale() == 'en' ? 'text-[#D4A574] font-bold' : 'text-white/70 hover:text-[#D4A574]' }}">EN</a>
                <span class="mx-1.5 text-white/20">|</span>
                <a href="{{ route('lang.switch', 'id') }}" class="transition-colors {{ app()->getLocale() == 'id' ? 'text-[#D4A574] font-bold' : 'text-white/70 hover:text-[#D4A574]' }}">ID</a>
            </div>

            <button id="mobile-menu-button" type="button" aria-label="Buka menu navigasi" class="p-2 text-[#f2ebe2] hover:text-[#D4A574] transition-colors focus:outline-none" aria-expanded="false">
                <svg id="hamburger-icon" class="w-6 h-6 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg id="close-icon" class="w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

    </div>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-menu" class="xl:hidden max-h-0 opacity-0 overflow-hidden transition-all duration-500 ease-in-out">
        <div class="max-w-7xl mx-auto mt-4 pb-6 border-t border-[#D4A574]/20 pt-6 flex flex-col gap-4">
            <a href="{{ route('home') }}" class="text-[#f2ebe2] hover:text-[#D4A574] text-sm font-medium transition-colors">{{ __('Home') }}</a>
        
        <!-- Mobile Dropdown for Layanan -->
        <div class="flex flex-col">
            <button id="mobile-layanan-btn" class="flex justify-between items-center text-[#f2ebe2] hover:text-[#D4A574] text-sm font-medium transition-colors w-full text-left focus:outline-none">
                {{ __('Layanan') }}
                <svg id="mobile-layanan-arrow" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="mobile-layanan-menu" class="max-h-0 opacity-0 overflow-hidden transition-all duration-300 ease-in-out flex flex-col pl-4 gap-3 mt-0">
                @foreach($layananServices as $s)
                    @php
                        $serviceTitle = is_array($s->judul) ? ($s->judul[app()->getLocale()] ?? $s->judul['id'] ?? collect($s->judul)->first() ?? '') : $s->judul;
                    @endphp
                    <a href="{{ route('services.show', $s->id) }}" class="text-white/80 hover:text-white text-sm font-medium transition-colors mt-3">
                        {{ $serviceTitle }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Mobile Dropdown for Periklanan -->
        <div class="flex flex-col">
            <button id="mobile-periklanan-btn" class="flex justify-between items-center text-[#f2ebe2] hover:text-[#D4A574] text-sm font-medium transition-colors w-full text-left focus:outline-none">
                {{ __('Periklanan') }}
                <svg id="mobile-periklanan-arrow" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="mobile-periklanan-menu" class="max-h-0 opacity-0 overflow-hidden transition-all duration-300 ease-in-out flex flex-col pl-4 gap-3 mt-0">
                <a href="{{ route('periklanan.show', 1) }}" class="text-white/80 hover:text-white text-sm font-medium transition-colors mt-3">
                    {{ __('DOOH – Digital Out-of-Home') }}
                </a>
                <a href="{{ route('periklanan.show', 2) }}" class="text-white/80 hover:text-white text-sm font-medium transition-colors">
                    {{ __('OOH – Out-of-Home') }}
                </a>
            </div>
        </div>

            <a href="{{ route('portofolio') }}" class="text-[#f2ebe2] hover:text-[#D4A574] text-sm font-medium transition-colors">{{ __('Portofolio') }}</a>
            <a href="{{ route('legalitas') }}" class="text-[#f2ebe2] hover:text-[#D4A574] text-sm font-medium transition-colors">{{ __('Legality') }}</a>
            
            <a href="{{ route('contact') }}" class="text-[#f2ebe2] hover:text-[#D4A574] text-sm font-medium transition-colors">{{ __('Contact') }}</a>

            <a href="https://drive.google.com/file/d/1tjBPWl-gIRPUJhSGqP3-ZdFsq_hXCkOI/view?usp=sharing" target="_blank" rel="noopener noreferrer" id="btn-compro-navbar-mobile" data-gtm-event="download_company_profile" class="text-[#F0C97A] hover:text-white text-sm font-semibold flex items-center gap-2 py-1 transition-colors">
                <i class="fa-solid fa-file-pdf"></i> {{ __('Company Profile (PDF)') }}
            </a>

            <a href="https://loker.tokabe.id/" target="_blank" class="bg-gradient-to-r from-[#C8902A] via-[#F0C97A] to-[#C8902A] text-[#2C1A0E] text-sm font-bold btn-cut-corner shadow-[0_0_15px_rgba(212,165,105,0.6)] hover:shadow-[0_0_25px_rgba(240,201,122,0.8)] hover:from-[#F0C97A] hover:to-[#C8902A] transform hover:scale-105 transition-all duration-300 inline-block text-center mt-2 py-2.5">
                {{ strtoupper(__('Career')) }}
            </a>
        </div>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const navbar = document.getElementById('main-navbar');
        const mobileMenu = document.getElementById('mobile-menu');
        
        // Logika Navbar Scroll
        const handleScroll = function() {
            requestAnimationFrame(() => {
                const isDarkTheme = navbar.getAttribute('data-theme') === 'dark';
                const isMobileMenuOpen = !mobileMenu.classList.contains('max-h-0');
                
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                    navbar.style.background = '';
                } else {
                    if (isDarkTheme || isMobileMenuOpen) {
                        navbar.classList.add('scrolled');
                        navbar.style.background = '';
                    } else {
                        navbar.classList.remove('scrolled');
                        navbar.style.background = 'transparent';
                    }
                }
            });
        };

        window.addEventListener('scroll', handleScroll);
        // Panggil sekali saat dimuat untuk mengatur status awal
        handleScroll();

        const dropdownContainers = document.querySelectorAll('.dropdown-container');
        dropdownContainers.forEach(container => {
            const btn = container.querySelector('.dropdown-btn');
            const menu = container.querySelector('.dropdown-menu');
            const arrow = container.querySelector('.dropdown-arrow');

            if (btn) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    // Toggle logik sederhana jika diperlukan
                });
            }
        });

        // Logika Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-button');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', function() {
                const isExpanded = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
                mobileMenuBtn.setAttribute('aria-expanded', !isExpanded);
                const isDarkTheme = navbar.getAttribute('data-theme') === 'dark';
                
                if (isExpanded) {
                    // Close menu
                    mobileMenu.classList.remove('max-h-[600px]', 'opacity-100');
                    mobileMenu.classList.add('max-h-0', 'opacity-0');
                    
                    // Reset bg jika di atas scroll
                    if (window.scrollY <= 50 && !isDarkTheme) {
                        navbar.classList.remove('scrolled');
                        navbar.style.background = 'transparent';
                    }
                    
                    hamburgerIcon.classList.remove('hidden');
                    hamburgerIcon.classList.add('block');
                    closeIcon.classList.remove('block');
                    closeIcon.classList.add('hidden');
                } else {
                    // Open menu
                    mobileMenu.classList.remove('max-h-0', 'opacity-0');
                    mobileMenu.classList.add('max-h-[600px]', 'opacity-100');
                    
                    // Buat navbar jadi solid saat menu mobile terbuka
                    if (window.scrollY <= 50 && !isDarkTheme) {
                        navbar.classList.add('scrolled');
                        navbar.style.background = '';
                    }
                    
                    hamburgerIcon.classList.remove('hidden');
                    hamburgerIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                    closeIcon.classList.add('block');
                }
            });
        }



        // Logika Dropdown Mobile untuk Layanan
        const mobileLayananBtn = document.getElementById('mobile-layanan-btn');
        const mobileLayananMenu = document.getElementById('mobile-layanan-menu');
        const mobileLayananArrow = document.getElementById('mobile-layanan-arrow');

        if (mobileLayananBtn && mobileLayananMenu) {
            mobileLayananBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = mobileLayananMenu.classList.contains('opacity-100');
                if (isOpen) {
                    mobileLayananMenu.classList.remove('max-h-[300px]', 'opacity-100');
                    mobileLayananMenu.classList.add('max-h-0', 'opacity-0');
                    if(mobileLayananArrow) mobileLayananArrow.classList.remove('rotate-180');
                } else {
                    mobileLayananMenu.classList.remove('max-h-0', 'opacity-0');
                    mobileLayananMenu.classList.add('max-h-[300px]', 'opacity-100');
                    if(mobileLayananArrow) mobileLayananArrow.classList.add('rotate-180');
                }
            });
        }

        // Logika Dropdown Mobile untuk Periklanan
        const mobilePeriklananBtn = document.getElementById('mobile-periklanan-btn');
        const mobilePeriklananMenu = document.getElementById('mobile-periklanan-menu');
        const mobilePeriklananArrow = document.getElementById('mobile-periklanan-arrow');

        if (mobilePeriklananBtn && mobilePeriklananMenu) {
            mobilePeriklananBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = mobilePeriklananMenu.classList.contains('opacity-100');
                if (isOpen) {
                    mobilePeriklananMenu.classList.remove('max-h-[300px]', 'opacity-100');
                    mobilePeriklananMenu.classList.add('max-h-0', 'opacity-0');
                    if(mobilePeriklananArrow) mobilePeriklananArrow.classList.remove('rotate-180');
                } else {
                    mobilePeriklananMenu.classList.remove('max-h-0', 'opacity-0');
                    mobilePeriklananMenu.classList.add('max-h-[300px]', 'opacity-100');
                    if(mobilePeriklananArrow) mobilePeriklananArrow.classList.add('rotate-180');
                }
            });
        }
    });
</script>