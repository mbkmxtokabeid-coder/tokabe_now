<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $judulData = $event->judul ?? $event->title ?? '';
        if (is_string($judulData) && str_starts_with($judulData, '{')) {
            $judulArray = json_decode($judulData, true);
        } else {
            $judulArray = $judulData;
        }
        if (is_array($judulArray)) {
            $judulText = $judulArray[app()->getLocale()] ?? $judulArray['id'] ?? $judulArray['en'] ?? collect($judulArray)->first() ?? '';
        } else {
            $judulText = $judulArray;
        }

        $descData = $event->deskripsi ?? $event->description ?? '';
        if (is_string($descData) && str_starts_with($descData, '{')) {
            $descArray = json_decode($descData, true);
            $descText = $descArray[app()->getLocale()] ?? $descArray['id'] ?? $descArray['en'] ?? collect($descArray)->first() ?? '';
        } else {
            $descText = $descData;
        }

        $catData = $event->category->nama_kategori ?? '';
        if (is_string($catData) && str_starts_with($catData, '{')) {
            $catArray = json_decode($catData, true);
        } else {
            $catArray = $catData;
        }
        if (is_array($catArray)) {
            $namaKat = $catArray[app()->getLocale()] ?? $catArray['id'] ?? $catArray['en'] ?? collect($catArray)->first() ?? '';
        } else {
            $namaKat = $catArray;
        }
        if (empty($namaKat)) $namaKat = 'Portofolio';
    @endphp
    <title>{{ $judulText }} | Tokabe.id</title>
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($descText ?? ''), 150) }}">
    <meta name="keywords" content="Portofolio Tokabe, {{ $judulText }}, {{ $namaKat }}">
    <meta property="og:title" content="{{ $judulText }} | Tokabe.id">
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($descText ?? ''), 150) }}">
    @if(isset($event->gambar))
    <meta property="og:image" content="{{ asset('storage/image_portofolio/' . $event->gambar) }}">
    @elseif(isset($mainImage))
    <meta property="og:image" content="{{ asset('storage/' . $mainImage->image) }}">
    @else
    <meta property="og:image" content="{{ asset('images/LogoTKB.jpg') }}">
    @endif
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#2C1A0E] antialiased text-[#F5EFE7] font-sans">
    <x-navbar theme="dark" />
    <main>
<div class="min-h-screen bg-[#2C1A0E] pt-28 pb-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Main Image Header -->
        <div class="relative w-full h-[400px] md:h-[500px] rounded-3xl overflow-hidden shadow-2xl mb-12 group" data-aos="zoom-in" data-aos-duration="1000">
            @if($event->gambar)
                <img id="main-gallery-image" src="{{ asset('storage/image_portofolio/' . $event->gambar) }}" 
                     alt="{{ \App\Helpers\SeoHelper::getImageAlt('event', $judulText) }}" 
                     class="w-full h-full object-cover transition-transform duration-700 ease-in-out">
            @elseif($mainImage)
                <img id="main-gallery-image" src="{{ asset('storage/' . $mainImage->image) }}" 
                     alt="{{ \App\Helpers\SeoHelper::getImageAlt('event', $judulText) }}" 
                     class="w-full h-full object-cover transition-transform duration-700 ease-in-out">
            @else
                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-image text-6xl text-gray-400"></i>
                </div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
            
            <div class="absolute bottom-0 left-0 p-8 md:p-12 w-full">
                @php
                    $catData = $event->category->nama_kategori ?? '';
                    if (is_string($catData) && str_starts_with($catData, '{')) {
                        $catArray = json_decode($catData, true);
                    } else {
                        $catArray = $catData;
                    }
                    if (is_array($catArray)) {
                        $namaKat = $catArray[app()->getLocale()] ?? $catArray['id'] ?? $catArray['en'] ?? collect($catArray)->first() ?? '';
                    } else {
                        $namaKat = $catArray;
                    }
                    if (empty($namaKat)) $namaKat = 'Portofolio';
                @endphp
                <span class="inline-block px-4 py-1 bg-gradient-to-r from-[#8B5E3C] to-[#A0522D] text-white font-bold text-sm rounded-full mb-4 shadow-md">
                    {{ $namaKat }}
                </span>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-2 leading-tight drop-shadow-lg">
                    {{ $judulText }}
                </h1>
                <p class="text-gray-300 font-medium flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-[#D4A574]"></i> 
                    {{ __('Published on') }} {{ $event->tanggal ? \Carbon\Carbon::parse($event->tanggal)->format('M d, Y') : $event->created_at->format('M d, Y') }}
                </p>
            </div>
        </div>

        <!-- Description -->
        <div class="bg-[#1A0F07] rounded-3xl p-8 md:p-12 shadow-sm border border-[#D4A574]/30 mb-16" data-aos="fade-up" x-data="{ expanded: false }">
            <h2 class="text-2xl font-bold text-[#F5EFE7] mb-6 border-b-2 border-[#D4A574] pb-2 inline-block">{{ __('Project Overview') }}</h2>
            <div class="relative">
                <div class="prose prose-lg max-w-none text-gray-300 leading-relaxed transition-all duration-500 overflow-hidden" 
                     :class="expanded ? 'max-h-[5000px]' : 'max-h-[120px] lg:max-h-[5000px]'">
                    @php
                        $descData = $event->deskripsi ?? $event->description ?? '';
                        if (is_string($descData) && str_starts_with($descData, '{')) {
                            $descArray = json_decode($descData, true);
                            $descText = $descArray[app()->getLocale()] ?? $descArray['id'] ?? $descArray['en'] ?? collect($descArray)->first() ?? '';
                        } else {
                            $descText = $descData;
                        }
                    @endphp
                    {!! nl2br(e($descText)) !!}
                </div>
                <!-- Gradient Fade -->
                <div x-show="!expanded" class="absolute bottom-0 left-0 w-full h-16 bg-gradient-to-t from-[#1A0F07] to-transparent lg:hidden pointer-events-none"></div>
            </div>
            
            <!-- Read More Toggle Button -->
            <button @click="expanded = !expanded" class="mt-4 text-[#D4A574] font-bold text-sm hover:text-[#e8b988] transition-colors lg:hidden flex items-center gap-2">
                <span x-text="expanded ? '{{ __('Sembunyikan') }}' : '{{ __('Baca Selengkapnya') }}'"></span>
                <i class="fas" :class="expanded ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
            </button>
        </div>

        <!-- Image Gallery -->
        @if($gallery && $gallery->count() > 1)
        <div class="mb-16" data-aos="fade-up">
            <h2 class="text-2xl font-bold text-[#F5EFE7] mb-8 border-b-2 border-[#D4A574] pb-2 inline-block">{{ __('Project Gallery') }}</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($gallery as $image)
                    <div class="relative h-32 md:h-48 rounded-xl overflow-hidden cursor-pointer shadow-sm hover:shadow-lg transition-all duration-300 group" 
                         onclick="openLightbox(this)">
                        <img src="{{ asset('storage/' . $image->image) }}" alt="{{ \App\Helpers\SeoHelper::getImageAlt('event', $judulText . ' Gallery ' . $loop->iteration) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition-colors"></div>
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="bg-black/50 text-white w-10 h-10 rounded-full flex items-center justify-center backdrop-blur-sm pointer-events-none">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Back Button -->
        <div class="text-center">
            <a href="{{ route('portofolio.list', $event->kategori) }}" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-[#D9A441] to-[#F3C96A] text-[#2C1A0E] font-bold rounded-full transition-all shadow-[0_4px_15px_rgba(217,164,65,0.3)] hover:shadow-[0_8px_25px_rgba(217,164,65,0.5)] transform hover:-translate-y-1">
                <i class="fas fa-arrow-left"></i> {{ __('Back to Projects') }}
            </a>
        </div>

    </div>
</div>

<!-- Lightbox Modal (Vanilla JS) -->
<div id="lightbox-modal" class="fixed inset-0 z-[100] items-center justify-center bg-black/90 p-4 backdrop-blur-md hidden opacity-0 transition-opacity duration-300" onclick="closeLightbox()">
    <!-- Close button -->
    <button onclick="closeLightbox()" class="absolute top-6 right-6 text-white hover:text-[#D4A574] transition-colors bg-white/10 hover:bg-white/20 rounded-full w-12 h-12 flex items-center justify-center backdrop-blur-sm z-50">
        <i class="fas fa-times text-xl"></i>
    </button>

    <!-- Image Container -->
    <img id="lightbox-image" src="" class="max-w-full max-h-[90vh] rounded-xl shadow-[0_0_50px_rgba(0,0,0,0.5)] object-contain transform scale-95 transition-transform duration-300" onclick="event.stopPropagation()">
</div>

<script>
    function openLightbox(element) {
        const modal = document.getElementById('lightbox-modal');
        const img = document.getElementById('lightbox-image');
        
        // Ambil source gambar langsung dari elemen img di dalamnya
        const sourceImg = element.querySelector('img');
        if (sourceImg) {
            img.src = sourceImg.src;
        }
        
        // Remove hidden and add flex
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Trigger reflow
        void modal.offsetWidth;
        
        // Animate in
        modal.classList.remove('opacity-0');
        modal.classList.add('opacity-100');
        img.classList.remove('scale-95');
        img.classList.add('scale-100');
        
        // Prevent body scrolling
        document.body.style.overflow = 'hidden';
    }
    
    function closeLightbox() {
        const modal = document.getElementById('lightbox-modal');
        const img = document.getElementById('lightbox-image');
        
        // Animate out
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        img.classList.remove('scale-100');
        img.classList.add('scale-95');
        
        // Wait for transition to finish before hiding
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            img.src = '';
            
            // Restore body scrolling
            document.body.style.overflow = '';
        }, 300);
    }
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        }
    });
</script>

    </main>
    <x-footer />
</body>
</html>
