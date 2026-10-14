<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ __('Tokabe.id adalah agensi periklanan terbaik di Medan, Sumatera. Kami menyediakan layanan sewa Videotron (DOOH), Billboard (OOH), Event Organizer, dan Brand Activation.') }}">
    <meta name="keywords" content="Sewa videotron Medan, Billboard Sumatera, Event organizer Medan, Advertising agency Sumatera, Jasa OOH Medan">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="{{ __('Tokabe.id - Services') }}">
    <meta property="og:description" content="{{ __('Tokabe.id adalah agensi periklanan terbaik di Medan, Sumatera. Kami menyediakan layanan sewa Videotron (DOOH), Billboard (OOH), Event Organizer, dan Brand Activation.') }}">
    <meta property="og:image" content="{{ asset('images/LogoTKB.jpg') }}">
    <meta property="og:url" content="{{ \App\Helpers\SeoHelper::getCanonicalUrl() }}">    
    <title>{{ is_array($service->judul) ? ($service->judul[app()->getLocale()] ?? $service->judul['id'] ?? $service->judul['en'] ?? '') : $service->judul }} - Tokabe.id</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    <link rel="preload" as="font" type="font/woff2" href="https://fonts.gstatic.com/s/poppins/v24/pxiEyp8kv8JHgFVrJJfecg.woff2" crossorigin>
    <link rel="preload" as="font" type="font/woff2" href="https://fonts.gstatic.com/s/poppins/v24/pxiByp8kv8JHgFVrLEj6Z1xlFQ.woff2" crossorigin>
    <link rel="canonical" href="{{ \App\Helpers\SeoHelper::getCanonicalUrl() }}">
    @if (! \Illuminate\Support\Facades\Vite::isRunningHot())
        <style id="app-css-inline">{!! \Illuminate\Support\Facades\Vite::content('resources/css/app.css') !!}</style>
        @vite('resources/js/app.js')
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <link rel="icon" type="image/png" href="{{ asset('images/LogoTKB.png') }}?v=3">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/LogoTKB.png') }}?v=3">
    <style>
        /* Inlined Poppins font-face to eliminate render-blocking external Google Fonts request */
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v24/pxiByp8kv8JHgFVrLDz8Z1xlFQ.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v24/pxiEyp8kv8JHgFVrJJfecg.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v24/pxiByp8kv8JHgFVrLGT9Z1xlFQ.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v24/pxiByp8kv8JHgFVrLEj6Z1xlFQ.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v24/pxiByp8kv8JHgFVrLCz7Z1xlFQ.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        
        /* Font Awesome font-display: swap override to prevent text blocking (LCP) */
        @font-face {
            font-family: 'Font Awesome 6 Free';
            font-style: normal;
            font-weight: 900;
            font-display: swap;
            src: url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2");
        }
        @font-face {
            font-family: 'Font Awesome 6 Brands';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-brands-400.woff2") format("woff2");
        }
    </style>
</head>
<body class="bg-[#2C1A0E] antialiased text-white font-sans">
    <x-navbar />
    <main>
        <div class="relative min-h-screen pt-32 pb-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @php
                    $waTitle = is_array($service->judul) ? ($service->judul[app()->getLocale()] ?? $service->judul['id'] ?? '') : $service->judul;
                    $imageUrl = (isset($service->gambar) && $service->gambar) ? asset('storage/image_service/' . $service->gambar) : 'https://images.unsplash.com/photo-1542204165-65bf26472b9b?q=80&w=1200&auto=format&fit=crop';
                    $svcPhone = isset($globalContact) && $globalContact->phone ? $globalContact->phone : '628115239999';
                    $svcMessage = isset($globalContact) && $globalContact->message 
                                    ? urlencode($globalContact->message) 
                                    : urlencode(__('Halo Admin Tokabe, saya mau menanyakan tentang ')) . urlencode($waTitle) . "%20%F0%9F%99%8F";
                    $waUrl = "https://api.whatsapp.com/send?phone={$svcPhone}&text={$svcMessage}";
                    
                    $isDooh = str_contains(strtolower($waTitle), 'dooh') || str_contains(strtolower($waTitle), 'videotron');
                    $isOoh = str_contains(strtolower($waTitle), 'ooh') || str_contains(strtolower($waTitle), 'baliho');
                    $lokasiLink = null;
                    $lokasiText = '';
                    if ($isDooh) {
                        $lokasiLink = route('periklanan.show', 'advertising-dooh');
                        $lokasiText = __('Lihat Lokasi DOOH');
                    } elseif ($isOoh) {
                        $lokasiLink = route('periklanan.show', 'advertising-ooh');
                        $lokasiText = __('Lihat Lokasi OOH');
                    }
                @endphp

                <!-- Desktop View (Large Image Card Overlay) -->
                <div class="hidden md:flex relative w-full rounded-3xl overflow-hidden shadow-2xl min-h-[600px] lg:min-h-[70vh] flex-col justify-end group bg-[#2C1A0E]">
                    <!-- Premium Skeleton Loader -->
                    <div class="absolute inset-0 bg-gradient-to-br from-[#3E2718] to-[#2C1A0E] flex items-center justify-center skeleton-loader" style="z-index: 1;">
                        <div class="absolute inset-0 bg-black/20 animate-pulse"></div>
                        <div class="relative flex flex-col items-center gap-3 animate-pulse">
                            <i class="fas fa-image text-[#D4A574]/30 text-5xl"></i>
                            <div class="h-2 w-24 bg-[#D4A574]/20 rounded-full"></div>
                        </div>
                    </div>
                    <!-- Background Image -->
                    <img src="{{ $imageUrl }}" alt="{{ $waTitle }}" class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700" style="z-index: 2;" onload="this.previousElementSibling.style.display='none'" fetchpriority="high">
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-[#1F1611] via-[#2C1A0E]/80 to-transparent" style="z-index: 3;"></div>
                    
                    <!-- Content Over Image -->
                    <div class="relative z-10 p-6 md:p-10 lg:p-12 w-full">
                        <div class="flex flex-col xl:flex-row items-start xl:items-end justify-between gap-6 lg:gap-8">
                            
                            <!-- Title & Description -->
                            <div class="flex-1 max-w-3xl">
                                <h1 class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-black text-white mb-3 md:mb-4 drop-shadow-lg leading-tight">
                                    {{ is_array($service->judul) ? ($service->judul[app()->getLocale()] ?? $service->judul['id'] ?? $service->judul['en'] ?? '') : $service->judul }}
                                </h1>
                                <div class="prose prose-base md:prose-lg prose-invert text-gray-200 drop-shadow-md leading-relaxed">
                                    {!! is_array($service->deskripsi) ? ($service->deskripsi[app()->getLocale()] ?? $service->deskripsi['id'] ?? $service->deskripsi['en'] ?? '') : $service->deskripsi !!}
                                </div>
                            </div>
                            
                            <!-- CTA Buttons -->
                            <div class="shrink-0 flex flex-col sm:flex-row xl:flex-col gap-3.5 sm:gap-4 w-full sm:w-auto xl:w-auto xl:min-w-[300px]">
                                <a href="{{ $waUrl }}" target="_blank" class="inline-flex items-center justify-center px-6 sm:px-8 py-3.5 sm:py-4 bg-gradient-to-r from-[#C8902A] via-[#F0C97A] to-[#C8902A] hover:from-[#F0C97A] hover:to-[#C8902A] text-[#1F1611] border-0 text-sm sm:text-base font-semibold rounded-full shadow-[0_0_20px_rgba(212,165,105,0.5)] hover:shadow-[0_0_35px_rgba(240,201,122,0.7)] hover:-translate-y-1 transform transition-all duration-300 w-full sm:w-auto xl:w-full whitespace-nowrap">
                                    <i class="fa-brands fa-whatsapp mr-2.5 sm:mr-3 text-lg sm:text-xl"></i>
                                    {{ __('Call Astronaut') }} : {{ $svcPhone }}
                                </a>
                                @if($lokasiLink)
                                <a href="{{ $lokasiLink }}" class="inline-flex items-center justify-center px-6 sm:px-8 py-3.5 sm:py-4 bg-[#1F1611]/80 backdrop-blur hover:bg-[#5C3317] text-[#F0C97A] border border-[#C8902A]/50 text-sm sm:text-base font-semibold rounded-full shadow-lg hover:shadow-[0_0_20px_rgba(212,165,105,0.4)] transform hover:-translate-y-1 transition-all duration-300 w-full sm:w-auto xl:w-full whitespace-nowrap">
                                    <i class="fa-solid fa-map-location-dot mr-2.5 sm:mr-3 text-lg sm:text-xl"></i>
                                    {{ $lokasiText }}
                                </a>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                </div>

                <!-- Mobile View (Stacked Layout) -->
                <div class="flex flex-col md:hidden gap-6">
                    <!-- Image Card (No Gradient) -->
                    <div class="w-full rounded-3xl overflow-hidden shadow-lg aspect-square sm:aspect-video relative bg-[#2C1A0E]">
                        <!-- Premium Skeleton Loader -->
                        <div class="absolute inset-0 bg-gradient-to-br from-[#3E2718] to-[#2C1A0E] flex items-center justify-center skeleton-loader" style="z-index: 1;">
                            <div class="absolute inset-0 bg-black/20 animate-pulse"></div>
                            <div class="relative flex flex-col items-center gap-3 animate-pulse">
                                <i class="fas fa-image text-[#D4A574]/30 text-5xl"></i>
                                <div class="h-2 w-24 bg-[#D4A574]/20 rounded-full"></div>
                            </div>
                        </div>
                        <img src="{{ $imageUrl }}" alt="{{ $waTitle }}" class="absolute inset-0 w-full h-full object-cover" style="z-index: 2;" onload="this.previousElementSibling.style.display='none'" fetchpriority="high">
                    </div>
                    
                    <!-- Content Below Image -->
                    <div class="flex flex-col px-2">
                        <!-- Title -->
                        <h1 class="text-3xl sm:text-4xl font-black text-white mb-4 leading-tight">
                            {{ is_array($service->judul) ? ($service->judul[app()->getLocale()] ?? $service->judul['id'] ?? $service->judul['en'] ?? '') : $service->judul }}
                        </h1>
                        
                        <!-- Description -->
                        <div class="prose prose-invert text-gray-300 leading-relaxed mb-8">
                            {!! is_array($service->deskripsi) ? ($service->deskripsi[app()->getLocale()] ?? $service->deskripsi['id'] ?? $service->deskripsi['en'] ?? '') : $service->deskripsi !!}
                        </div>
                        
                        <!-- CTA Buttons -->
                        <div class="flex flex-col gap-3">
                            <a href="{{ $waUrl }}" target="_blank" class="inline-flex items-center justify-center px-4 sm:px-6 py-3.5 sm:py-4 bg-gradient-to-r from-[#C8902A] via-[#F0C97A] to-[#C8902A] hover:from-[#F0C97A] hover:to-[#C8902A] text-[#1F1611] border-0 text-xs sm:text-sm font-semibold rounded-full shadow-[0_0_20px_rgba(212,165,105,0.4)] w-full text-center">
                                <i class="fa-brands fa-whatsapp mr-2.5 text-base sm:text-lg flex-shrink-0"></i>
                                <span>{{ __('Call Astronaut') }} : {{ $svcPhone }}</span>
                            </a>
                            @if($lokasiLink)
                            <a href="{{ $lokasiLink }}" class="inline-flex items-center justify-center px-4 sm:px-6 py-3.5 sm:py-4 bg-[#1F1611]/80 backdrop-blur hover:bg-[#5C3317] text-[#F0C97A] border border-[#C8902A]/50 text-xs sm:text-sm font-semibold rounded-full shadow-lg transition-all duration-300 w-full text-center">
                                <i class="fa-solid fa-map-location-dot mr-2.5 text-base sm:text-lg flex-shrink-0"></i>
                                <span>{{ $lokasiText }}</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Dynamic Categories Section (Showbrand Component) -->
                @if(isset($brands) && $brands->count() > 0)
                <div class="mt-20">
                    <x-home.showbrand :brands="$brands" :activeTab="$activeTab ?? 0" />
                </div>
                @endif
            </div>
        </div>
    </main>
    <x-footer />
</body>
</html>
