<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $namaLokasi = is_string($lokasiooh->nama) && str_starts_with($lokasiooh->nama, '{') ? json_decode($lokasiooh->nama, true) : $lokasiooh->nama;
        $namaLokasi = is_array($namaLokasi) ? (($namaLokasi[app()->getLocale()] ?? '') ?: ($namaLokasi['id'] ?? '') ?: ($namaLokasi['en'] ?? '') ?: (collect($namaLokasi)->first() ?? '')) : $namaLokasi;
        $descLokasi = is_string($lokasiooh->deskripsi_lokasi) && str_starts_with($lokasiooh->deskripsi_lokasi, '{') ? json_decode($lokasiooh->deskripsi_lokasi, true) : $lokasiooh->deskripsi_lokasi;
        $descLokasi = is_array($descLokasi) ? (($descLokasi[app()->getLocale()] ?? '') ?: ($descLokasi['id'] ?? '') ?: ($descLokasi['en'] ?? '') ?: (collect($descLokasi)->first() ?? '')) : $descLokasi;
    @endphp
    <title>{{ $namaLokasi }} - Tokabe.id</title>
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($descLokasi ?? ''), 150) }}">
    <meta name="keywords" content="OOH {{ $lokasiooh->kota ?? 'Medan' }}, Sewa Billboard {{ $lokasiooh->kota ?? 'Medan' }}, Iklan OOH {{ $namaLokasi }}">
    <meta property="og:title" content="{{ $namaLokasi }} - Tokabe.id">
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($descLokasi ?? ''), 150) }}">
    <meta property="og:image" content="{{ $lokasiooh->gambar ? asset('storage/image_lokasiooh/' . $lokasiooh->gambar) : asset('images/LogoTKB.jpg') }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#2C1A0E] antialiased text-[#F2EBE2] font-sans">
    <x-navbar theme="dark" />
    <main>
        <!-- Hero Section -->
        <div class="relative w-full min-h-[50vh] md:min-h-[60vh] bg-[#2C1A0E] overflow-hidden flex flex-col justify-center">
            @php
                $namaLokasi = is_string($lokasiooh->nama) && str_starts_with($lokasiooh->nama, '{') ? json_decode($lokasiooh->nama, true) : $lokasiooh->nama;
                $namaLokasi = is_array($namaLokasi) ? ($namaLokasi[app()->getLocale()] ?? $namaLokasi['id'] ?? $namaLokasi['en'] ?? collect($namaLokasi)->first() ?? '') : $namaLokasi;
                $isAvailable = ($lokasiooh->availability ?? 'Available') !== 'Not Available';
            @endphp
            <div class="absolute inset-0 bg-[#2C1A0E]">
                <!-- Premium Skeleton Loader -->
                <div class="absolute inset-0 bg-gradient-to-br from-[#3E2718] to-[#2C1A0E] flex items-center justify-center skeleton-loader" style="z-index: 1;">
                    <div class="absolute inset-0 bg-black/20 animate-pulse"></div>
                    <div class="relative flex flex-col items-center gap-3 animate-pulse">
                        <i class="fas fa-image text-[#D4A574]/30 text-5xl"></i>
                        <div class="h-2 w-24 bg-[#D4A574]/20 rounded-full"></div>
                    </div>
                </div>
                <img src="{{ $lokasiooh->gambar ? asset('storage/image_lokasiooh/' . $lokasiooh->gambar) : 'https://images.unsplash.com/photo-1556761175-b413da4baf72?q=80&w=1200&auto=format&fit=crop' }}" alt="{{ \App\Helpers\SeoHelper::getImageAlt('ooh', $namaLokasi, $lokasiooh->kota ?? 'Medan') }}" class="w-full h-full object-cover relative" style="z-index: 2; {{ !$isAvailable ? 'filter: grayscale(100%);' : '' }}" onload="this.previousElementSibling.style.display='none'" fetchpriority="high">
                <div class="absolute inset-0 bg-gradient-to-br from-[#2C1A0E]/85 via-[#1A0F07]/60 to-[#2C1A0E]/80 z-10"></div>
                @if(!$isAvailable)
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none overflow-hidden" style="z-index: 15;">
                    <div class="transform -rotate-12 border-4 md:border-8 border-red-600 rounded-xl px-4 py-2 md:px-8 md:py-4 bg-black/50 backdrop-blur-md text-center opacity-70 whitespace-nowrap">
                        <span class="text-red-500 font-black text-2xl sm:text-3xl md:text-4xl lg:text-5xl tracking-widest uppercase" style="text-shadow: 2px 2px 0 #000, -2px -2px 0 #000, 2px -2px 0 #000, -2px 2px 0 #000, 2px 2px 0 #000;">
                            NOT AVAILABLE
                        </span>
                    </div>
                </div>
                @endif
            </div>
            <div class="relative z-20 h-full flex flex-col items-center justify-center text-center px-4 max-w-5xl mx-auto pt-28 pb-16">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 sm:mb-6 uppercase tracking-tight shadow-sm leading-tight">{{ $namaLokasi }}</h1>
                <p class="text-base sm:text-lg md:text-xl text-gray-200 font-medium tracking-wide">{{ __('SUPER LOCATION and EYE-CATCHING OOH Billboard in Sumatera') }}</p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 mt-4 sm:mt-8 relative z-10">
            <div class="bg-[#1F120A] rounded-2xl sm:rounded-3xl shadow-2xl p-5 sm:p-8 lg:p-10 border border-[#D4A569]/20">
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 lg:gap-12 xl:gap-16">
                    
                    <!-- Left Column: Description & Map -->
                    <div class="xl:col-span-2 space-y-8 sm:space-y-10">
                        <div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-[#F2EBE2] mb-4 sm:mb-6">{{ __('Point of Interest') }}</h2>
                            <div class="prose prose-base sm:prose-lg text-gray-300 max-w-none prose-headings:text-[#F2EBE2] prose-strong:text-[#D4A569]">
                                @php
                                    $descLokasi = is_string($lokasiooh->deskripsi_lokasi) && str_starts_with($lokasiooh->deskripsi_lokasi, '{') ? json_decode($lokasiooh->deskripsi_lokasi, true) : $lokasiooh->deskripsi_lokasi;
                                    $descLokasi = is_array($descLokasi) ? (($descLokasi[app()->getLocale()] ?? '') ?: ($descLokasi['id'] ?? '') ?: ($descLokasi['en'] ?? '') ?: (collect($descLokasi)->first() ?? '')) : $descLokasi;
                                @endphp
                                {!! $descLokasi !!}
                            </div>
                        </div>

                        <!-- Map -->
                        @if($lokasiooh->koordinat)
                        <div class="rounded-2xl overflow-hidden shadow-md border border-[#D4A569]/30 w-full aspect-square sm:aspect-video">
                            <iframe
                                title="Lokasi Google Maps"
                                src="https://www.google.com/maps?q={{ $lokasiooh->koordinat }}&hl=es;z=14&output=embed"
                                class="w-full h-full" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                        @endif
                    </div>

                    <!-- Right Column: Specs & Traffic -->
                    <div class="space-y-6 sm:space-y-8">
                        <!-- Traffic Stats -->
                        <div class="bg-[#2C1A0E] rounded-2xl p-4 sm:p-6 lg:p-8 border border-[#D4A569]/30 shadow-lg">
                            <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-[#F2EBE2] mb-4">{{ __('Vehicle / Day') }}</h3>
                            <div class="space-y-3 sm:space-y-4">
                                <div class="flex items-center gap-3 sm:gap-4 bg-[#3B2516] p-3 sm:p-4 rounded-xl shadow-sm border border-[#D4A569]/10 hover:border-[#D4A569]/30 transition-colors">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-[#D4A569]/10 text-[#D4A569] rounded-full flex items-center justify-center text-lg sm:text-xl shrink-0 shadow-[0_0_10px_rgba(212,165,105,0.2)]">
                                        <i class="fa-solid fa-car"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs sm:text-sm text-gray-400 font-medium">{{ __('Car') }}</div>
                                        <div class="text-base sm:text-lg lg:text-xl font-bold text-[#F2EBE2] truncate">{{ $lokasiooh->mobil ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 sm:gap-4 bg-[#3B2516] p-3 sm:p-4 rounded-xl shadow-sm border border-[#D4A569]/10 hover:border-[#D4A569]/30 transition-colors">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-[#D4A569]/10 text-[#D4A569] rounded-full flex items-center justify-center text-lg sm:text-xl shrink-0 shadow-[0_0_10px_rgba(212,165,105,0.2)]">
                                        <i class="fa-solid fa-motorcycle"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs sm:text-sm text-gray-400 font-medium">{{ __('Motorcycle') }}</div>
                                        <div class="text-base sm:text-lg lg:text-xl font-bold text-[#F2EBE2] truncate">{{ $lokasiooh->motor ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Specifications Grid -->
                        <div class="grid grid-cols-2 gap-3 sm:gap-4">
                            <!-- Media -->
                            <div class="bg-[#2C1A0E] p-3 xl:p-6 rounded-2xl shadow-lg border border-[#D4A569]/20 text-center hover:shadow-[0_0_15px_rgba(212,165,105,0.15)] transition-all group hover:-translate-y-1 flex flex-col justify-center items-center">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 mx-auto bg-[#D4A569]/10 text-[#D4A569] rounded-full flex items-center justify-center mb-2 sm:mb-3 group-hover:scale-110 transition-transform shrink-0 shadow-[0_0_10px_rgba(212,165,105,0.2)]">
                                    <i class="fa-solid fa-photo-film text-sm sm:text-base"></i>
                                </div>
                                <div class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase mb-1">{{ __('Media') }}</div>
                                <div class="text-xs sm:text-sm font-semibold text-[#F2EBE2] break-words line-clamp-2 w-full">{{ $lokasiooh->media ?? '-' }}</div>
                            </div>
                            <!-- Type -->
                            <div class="bg-[#2C1A0E] p-3 xl:p-6 rounded-2xl shadow-lg border border-[#D4A569]/20 text-center hover:shadow-[0_0_15px_rgba(212,165,105,0.15)] transition-all group hover:-translate-y-1 flex flex-col justify-center items-center">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 mx-auto bg-[#D4A569]/10 text-[#D4A569] rounded-full flex items-center justify-center mb-2 sm:mb-3 group-hover:scale-110 transition-transform shrink-0 shadow-[0_0_10px_rgba(212,165,105,0.2)]">
                                    <i class="fa-solid fa-expand text-sm sm:text-base"></i>
                                </div>
                                <div class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase mb-1">{{ __('Type') }}</div>
                                <div class="text-xs sm:text-sm font-semibold text-[#F2EBE2] break-words line-clamp-2 w-full">{{ $lokasiooh->type ?? '-' }}</div>
                            </div>
                            <!-- Size -->
                            <div class="bg-[#2C1A0E] p-3 xl:p-6 rounded-2xl shadow-lg border border-[#D4A569]/20 text-center hover:shadow-[0_0_15px_rgba(212,165,105,0.15)] transition-all group hover:-translate-y-1 flex flex-col justify-center items-center">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 mx-auto bg-[#D4A569]/10 text-[#D4A569] rounded-full flex items-center justify-center mb-2 sm:mb-3 group-hover:scale-110 transition-transform shrink-0 shadow-[0_0_10px_rgba(212,165,105,0.2)]">
                                    <i class="fa-solid fa-up-right-and-down-left-from-center text-sm sm:text-base"></i>
                                </div>
                                <div class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase mb-1">{{ __('Size') }}</div>
                                <div class="text-xs sm:text-sm font-semibold text-[#F2EBE2] break-words line-clamp-2 w-full">{{ $lokasiooh->size ?? '-' }}</div>
                            </div>
                            <!-- Lighting -->
                            <div class="bg-[#2C1A0E] p-3 xl:p-6 rounded-2xl shadow-lg border border-[#D4A569]/20 text-center hover:shadow-[0_0_15px_rgba(212,165,105,0.15)] transition-all group hover:-translate-y-1 flex flex-col justify-center items-center">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 mx-auto bg-[#D4A569]/10 text-[#D4A569] rounded-full flex items-center justify-center mb-2 sm:mb-3 group-hover:scale-110 transition-transform shrink-0 shadow-[0_0_10px_rgba(212,165,105,0.2)]">
                                    <i class="fa-solid fa-lightbulb text-sm sm:text-base"></i>
                                </div>
                                <div class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase mb-1">{{ __('Lighting') }}</div>
                                <div class="text-xs sm:text-sm font-semibold text-[#F2EBE2] break-words line-clamp-2 w-full">{{ $lokasiooh->lighting ?? '-' }}</div>
                            </div>
                        </div>
                        
                        @php
                            $oohPhone = isset($globalContact) && $globalContact->phone ? $globalContact->phone : '628115239999';
                            $oohMessage = isset($globalContact) && $globalContact->message 
                                            ? urlencode($globalContact->message) . '%20' . urlencode($namaLokasi)
                                            : urlencode('Hello, I am interested in OOH Location: ') . urlencode($namaLokasi);
                            $oohUrl = "https://wa.me/{$oohPhone}?text={$oohMessage}";
                        @endphp
                        <a href="{{ $oohUrl }}" target="_blank" class="flex items-center justify-center w-full py-4 px-2 sm:px-6 bg-gradient-to-r from-[#C8902A] via-[#F0C97A] to-[#C8902A] hover:from-[#F0C97A] hover:to-[#C8902A] text-[#1F1611] font-bold text-center rounded-xl shadow-[0_0_20px_rgba(212,165,105,0.5)] hover:shadow-[0_0_35px_rgba(240,201,122,0.7)] transform hover:-translate-y-1 transition-all whitespace-nowrap text-sm sm:text-base">
                            <i class="fa-brands fa-whatsapp mr-2"></i> {{ __('Contact via WhatsApp') }}
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footer />
</body>
</html>
