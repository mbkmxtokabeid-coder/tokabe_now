<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $judulText = is_array($service->judul) ? ($service->judul[app()->getLocale()] ?? $service->judul['id'] ?? $service->judul['en'] ?? collect($service->judul)->first() ?? '') : $service->judul;
        $descText = is_array($service->deskripsi) ? ($service->deskripsi[app()->getLocale()] ?? $service->deskripsi['id'] ?? $service->deskripsi['en'] ?? collect($service->deskripsi)->first() ?? '') : $service->deskripsi;
    @endphp
    <title>{{ $judulText }} - Tokabe.id</title>
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($descText ?? ''), 150) }}">
    <meta name="keywords" content="Layanan Tokabe, {{ $judulText }}, Periklanan Sumatera">
    <meta property="og:title" content="{{ $judulText }} - Tokabe.id">
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($descText ?? ''), 150) }}">
    <meta property="og:image" content="{{ asset('images/LogoTKB.jpg') }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript></noscript>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#2C1A0E] antialiased text-gray-900 font-sans">
    <x-navbar />
    <main>
<div class="relative min-h-screen bg-[#2C1A0E] pb-12">
    <!-- Hero Section with Search -->
    <div class="relative bg-gradient-to-br from-[#1A0F07] via-[#2C1A0E] to-[#5C3317] pt-36 pb-20 px-4">
        <!-- Abstract Background Shapes -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
            <div class="absolute top-24 -left-24 w-72 h-72 bg-[#D4A574] rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>
        </div>

        <div class="relative max-w-7xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                {{ is_array($service->judul) ? ($service->judul[app()->getLocale()] ?? $service->judul['id'] ?? $service->judul['en'] ?? collect($service->judul)->first() ?? '') : $service->judul }}
            </h1>
            <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto mb-10">
                {{ __('Find exactly what you are looking for in our premium services.') }}
            </p>

            <!-- Search Bar -->
            <form action="{{ in_array($service->id, [1, 2]) ? route('periklanan.show', $service->id) : route('services.show', $service->id) }}" method="GET" class="max-w-4xl mx-auto relative group z-[40]">
                <div class="flex flex-col md:flex-row gap-3">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-6 w-6 text-gray-400 group-focus-within:text-[#D4A569] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="block w-full pl-12 pr-32 py-4 rounded-full border-2 border-transparent bg-white shadow-xl focus:border-[#D4A569] focus:ring-0 text-gray-900 text-lg transition-all" 
                            placeholder="{{ __('Cari apa saja...') }}">
                        <button type="submit" class="absolute inset-y-2 right-2 px-8 bg-gradient-to-r from-[#D4A569] via-[#F0C97A] to-[#D4A569] hover:from-[#F0C97A] hover:to-[#D4A569] text-[#2C1A0E] font-semibold rounded-full shadow-md transform hover:scale-105 transition-all">
                            {{ __('Cari') }}
                        </button>
                    </div>

                    @if(in_array($service->id, [1, 2]) && isset($allProvinces) && count($allProvinces) > 0)
                        <div x-data="{ open: false, selected: '{{ request('provinsi', '') }}', selectedLabel: '{{ request('provinsi', __('Semua Provinsi')) }}' }" class="relative w-full md:w-1/3">
                            <input type="hidden" name="provinsi" :value="selected">
                            <button @click="open = !open" @click.outside="open = false" type="button" 
                                class="w-full text-left flex items-center justify-between py-4 px-6 rounded-full border-2 bg-white shadow-xl text-gray-900 text-lg transition-all focus:outline-none"
                                :class="open ? 'border-[#D4A569] shadow-[0_0_15px_rgba(212,165,105,0.3)]' : 'border-transparent hover:border-gray-200'">
                                <span x-text="selected === '' ? '{{ __('Semua Provinsi') }}' : selectedLabel" class="block truncate"></span>
                                <svg class="h-5 w-5 text-gray-500 transform transition-transform duration-300" :class="{'rotate-180 text-[#D4A569]': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" 
                                class="absolute top-full left-0 z-[100] mt-3 w-full rounded-2xl bg-white shadow-[0_15px_40px_-10px_rgba(0,0,0,0.3)] border border-gray-100 overflow-hidden">
                                <ul class="max-h-64 overflow-y-auto py-2 [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-gray-50 [&::-webkit-scrollbar-thumb]:bg-gray-200 [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-gray-300">
                                    <li @click="selected = ''; selectedLabel = '{{ __('Semua Provinsi') }}'; open = false" 
                                        class="cursor-pointer px-6 py-3 text-gray-700 hover:bg-[#F9F5F0] hover:text-[#C8902A] transition-colors flex items-center justify-between"
                                        :class="{'bg-[#F9F5F0] text-[#C8902A] font-semibold': selected === ''}">
                                        <span>{{ __('Semua Provinsi') }}</span>
                                        <svg x-show="selected === ''" class="h-5 w-5 text-[#C8902A]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                    </li>
                                    @foreach($allProvinces as $prov)
                                        <li @click="selected = '{{ $prov }}'; selectedLabel = '{{ $prov }}'; open = false" 
                                            class="cursor-pointer px-6 py-3 text-gray-700 hover:bg-[#F9F5F0] hover:text-[#C8902A] transition-colors flex items-center justify-between"
                                            :class="{'bg-[#F9F5F0] text-[#C8902A] font-semibold': selected === '{{ $prov }}'}">
                                            <span>{{ $prov }}</span>
                                            <svg x-show="selected === '{{ $prov }}'" class="h-5 w-5 text-[#C8902A]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Cards Grid Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
        @if(count($items) > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-3 sm:gap-6 lg:gap-8">
                @foreach($items as $item)
                    <div onclick="window.location.href='{{ isset($item->detail_url) ? $item->detail_url : route('dummy.detail') }}'" class="cursor-pointer bg-gradient-to-br from-[#2C1A0E] via-[#5C3317] to-[#8B5E3C] rounded-3xl overflow-hidden shadow-xl border border-white/25 hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 group flex flex-col justify-between h-full">
                        <div>
                            <div class="w-full aspect-[16/9] overflow-hidden bg-[#2C1A0E] relative">
                                <!-- Premium Skeleton Loader -->
                                <div class="absolute inset-0 bg-gradient-to-br from-[#3E2718] to-[#2C1A0E] flex items-center justify-center skeleton-loader" style="z-index: 1;">
                                    <div class="absolute inset-0 bg-black/20 animate-pulse"></div>
                                    <div class="relative flex flex-col items-center gap-3 animate-pulse">
                                        <i class="fas fa-image text-[#D4A574]/30 text-5xl"></i>
                                        <div class="h-2 w-24 bg-[#D4A574]/20 rounded-full"></div>
                                    </div>
                                </div>
                                
                                @php
                                    $isAvailable = ($item->availability ?? 'Available') !== 'Not Available';
                                @endphp
                                <img src="{{ $item->image }}" 
                                     onload="this.previousElementSibling.style.display='none'"
                                     alt="{{ \App\Helpers\SeoHelper::getImageAlt($service->judul, $item->title) }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 relative" style="z-index: 2; {{ !$isAvailable ? 'filter: grayscale(100%);' : '' }}" loading="lazy">
                                
                                @if(!$isAvailable)
                                <div class="absolute inset-0 flex items-center justify-center bg-black/40" style="z-index: 10; pointer-events: none;">
                                    <div class="transform -rotate-45 border-2 border-red-600 rounded px-2 py-1 bg-black/50 backdrop-blur-sm text-center whitespace-nowrap">
                                        <span class="text-red-500 font-black text-[10px] sm:text-xs md:text-[10px] lg:text-xs xl:text-sm tracking-widest uppercase" style="text-shadow: 1px 1px 0 #000, -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;">
                                            NOT AVAILABLE
                                        </span>
                                    </div>
                                </div>
                                @endif
                                
                                @if(!empty($item->kota))
                                    <span class="hidden sm:inline-flex absolute top-4 left-4 px-3 py-1 bg-black/70 backdrop-blur-sm text-[#D4A574] text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded-full border border-white/10" style="z-index: 3;">
                                        {{ $item->kota }}
                                    </span>
                                @endif
                            </div>

                            <div class="p-3 sm:p-4 lg:p-6">
                                <h3 class="text-xs sm:text-sm lg:text-base font-bold text-white mb-2 sm:mb-3 line-clamp-2 uppercase tracking-wide group-hover:text-[#D4A574] transition-colors">
                                    {{ $item->title }}
                                </h3>
                                @if(!empty($item->media) || !empty($item->size))
                                <div class="border-t border-white/20 pt-2 sm:pt-3 lg:pt-4 text-[10px] sm:text-xs lg:text-sm text-gray-200">
                                    <div class="flex flex-col sm:grid sm:grid-cols-2 gap-1 sm:gap-2 lg:gap-3">
                                        <div class="hidden sm:flex items-center gap-1 sm:gap-2">
                                            <i class="fas fa-layer-group text-[#D4A574] text-[10px] sm:text-xs lg:text-base"></i>
                                            <span class="line-clamp-2">{{ $item->media ?? 'LED Videotron' }}</span>
                                        </div>
                                        <div class="flex items-center gap-1 sm:gap-2">
                                            <i class="fas fa-expand-arrows-alt text-[#D4A574] text-[10px] sm:text-xs lg:text-base"></i>
                                            <span class="line-clamp-2">{{ $item->size ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="border-t border-white/20 pt-2 sm:pt-3 lg:pt-4 text-[10px] sm:text-xs lg:text-sm text-gray-200">
                                    <p class="line-clamp-2">{!! strip_tags($item->description) !!}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="px-3 sm:px-4 lg:px-6 pb-3 sm:pb-4 lg:pb-6 pt-1 mt-auto">
                            <a href="{{ isset($item->detail_url) ? $item->detail_url : route('dummy.detail') }}" class="whitespace-nowrap w-full inline-flex items-center justify-center gap-1 sm:gap-2 px-2 sm:px-4 lg:px-6 py-2 sm:py-2.5 lg:py-3 bg-gradient-to-r from-[#F5E6C8] to-[#D4A569] text-[#1F1611] font-bold text-[10px] sm:text-[11px] lg:text-sm uppercase tracking-wider rounded-full hover:from-[#D4A569] hover:to-[#C8902A] hover:scale-105 hover:shadow-lg hover:shadow-[#D4A569]/40 transition-all duration-300 group/btn shadow-sm">
                                <span>{{ __('LIHAT DETAIL') }}</span>
                                <i class="fas fa-arrow-right text-[10px] sm:text-xs transition-transform duration-300 group-hover/btn:translate-x-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Links -->
            @if($items instanceof \Illuminate\Pagination\LengthAwarePaginator && $items->hasPages())
                <div class="mt-10 mb-4 w-full">
                    {{ $items->appends(request()->query())->links('vendor.pagination.custom') }}
                </div>
            @endif
        @else
            <!-- No Results State -->
            <div class="bg-white rounded-3xl shadow-xl p-16 text-center border border-gray-100 mt-8">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-[#D4A569]/20 text-[#8B5E3C] mb-6">
                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __('No Results Found') }}</h2>
                <p class="text-gray-600 text-lg max-w-md mx-auto">
                    {{ __('We couldn\'t find anything matching your search. Try adjusting your keywords.') }}
                </p>
                <a href="{{ route('services.show', $service->id) }}" class="inline-block mt-8 px-8 py-3 bg-gray-900 text-white font-semibold rounded-full hover:bg-gray-800 transition-colors">
                    {{ __('Clear Search') }}
                </a>
            </div>
        @endif
    </div>
    </main>
    <x-footer />
</body>
</html>
