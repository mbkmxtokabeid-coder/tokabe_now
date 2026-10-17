<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Tokabe.id - Portofolio & Project Showcase') }}</title>
    <meta name="description" content="{{ __('Lihat karya dan proyek terbaik dari Tokabe.id: Pemasangan Videotron, Billboard OOH, dan Event Organizer di Sumatera.') }}">
    <meta name="keywords" content="Portofolio Tokabe, Proyek videotron, Event organizer Medan, Iklan billboard Sumatera">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ \App\Helpers\SeoHelper::getCanonicalUrl() }}">
    
    <meta property="og:title" content="{{ __('Tokabe.id - Portofolio & Project Showcase') }}">
    <meta property="og:description" content="{{ __('Lihat karya dan proyek terbaik dari Tokabe.id: Pemasangan Videotron, Billboard OOH, dan Event Organizer di Sumatera.') }}">
    <meta property="og:image" content="{{ asset('images/LogoTKB.jpg') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ \App\Helpers\SeoHelper::getCanonicalUrl() }}">
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-T6SH8FXD');</script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('images/LogoTKB.png') }}?v=3">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/LogoTKB.png') }}?v=3">
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#2C1A0E] antialiased text-gray-900 font-sans">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T6SH8FXD"
        height="0" width="0" style="display:none;visibility:hidden">
    </iframe></noscript>
    <x-navbar />
    <main>
        <!-- Header Hero Section -->
        <div class="bg-gradient-to-br from-[#1A0F07] via-[#2C1A0E] to-[#5C3317] pt-28 sm:pt-36 md:pt-40 pb-12 sm:pb-16 md:pb-24 text-center relative overflow-hidden">
            <!-- Decorative subtle glowing blur circles -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-white opacity-5 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-[#D4A574] opacity-10 blur-3xl"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white uppercase tracking-tight mb-3 sm:mb-4 drop-shadow-md">
                    {!! nl2br(__('Explore Our Portfolio')) !!}
                </h1>
                <p class="text-sm sm:text-lg lg:text-xl text-[#F5EFE7] max-w-3xl mx-auto font-light leading-relaxed drop-shadow-sm">
                    {{ __('Showcasing Videotron Advertising Installations and Experiential Brand Activation Across Sumatra') }}
                </p>
            </div>
        </div>

        <div class="py-12 sm:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ activeCategory: 'all', activeCategoryName: '{{ __('Semua') }}', open: false }">
                
                <!-- Filter UI -->
                <div class="relative mb-10" data-aos="fade-up" data-aos-delay="100">
                    
                    <!-- Desktop Filter (Only on Extra Large Screens) -->
                    <div class="hidden xl:flex flex-wrap items-center justify-center gap-4">
                        <button 
                            @click="activeCategory = 'all'; activeCategoryName = '{{ __('Semua') }}'" 
                            :class="activeCategory === 'all' 
                                ? 'bg-[#D4A574] text-[#1A0F07] shadow-[0_0_15px_rgba(212,165,116,0.3)] font-bold' 
                                : 'bg-[#5C3317]/30 border border-[#8B5E3C]/30 text-[#F5EFE7] hover:bg-[#5C3317]/60 hover:text-white hover:border-[#D4A574]/50 backdrop-blur-sm font-medium'" 
                            class="px-6 py-2.5 rounded-full text-sm hover:scale-105 transition-all">
                            {{ __('Semua') }}
                        </button>
                        @foreach($categories as $cat)
                            @php
                                $catNameData = $cat->nama_kategori ?: ($cat->getRawOriginal ? $cat->getRawOriginal('nama_kategori') : '');
                                if (is_string($catNameData) && str_starts_with($catNameData, '{')) {
                                    $catNameArray = json_decode($catNameData, true);
                                } else {
                                    $catNameArray = $catNameData;
                                }
                                if (is_array($catNameArray)) {
                                    $catTitle = $catNameArray[app()->getLocale()] ?? $catNameArray['id'] ?? $catNameArray['en'] ?? collect($catNameArray)->first() ?? '';
                                } else {
                                    $catTitle = $catNameArray;
                                }
                            @endphp
                            <button 
                                @click="activeCategory = {{ $cat->id }}; activeCategoryName = '{{ addslashes($catTitle) }}'" 
                                :class="activeCategory == {{ $cat->id }} 
                                    ? 'bg-[#D4A574] text-[#1A0F07] shadow-[0_0_15px_rgba(212,165,116,0.3)] font-bold' 
                                    : 'bg-[#5C3317]/30 border border-[#8B5E3C]/30 text-[#F5EFE7] hover:bg-[#5C3317]/60 hover:text-white hover:border-[#D4A574]/50 backdrop-blur-sm font-medium'" 
                                class="px-6 py-2.5 rounded-full text-sm hover:scale-105 transition-all">
                                {{ $catTitle }}
                            </button>
                        @endforeach
                    </div>

                    <!-- Mobile & Tablet & Laptop Filter (Hidden on XL Desktop) -->
                    <div class="xl:hidden relative z-30 h-12 w-full px-2 mb-6">
                        <!-- Active Filter Text (Mobile) / Scrollable Menu (Tablet/Laptop) -->
                        <div class="absolute top-0 left-0 h-12 flex items-center z-40 transition-all duration-300 pl-2 w-[calc(100%-56px)]">
                            <!-- Mobile Active Category Display -->
                            <div class="md:hidden flex items-center gap-2 overflow-hidden pr-2">
                                <span class="text-xs text-white/50 uppercase tracking-wider font-medium flex-shrink-0">{{ __('Kategori') }}:</span>
                                <span class="text-[#D4A574] font-bold text-sm tracking-wide truncate" x-text="activeCategoryName"></span>
                            </div>
                            
                            <!-- Tablet/Laptop Scrollable Buttons -->
                            <div class="hidden md:flex overflow-x-auto [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none] w-full gap-3 pr-4 items-center">
                                <button 
                                    @click="activeCategory = 'all'; activeCategoryName = '{{ __('Semua') }}'" 
                                    :class="activeCategory === 'all' 
                                        ? 'bg-[#D4A574] text-[#1A0F07] shadow-[0_0_15px_rgba(212,165,116,0.3)] font-bold' 
                                        : 'bg-[#5C3317]/30 border border-[#8B5E3C]/30 text-[#F5EFE7] hover:bg-[#5C3317]/60 hover:text-white hover:border-[#D4A574]/50 backdrop-blur-sm font-medium'" 
                                    class="flex-shrink-0 px-6 py-2.5 rounded-full text-sm hover:scale-105 transition-all">
                                    {{ __('Semua') }}
                                </button>
                                @foreach($categories as $cat)
                                    @php
                                        $catNameData = $cat->nama_kategori ?: ($cat->getRawOriginal ? $cat->getRawOriginal('nama_kategori') : '');
                                        if (is_string($catNameData) && str_starts_with($catNameData, '{')) {
                                            $catNameArray = json_decode($catNameData, true);
                                        } else {
                                            $catNameArray = $catNameData;
                                        }
                                        if (is_array($catNameArray)) {
                                            $catTitle = $catNameArray[app()->getLocale()] ?? $catNameArray['id'] ?? $catNameArray['en'] ?? collect($catNameArray)->first() ?? '';
                                        } else {
                                            $catTitle = $catNameArray;
                                        }
                                    @endphp
                                    <button 
                                        @click="activeCategory = {{ $cat->id }}; activeCategoryName = '{{ addslashes($catTitle) }}'" 
                                        :class="activeCategory == {{ $cat->id }} 
                                            ? 'bg-[#D4A574] text-[#1A0F07] shadow-[0_0_15px_rgba(212,165,116,0.3)] font-bold' 
                                            : 'bg-[#5C3317]/30 border border-[#8B5E3C]/30 text-[#F5EFE7] hover:bg-[#5C3317]/60 hover:text-white hover:border-[#D4A574]/50 backdrop-blur-sm font-medium'" 
                                        class="flex-shrink-0 px-6 py-2.5 rounded-full text-sm hover:scale-105 transition-all">
                                        {{ $catTitle }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Filter Popover Container -->
                        <div class="absolute top-0 right-0 z-50" @click.away="open = false">
                            <!-- Filter Toggle Button (Clean & Stable 48px circle) -->
                            <button 
                                type="button"
                                @click="open = !open" 
                                aria-label="{{ __('Filter Kategori') }}"
                                class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 focus:outline-none shadow-lg border"
                                :class="open 
                                    ? 'bg-[#D4A574] text-[#1A0F07] border-[#D4A574] shadow-[0_0_20px_rgba(212,165,116,0.45)]' 
                                    : 'bg-[#2C1A0E]/90 text-[#D4A574] border-[#8B5E3C]/40 hover:bg-[#5C3317]/80 hover:border-[#D4A574]/60 hover:shadow-[0_0_15px_rgba(212,165,116,0.25)]'"
                            >
                                <!-- Filter Icon (when closed) -->
                                <svg x-show="!open" class="w-5 h-5 transition-transform duration-200" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3.75 4.5A.75.75 0 0 1 4.5 3.75h15a.75.75 0 0 1 .75.75v1.25a.75.75 0 0 1-.22.53L14 12.31V19a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-6.69L3.97 6.28A.75.75 0 0 1 3.75 5.75V4.5z" clip-rule="evenodd" />
                                </svg>
                                <!-- Close Icon (when open) -->
                                <svg x-show="open" x-cloak class="w-5 h-5 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <!-- Clean & Tidy Dropdown Menu -->
                            <div 
                                x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                x-cloak
                                class="absolute right-0 top-full mt-2 w-64 max-h-80 overflow-y-auto bg-[#24140A]/95 backdrop-blur-xl border border-[#8B5E3C]/40 rounded-2xl shadow-2xl p-2 z-50 flex flex-col gap-1 [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-thumb]:bg-[#D4A574]/30 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-transparent"
                            >
                                <div class="px-3 py-2 border-b border-[#8B5E3C]/20 mb-1 flex items-center justify-between">
                                    <span class="text-xs font-bold text-[#D4A574] uppercase tracking-wider">{{ __('Kategori Portofolio') }}</span>
                                    <span class="text-[10px] text-white/50 px-2 py-0.5 rounded-full bg-white/5 font-semibold">{{ count($categories) + 1 }}</span>
                                </div>

                                <!-- Option: Semua -->
                                <button 
                                    type="button"
                                    @click="activeCategory = 'all'; activeCategoryName = '{{ __('Semua') }}'; open = false" 
                                    :class="activeCategory === 'all' 
                                        ? 'bg-[#D4A574] text-[#1A0F07] font-bold shadow-md' 
                                        : 'text-[#F5EFE7] hover:bg-white/5 hover:text-[#D4A574] font-medium'" 
                                    class="w-full text-left px-3.5 py-2.5 rounded-xl text-sm transition-all flex items-center justify-between group"
                                >
                                    <span>{{ __('Semua') }}</span>
                                    <svg x-show="activeCategory === 'all'" class="w-4 h-4 text-[#1A0F07]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>

                                <!-- Category Options -->
                                @foreach($categories as $cat)
                                    @php
                                        $catNameData = $cat->nama_kategori ?: ($cat->getRawOriginal ? $cat->getRawOriginal('nama_kategori') : '');
                                        if (is_string($catNameData) && str_starts_with($catNameData, '{')) {
                                            $catNameArray = json_decode($catNameData, true);
                                        } else {
                                            $catNameArray = $catNameData;
                                        }
                                        if (is_array($catNameArray)) {
                                            $catTitle = $catNameArray[app()->getLocale()] ?? $catNameArray['id'] ?? $catNameArray['en'] ?? collect($catNameArray)->first() ?? '';
                                        } else {
                                            $catTitle = $catNameArray;
                                        }
                                    @endphp
                                    <button 
                                        type="button"
                                        @click="activeCategory = {{ $cat->id }}; activeCategoryName = '{{ addslashes($catTitle) }}'; open = false" 
                                        :class="activeCategory == {{ $cat->id }} 
                                            ? 'bg-[#D4A574] text-[#1A0F07] font-bold shadow-md' 
                                            : 'text-[#F5EFE7] hover:bg-white/5 hover:text-[#D4A574] font-medium'" 
                                        class="w-full text-left px-3.5 py-2.5 rounded-xl text-sm transition-all flex items-center justify-between group"
                                    >
                                        <span class="truncate pr-2">{{ $catTitle }}</span>
                                        <svg x-show="activeCategory == {{ $cat->id }}" class="w-4 h-4 text-[#1A0F07] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 px-4 sm:px-0">
            @forelse($categories as $index => $item)
                @php
                    $namaKatData = $item->nama_kategori ?: ($item->getRawOriginal ? $item->getRawOriginal('nama_kategori') : '');
                    if (is_string($namaKatData) && str_starts_with($namaKatData, '{')) {
                        $namaKatArray = json_decode($namaKatData, true);
                    } else {
                        $namaKatArray = $namaKatData;
                    }
                    if (is_array($namaKatArray)) {
                        $namaKategori = $namaKatArray[app()->getLocale()] ?? $namaKatArray['id'] ?? $namaKatArray['en'] ?? collect($namaKatArray)->first() ?? '';
                    } else {
                        $namaKategori = $namaKatArray;
                    }
                @endphp
                <a x-show="activeCategory === 'all' || activeCategory == {{ $item->id }}" href="{{ route('portofolio.list', $item->endpoint) }}" class="group block relative w-full aspect-[4/5] rounded-[1.5rem] overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500" data-aos="fade-up" data-aos-delay="{{ ($index % 5) * 100 }}">
                    
                    <!-- Background Image -->
                    <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('images/default-category.jpg') }}" 
                         alt="{{ \App\Helpers\SeoHelper::getImageAlt('event', $namaKategori) }}" 
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                         loading="lazy">
                         
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-[#5C3317]/95 via-[#8B5E3C]/60 to-transparent transition-opacity duration-500"></div>
                    
                    <!-- Content Wrapper -->
                    <div class="absolute inset-0 flex flex-col justify-end p-6 z-10 text-left overflow-hidden">
                        <!-- Translate Container -->
                        <div class="transform translate-y-[56px] group-hover:translate-y-0 transition-transform duration-500 ease-out flex flex-col">
                            
                            <h2 class="text-2xl sm:text-3xl font-black text-white leading-tight mb-5 drop-shadow-lg line-clamp-2">
                                {{ __($namaKategori) }}
                            </h2>
                            
                            <!-- Overview -->
                            <div class="mb-4">
                                <p class="text-[10px] font-bold text-white uppercase tracking-widest mb-2 drop-shadow-md opacity-90">{{ __('Overview') }}</p>
                                <p class="text-xs sm:text-sm text-gray-300 line-clamp-3 leading-relaxed drop-shadow-md">
                                    {{ __('Jelajahi berbagai karya terbaik kami dalam kategori ini. Kami berkomitmen memberikan hasil yang luar biasa dan berdampak nyata untuk setiap klien.') }}
                                </p>
                            </div>
                            
                            <!-- Action / Price Row (Fades in) -->
                            <div class="flex items-center justify-between opacity-0 group-hover:opacity-100 transition-all duration-500 delay-75 mt-1 h-[48px]">
                                <div class="flex items-baseline gap-1.5">
                                    <span class="text-3xl sm:text-4xl font-black text-white">{{ $item->portofolios()->count() }}</span>
                                    <span class="text-xs sm:text-sm text-gray-300 font-medium">{{ __('Proyek') }}</span>
                                </div>
                                <div class="bg-white text-black text-sm font-bold px-5 py-2.5 rounded-xl shadow-lg flex items-center gap-2">
                                    {{ __('Lihat') }} <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-2 md:col-span-3 lg:col-span-4 xl:col-span-5 text-center py-16 bg-white rounded-xl border border-dashed border-gray-300 shadow-sm">
                    <i class="fas fa-folder-open text-4xl text-gray-300 mb-3"></i>
                    <p class="text-sm sm:text-base text-gray-500 font-medium">{{ __('Kategori portofolio belum tersedia.') }}</p>
                </div>
            @endforelse
        </div>

    </div>
</div>
    </main>
    <x-footer />
</body>
</html>
