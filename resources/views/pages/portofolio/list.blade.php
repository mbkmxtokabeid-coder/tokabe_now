<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $catData = $category->nama_kategori ?: ($category->getRawOriginal ? $category->getRawOriginal('nama_kategori') : '');
        $catArray = is_string($catData) && str_starts_with($catData, '{') ? json_decode($catData, true) : $catData;
        $namaKat = is_array($catArray) ? ($catArray[app()->getLocale()] ?? $catArray['id'] ?? $catArray['en'] ?? collect($catArray)->first() ?? '') : $catArray;
        
        $catDesc = $category->deskripsi ?? '';
    @endphp
    <title>Portofolio - {{ $namaKat }} | Tokabe.id</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #2C1A0E; color: #F5EFE7; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .luxury-gradient-text {
            background: linear-gradient(90deg, #4E3426 0%, #8B5E3C 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .btn-gold-gradient {
            background: linear-gradient(90deg, #D9A441, #F3C96A);
            box-shadow: 0 4px 15px rgba(217, 164, 65, 0.3);
            transition: all 0.3s ease;
        }
        .btn-gold-gradient:hover {
            box-shadow: 0 8px 25px rgba(217, 164, 65, 0.5);
            transform: translateY(-2px);
        }
        
        .premium-card {
            border-radius: 24px;
            background: #1A0F07;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            transition: all 0.35s cubic-bezier(0.25, 0.8, 0.25, 1);
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.05);
        }
        .premium-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        }
        
        .premium-card-img-container {
            height: 260px;
            overflow: hidden;
            position: relative;
        }
        .premium-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .premium-card:hover .premium-card-img {
            transform: scale(1.05);
        }
        
        .img-gradient-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0) 50%);
            position: absolute;
            inset: 0;
            z-index: 10;
        }
        
        /* Custom Input Styling */
        .premium-input {
            background: #1A0F07;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 10px 16px;
            font-size: 0.9rem;
            color: #F5EFE7;
            transition: all 0.2s ease;
        }
        .premium-input:focus {
            outline: none;
            border-color: #D6A24C;
            box-shadow: 0 0 0 3px rgba(214, 162, 76, 0.15);
        }
        
        /* Pagination Styling */
        nav[role="navigation"] p {
            display: none;
        }
        .pagination-container .relative.z-0.inline-flex.rounded-md.shadow-sm {
            background: #1A0F07;
            border-radius: 999px;
            padding: 4px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.05);
        }
        .pagination-container a, .pagination-container span[aria-disabled="true"] {
            border: none !important;
            border-radius: 999px !important;
            margin: 0 2px;
            color: #9CA3AF;
            font-weight: 500;
        }
        .pagination-container span[aria-current="page"] > span {
            background: linear-gradient(90deg, #D9A441, #F3C96A) !important;
            color: #2C1A0E !important;
            border: none !important;
            border-radius: 999px !important;
            box-shadow: 0 4px 10px rgba(217, 164, 65, 0.3);
        }
    </style>
</head>
<body class="antialiased overflow-x-hidden">
    <x-navbar theme="dark" />
    
    <main class="pt-32 pb-32">
        <!-- Hero Section -->
        <section class="relative pt-12 pb-20 overflow-visible">
            <!-- Decorative blur shapes -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
                <div class="absolute top-[-20%] right-[-10%] w-[600px] h-[600px] rounded-full bg-[#D6A24C] filter blur-[120px] opacity-10"></div>
                <div class="absolute bottom-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-[#EAE2D3] filter blur-[120px] opacity-5"></div>
            </div>
            
            <div class="max-w-[1280px] mx-auto px-6 sm:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <!-- Left: Content -->
                    <div class="max-w-[700px]" data-aos="fade-up" data-aos-duration="1000">
                        <div class="inline-block px-4 py-1.5 rounded-full bg-[#1A0F07] border border-[#D6A24C]/20 shadow-sm mb-6">
                            <span class="text-xs font-bold tracking-widest text-[#D6A24C] uppercase">{{ __('PORTFOLIO') }}</span>
                        </div>
                        
                        <h1 class="text-4xl sm:text-5xl lg:text-[56px] font-extrabold leading-[1.1] tracking-tight text-white mb-6">
                            {{ $namaKat }}
                        </h1>
                        
                        <p class="text-[17px] leading-[1.7] text-gray-400 mb-10 max-w-[600px]">
                            {{ $catDesc ?: __('Dokumentasi berbagai proyek dan instalasi sukses yang telah kami kerjakan pada kategori ini.') }}
                        </p>
                        
                        <a href="#projects" class="btn-gold-gradient inline-flex items-center gap-3 px-8 py-4 rounded-full text-[#4E3426] font-bold text-sm tracking-wide">
                            {{ __('Lihat Semua Proyek') }} <i class="fa-solid fa-arrow-down text-xs"></i>
                        </a>
                    </div>
                    
                    <!-- Right: Hero Image -->
                    <div class="relative hidden lg:block" data-aos="fade-left" data-aos-duration="1200">
                        @php
<<<<<<< HEAD
                            $heroImage = $category->image 
                                ? (\Illuminate\Support\Str::startsWith($category->image, 'http') ? $category->image : asset('storage/' . $category->image)) 
                                : ($portfolios->first() ? ($portfolios->first()->gambar ? asset('storage/image_portofolio/' . $portfolios->first()->gambar) : ($portfolios->first()->firstImage ? asset('storage/' . $portfolios->first()->firstImage->image) : null)) : null);
=======
                            $firstItem = $portfolios->first();
                            $heroImage = null;
                            if ($firstItem) {
                                if ($firstItem->gambar) {
                                    $heroImage = str_starts_with($firstItem->gambar, 'http') ? $firstItem->gambar : asset('storage/' . ltrim($firstItem->gambar, '/'));
                                } elseif ($firstItem->firstImage) {
                                    $heroImage = asset('storage/' . ltrim($firstItem->firstImage->image, '/'));
                                }
                            }
>>>>>>> f93d13293ba78146c5d34202cc6c798e3424e18f
                        @endphp
                        
                        @if($heroImage)
                        <div class="rounded-[32px] overflow-hidden shadow-[0_20px_60px_rgba(0,0,0,0.3)] border-[8px] border-[#1A0F07] relative aspect-[4/3] bg-[#1A0F07]">
                            <img src="{{ $heroImage }}" alt="{{ $namaKat }}" class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-1000">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent pointer-events-none"></div>
                        </div>
                        @else
                        <div class="rounded-[32px] bg-[#1A0F07] shadow-[0_20px_60px_rgba(0,0,0,0.3)] border-[8px] border-[#1A0F07] relative aspect-[4/3] flex items-center justify-center">
                            <i class="fa-solid fa-image text-6xl text-gray-700"></i>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- UX Controls & Grid -->
        <section id="projects" class="max-w-[1280px] mx-auto px-6 sm:px-8 mt-8">
            <!-- Toolbar -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10 pb-6 border-b border-white/5" data-aos="fade-up">
                <div class="flex items-center gap-3">
                    <h2 class="text-xl font-bold text-white">{{ __('Semua Proyek') }}</h2>
                    <span class="bg-[#D6A24C]/20 text-[#D6A24C] text-xs font-bold px-2.5 py-1 rounded-full">{{ $portfolios->total() }}</span>
                </div>
            </div>

            <!-- Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($portfolios as $index => $item)
                    @php
                        $judulData = $item->judul ?? $item->title ?? '';
                        $judulArray = (is_string($judulData) && str_starts_with($judulData, '{')) ? json_decode($judulData, true) : $judulData;
                        $judulText = is_array($judulArray) ? ($judulArray[app()->getLocale()] ?? $judulArray['id'] ?? collect($judulArray)->first() ?? '') : $judulArray;
                        
                        $imgSrc = null;
                        if ($item->gambar) {
                            $imgSrc = str_starts_with($item->gambar, 'http') ? $item->gambar : asset('storage/' . ltrim($item->gambar, '/'));
                        } elseif ($item->firstImage) {
                            $imgSrc = asset('storage/' . ltrim($item->firstImage->image, '/'));
                        }
                        $date = $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : $item->created_at->format('d M Y');
                    @endphp
                    
                    <a href="{{ route('portofolio.detail', $item->id) }}" class="premium-card group block" data-aos="fade-up" data-aos-delay="{{ ($index % 3) * 100 }}">
                        <div class="premium-card-img-container bg-[#1A0F07]">
                            <div class="img-gradient-overlay pointer-events-none"></div>
                            @if($imgSrc)
                                <img src="{{ $imgSrc }}" alt="{{ $judulText }}" class="premium-card-img" loading="lazy">
                            @else
                                <div class="w-full h-full bg-[#1A0F07] flex items-center justify-center">
                                    <i class="fa-solid fa-image text-3xl text-gray-700"></i>
                                </div>
                            @endif
                            
                            <!-- Category Badge inside image -->
                            <div class="absolute top-5 left-5 z-20">
                                <span class="bg-[#1A0F07]/95 backdrop-blur-md text-[#D6A24C] border border-[#D6A24C]/20 text-[10px] font-bold px-3 py-1.5 rounded-full shadow-sm tracking-wide">
                                    {{ $namaKat }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6 relative">
                            <!-- View Detail Button (Hover) -->
                            <div class="absolute -top-6 right-6 w-12 h-12 bg-[#D6A24C] rounded-full flex items-center justify-center text-[#1A0F07] shadow-lg opacity-0 transform translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 z-20">
                                <i class="fa-solid fa-arrow-right -rotate-45"></i>
                            </div>
                            
                            <h3 class="text-lg font-bold text-white leading-snug mb-2 line-clamp-2 group-hover:text-[#D6A24C] transition-colors">
                                {{ $judulText }}
                            </h3>
                            
                            <div class="flex items-center text-gray-400 text-sm mt-4 font-medium">
                                <i class="fa-regular fa-calendar mr-2 text-[#D6A24C]"></i>
                                {{ $date }}
                            </div>
                        </div>
                    </a>
                @empty
                    <!-- Empty State -->
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 py-24 flex flex-col items-center justify-center text-center bg-[#1A0F07] rounded-3xl border border-dashed border-gray-700">
                        <div class="w-20 h-20 bg-[#2C1A0E] rounded-full flex items-center justify-center mb-4 border border-white/5">
                            <i class="fa-solid fa-folder-open text-3xl text-gray-600"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">{{ __('Tidak Ada Proyek Ditemukan') }}</h3>
                        <p class="text-gray-400 max-w-sm">{{ __('Maaf, tidak ada proyek yang sesuai dengan pencarian atau filter Anda saat ini.') }}</p>
                        <a href="{{ route('portofolio.list', $category->id) }}" class="mt-6 text-[#D6A24C] font-semibold hover:underline">
                            {{ __('Reset Pencarian') }}
                        </a>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($portfolios->hasPages())
                <div class="mt-16 flex justify-center pagination-container">
                    {{ $portfolios->links() }}
                </div>
            @endif
            
        </section>
    </main>
    
    <x-footer />
</body>
</html>
