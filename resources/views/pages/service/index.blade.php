<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Layanan - Tokabe.id</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F9F0D6] antialiased text-gray-900 font-sans">
    <x-navbar />
    <main>
        <!-- Header Hero Section -->
        <div class="bg-gradient-to-br from-[#1A0F07] via-[#2C1A0E] to-[#5C3317] pt-40 pb-24 text-center relative overflow-hidden">
            <!-- Decorative subtle glowing blur circles -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-white opacity-5 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-[#D4A574] opacity-10 blur-3xl"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white uppercase tracking-tight mb-4 drop-shadow-md">
                    {!! __('Our Services Header') !!}
                </h1>
                <p class="text-base sm:text-lg lg:text-xl text-[#F5EFE7] max-w-3xl mx-auto font-light leading-relaxed drop-shadow-sm">
                    {!! strip_tags(__('service_title_html')) !!}
                </p>
            </div>
        </div>

        <!-- Services Grid Section -->
        <div class="bg-[#F9F0D6] py-16 sm:py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            @foreach($services as $index => $item)
                @php
                    $judul = is_array($item->judul) ? (($item->judul[app()->getLocale()] ?? '') ?: ($item->judul['id'] ?? '') ?: ($item->judul['en'] ?? '') ?: (collect($item->judul)->first() ?? '')) : $item->judul;
                    $deskripsi = is_array($item->deskripsi) ? (($item->deskripsi[app()->getLocale()] ?? '') ?: ($item->deskripsi['id'] ?? '') ?: ($item->deskripsi['en'] ?? '') ?: (collect($item->deskripsi)->first() ?? '')) : $item->deskripsi;
                    $cleanDesc = strip_tags($deskripsi);
                    $shortDesc = \Illuminate\Support\Str::limit($cleanDesc, 120, '...');
                @endphp
                <a href="{{ route('services.show', $item->id) }}" class="group block h-full" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="w-full h-full bg-gradient-to-br from-[#2C1A0E] via-[#5C3317] to-[#8B5E3C] rounded-3xl overflow-hidden shadow-xl border border-white/25 hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 flex flex-col justify-between">
                        <div>
                            <!-- Image Container -->
                            <div class="w-full aspect-[16/10] overflow-hidden bg-gray-900 relative">
                                @if(Str::endsWith($item->gambar, ['.mp4', '.webm', '.ogg']))
                                    <video autoplay loop muted playsinline class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out">
                                        <source src="{{ asset('storage/image_service/' . $item->gambar) }}" type="video/mp4">
                                    </video>
                                @elseif($item->gambar)
                                    <img src="{{ asset('storage/image_service/' . $item->gambar) }}" 
                                         alt="{{ $judul }}" 
                                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out"
                                         loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-[#2C1A0E]">
                                        <i class="{{ $item->ikon ?? 'fas fa-desktop' }} text-4xl text-white/50"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-white mb-3 line-clamp-2 uppercase tracking-wide group-hover:text-[#D4A574] transition-colors">
                                    {{ $judul }}
                                </h3>
                                <div class="border-t border-white/20 pt-4 text-xs sm:text-sm text-gray-200">
                                    <p class="line-clamp-2">
                                        {{ $shortDesc }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="px-6 pb-6 pt-1 mt-auto">
                            <span class="whitespace-nowrap w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-[#F5E6C8] to-[#D4A569] text-[#1F1611] font-bold text-sm uppercase tracking-wider rounded-full hover:from-[#D4A569] hover:to-[#C8902A] hover:scale-105 hover:shadow-lg hover:shadow-[#D4A569]/40 transition-all duration-300 group/btn shadow-sm">
                                <span>{{ __('Lihat Detail') }}</span>
                                <i class="fas fa-arrow-right text-xs transition-transform duration-300 group-hover/btn:translate-x-1"></i>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

    </div>
</div>
    </main>
    <x-footer />
</body>
</html>
