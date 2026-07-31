<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Tokabe.id - Portofolio & Project Showcase') }}</title>
    <meta name="description" content="{{ __('Lihat karya dan proyek terbaik dari Tokabe.id: Pemasangan Videotron, Billboard OOH, dan Event Organizer di Sumatera.') }}">
    <meta name="keywords" content="Portofolio Tokabe, Proyek videotron, Event organizer Medan, Iklan billboard Sumatera">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <meta property="og:title" content="{{ __('Tokabe.id - Portofolio & Project Showcase') }}">
    <meta property="og:description" content="{{ __('Lihat karya dan proyek terbaik dari Tokabe.id: Pemasangan Videotron, Billboard OOH, dan Event Organizer di Sumatera.') }}">
    <meta property="og:image" content="{{ asset('images/LogoTKB.jpg') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#2C1A0E] antialiased text-gray-900 font-sans">
    <x-navbar />
    <main>
        <!-- Header Hero Section -->
        <div class="bg-gradient-to-br from-[#1A0F07] via-[#2C1A0E] to-[#5C3317] pt-40 pb-24 text-center relative overflow-hidden">
            <!-- Decorative subtle glowing blur circles -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-white opacity-5 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-[#D4A574] opacity-10 blur-3xl"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white uppercase tracking-tight mb-4 drop-shadow-md">
                    {!! nl2br(__('Our Recent Portofolio')) !!}
                </h1>
                <p class="text-base sm:text-lg lg:text-xl text-[#F5EFE7] max-w-3xl mx-auto font-light leading-relaxed drop-shadow-sm">
                    {{ __('Showcasing Videotron Advertising Installations and Experiential Brand Activation Across Sumatra') }}
                </p>
            </div>
        </div>

        <div class="py-12 sm:py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ activeCategory: 'all', open: false }">
                
                <!-- Filter UI -->
                <div class="relative mb-10" data-aos="fade-up" data-aos-delay="100">
                    
                    <!-- Desktop Filter (Only on Extra Large Screens) -->
                    <div class="hidden xl:flex flex-wrap items-center justify-center gap-4">
                        <button 
                            @click="activeCategory = 'all'" 
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
                                @click="activeCategory = {{ $cat->id }}" 
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
                        <div class="absolute top-0 left-0 h-12 flex items-center z-40 transition-all duration-300 pl-2 w-[calc(100%-56px)]" :class="open ? 'opacity-0 pointer-events-none' : 'opacity-100'">
                            <!-- Mobile Text -->
                            <span class="md:hidden text-[#F5EFE7] font-semibold text-sm">Semua</span>
                            
                            <!-- Tablet/Laptop Scrollable Buttons -->
                            <div class="hidden md:flex overflow-x-auto [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none] w-full gap-3 pr-4 items-center">
                                <button 
                                    @click="activeCategory = 'all'" 
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
                                        @click="activeCategory = {{ $cat->id }}" 
                                        :class="activeCategory == {{ $cat->id }} 
                                            ? 'bg-[#D4A574] text-[#1A0F07] shadow-[0_0_15px_rgba(212,165,116,0.3)] font-bold' 
                                            : 'bg-[#5C3317]/30 border border-[#8B5E3C]/30 text-[#F5EFE7] hover:bg-[#5C3317]/60 hover:text-white hover:border-[#D4A574]/50 backdrop-blur-sm font-medium'" 
                                        class="flex-shrink-0 px-6 py-2.5 rounded-full text-sm hover:scale-105 transition-all">
                                        {{ $catTitle }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Morphing Container -->
                        <div 
                            class="absolute top-0 right-0 bg-[#2C1A0E]/85 border border-[#8B5E3C]/40 backdrop-blur-md shadow-2xl transition-all duration-300 overflow-hidden flex flex-col z-50"
                            style="transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);"
                            :class="open ? 'w-[calc(100vw-48px)] sm:w-[400px] h-[430px] rounded-3xl p-5' : 'w-12 h-12 rounded-3xl p-0 cursor-pointer hover:bg-[#5C3317]/70'"
                            @click="if(!open) open = true"
                            @click.away="open = false"
                        >
                            <!-- Icon when closed -->
                            <div 
                                class="absolute top-0 right-0 w-12 h-12 flex items-center justify-center transition-all duration-200"
                                :class="open ? 'opacity-0 scale-50 pointer-events-none' : 'opacity-100 scale-100'"
                            >
                                <i class="fas fa-filter text-[#D4A574] text-lg"></i>
                            </div>
                            
                            <!-- Content when open -->
                            <div 
                                class="flex flex-col w-full h-full"
                                x-show="open"
                                x-transition:enter="transition ease-out duration-300 delay-150"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-2"
                                x-cloak
                            >
                                <div class="flex justify-between items-center mb-5">
                                    <span class="text-[#D4A574] font-bold text-sm uppercase tracking-wider pl-1">Filter Portofolio</span>
                                    <button @click.stop="open = false" class="text-gray-400 hover:text-white transition-colors w-8 h-8 flex items-center justify-center rounded-full bg-white/5 hover:bg-white/10">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="flex flex-col gap-2.5 w-full overflow-y-auto pr-1">
                                    <button 
                                        @click="activeCategory = 'all'; open = false" 
                                        :class="activeCategory === 'all' ? 'bg-[#D4A574] text-[#1A0F07] font-bold shadow-md' : 'bg-[#5C3317]/30 border border-[#8B5E3C]/30 text-[#F5EFE7] hover:bg-[#5C3317]/60 hover:text-white'" 
                                        class="w-full text-left px-4 py-3 rounded-xl text-sm transition-all">
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
                                            @click="activeCategory = {{ $cat->id }}; open = false" 
                                            :class="activeCategory == {{ $cat->id }} ? 'bg-[#D4A574] text-[#1A0F07] font-bold shadow-md' : 'bg-[#5C3317]/30 border border-[#8B5E3C]/30 text-[#F5EFE7] hover:bg-[#5C3317]/60 hover:text-white'" 
                                            class="w-full text-left px-4 py-3 rounded-xl text-sm transition-all">
                                            {{ $catTitle }}
                                        </button>
                                    @endforeach
                                </div>
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
                <a x-show="activeCategory === 'all' || activeCategory == {{ $item->id }}" href="{{ route('portofolio.list', $item->id) }}" class="group block relative w-full aspect-[4/5] rounded-[1.5rem] overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500" data-aos="fade-up" data-aos-delay="{{ ($index % 5) * 100 }}">
                    
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
                            
                            <h3 class="text-2xl sm:text-3xl font-black text-white leading-tight mb-5 drop-shadow-lg line-clamp-2">
                                {{ __($namaKategori) }}
                            </h3>
                            
                            <!-- Overview -->
                            <div class="mb-4">
                                <h4 class="text-[10px] font-bold text-white uppercase tracking-widest mb-2 drop-shadow-md opacity-90">{{ __('Overview') }}</h4>
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
