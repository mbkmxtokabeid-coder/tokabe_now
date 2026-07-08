<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ is_array($service->judul) ? ($service->judul[app()->getLocale()] ?? $service->judul['id'] ?? $service->judul['en'] ?? '') : $service->judul }} - Tokabe.id</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"></noscript>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                        $lokasiLink = route('periklanan.show', 1);
                        $lokasiText = __('Lihat Lokasi DOOH');
                    } elseif ($isOoh) {
                        $lokasiLink = route('periklanan.show', 2);
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
                    <div class="relative z-10 p-8 md:p-12 w-full">
                        <div class="flex flex-row items-end justify-between gap-8">
                            
                            <!-- Title & Description -->
                            <div class="flex-1">
                                <h1 class="text-4xl lg:text-6xl font-black text-white mb-4 drop-shadow-lg leading-tight">
                                    {{ is_array($service->judul) ? ($service->judul[app()->getLocale()] ?? $service->judul['id'] ?? $service->judul['en'] ?? '') : $service->judul }}
                                </h1>
                                <div class="prose prose-lg prose-invert text-gray-200 max-w-3xl drop-shadow-md leading-relaxed">
                                    {!! is_array($service->deskripsi) ? ($service->deskripsi[app()->getLocale()] ?? $service->deskripsi['id'] ?? $service->deskripsi['en'] ?? '') : $service->deskripsi !!}
                                </div>
                            </div>
                            
                            <!-- CTA Buttons -->
                            <div class="shrink-0 flex flex-col gap-4 min-w-[200px]">
                                <a href="{{ $waUrl }}" target="_blank" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-[#C8902A] via-[#F0C97A] to-[#C8902A] hover:from-[#F0C97A] hover:to-[#C8902A] text-[#1F1611] border-0 text-base font-semibold rounded-full shadow-[0_0_20px_rgba(212,165,105,0.5)] hover:shadow-[0_0_35px_rgba(240,201,122,0.7)] hover:-translate-y-1 transform transition-all duration-300 w-full whitespace-nowrap">
                                    <i class="fa-brands fa-whatsapp mr-3 text-xl"></i>
                                    {{ __('Call Astronaut : ' . $svcPhone) }}
                                </a>
                                @if($lokasiLink)
                                <a href="{{ $lokasiLink }}" class="inline-flex items-center justify-center px-8 py-4 bg-[#1F1611]/80 backdrop-blur hover:bg-[#5C3317] text-[#F0C97A] border border-[#C8902A]/50 text-base font-semibold rounded-full shadow-lg hover:shadow-[0_0_20px_rgba(212,165,105,0.4)] transform hover:-translate-y-1 transition-all duration-300 w-full whitespace-nowrap">
                                    <i class="fa-solid fa-map-location-dot mr-3 text-xl"></i>
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
                            <a href="{{ $waUrl }}" target="_blank" class="inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-[#C8902A] via-[#F0C97A] to-[#C8902A] hover:from-[#F0C97A] hover:to-[#C8902A] text-[#1F1611] border-0 text-sm font-semibold rounded-full shadow-[0_0_20px_rgba(212,165,105,0.4)] w-full">
                                <i class="fa-brands fa-whatsapp mr-3 text-lg"></i>
                                {{ __('Call Astronaut : ' . $svcPhone) }}
                            </a>
                            @if($lokasiLink)
                            <a href="{{ $lokasiLink }}" class="inline-flex items-center justify-center px-6 py-4 bg-[#1F1611]/80 backdrop-blur hover:bg-[#5C3317] text-[#F0C97A] border border-[#C8902A]/50 text-sm font-semibold rounded-full shadow-lg transition-all duration-300 w-full">
                                <i class="fa-solid fa-map-location-dot mr-3 text-lg"></i>
                                {{ $lokasiText }}
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
                
                <!-- Showcase Portfolio Section -->
                <div class="mt-20">
                    <x-home.showcase-portofolio :categories="$portofolioCategories ?? collect([])" :portofolios="$portofolios ?? collect([])" />
                </div>
            </div>
        </div>
    </main>
    <x-footer />
</body>
</html>
