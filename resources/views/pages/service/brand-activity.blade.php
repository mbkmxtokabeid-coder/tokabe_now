<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Tokabe.id - Brand Activity & Activation') }}</title>
    <meta name="description" content="{{ __('Layanan Brand Activation dari Tokabe.id: The Show Must Go On. Kami merancang aktivitas brand yang memukau audiens Anda di Sumatera.') }}">
    <meta name="keywords" content="Brand Activity Medan, Brand Activation Sumatera, Event Promosi, Peluncuran Produk">
    <meta property="og:title" content="{{ __('Tokabe.id - Brand Activity & Activation') }}">
    <meta property="og:description" content="{{ __('Layanan Brand Activation dari Tokabe.id: The Show Must Go On. Kami merancang aktivitas brand yang memukau audiens Anda di Sumatera.') }}">
    <meta property="og:image" content="https://images.unsplash.com/photo-1551836022-d5d88e9218df?q=80&w=1200&auto=format&fit=crop">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ \App\Helpers\SeoHelper::getCanonicalUrl() }}">
    <link rel="canonical" href="{{ \App\Helpers\SeoHelper::getCanonicalUrl() }}">
    <meta name="robots" content="index, follow">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('images/LogoTKB.png') }}?v=3">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/LogoTKB.png') }}?v=3">
</head>
<body class="bg-[#F9F0D6] antialiased text-gray-900 font-sans">
    <x-navbar theme="dark" />
    <main>
        <!-- Hero Section -->
        <div class="relative w-full h-[50vh] md:h-[60vh] bg-gray-900 overflow-hidden pt-20">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?q=80&w=1200&auto=format&fit=crop" alt="{{ \App\Helpers\SeoHelper::getImageAlt('brand', 'Layanan Brand Activation Medan') }}" class="w-full h-full object-cover opacity-60">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
            </div>
            <div class="relative h-full flex flex-col items-center justify-center text-center px-4 max-w-5xl mx-auto">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 uppercase tracking-tight shadow-sm">{{ __('Our Brand Activities') }}</h1>
                <p class="text-xl text-gray-200 font-medium tracking-wide">{{ __('The Show Must Go On') }}</p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
            
            <!-- Tabs -->
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                @foreach ($brands as $index => $brand)
                @php
                    $rawTabTitle = $brand->tab_title;
                    $tabTitle = is_array($rawTabTitle)
                        ? (($rawTabTitle[app()->getLocale()] ?? '') ?: ($rawTabTitle['en'] ?? '') ?: ($rawTabTitle['id'] ?? '') ?: collect($rawTabTitle)->first() ?? '')
                        : ($rawTabTitle ?: $brand->getRawOriginal('tab_title') ?? 'Brand');
                @endphp
                    <button type="button" 
                        class="btn-tab px-6 py-3 rounded-full font-bold text-sm tracking-widest uppercase transition-all duration-300 {{ $activeTab == $index ? 'bg-gradient-to-r from-[#8B5E3C] to-[#A0522D] text-white shadow-lg' : 'bg-white text-gray-500 shadow hover:bg-gray-50' }}"
                        data-tab="{{ $index }}" 
                        onclick="switchTab({{ $index }})">
                        {{ $tabTitle }}
                    </button>
                @endforeach
            </div>

            <!-- Content -->
            <div class="service-contents">
                @foreach ($brands as $index => $brand)    
                @php
                    $rawJudul = $brand->judul;
                    $judul = is_array($rawJudul)
                        ? (($rawJudul[app()->getLocale()] ?? '') ?: ($rawJudul['en'] ?? '') ?: ($rawJudul['id'] ?? '') ?: collect($rawJudul)->first() ?? '')
                        : ($rawJudul ?: $brand->getRawOriginal('judul') ?? '');

                    $rawDeskripsi = $brand->deskripsi;
                    $deskripsi = is_array($rawDeskripsi)
                        ? (($rawDeskripsi[app()->getLocale()] ?? '') ?: ($rawDeskripsi['en'] ?? '') ?: ($rawDeskripsi['id'] ?? '') ?: collect($rawDeskripsi)->first() ?? '')
                        : ($rawDeskripsi ?: $brand->getRawOriginal('deskripsi') ?? '');
                @endphp
                <div class="service-content {{ $activeTab == $index ? '' : 'hidden' }}" data-content="{{ $index }}">
                    <div class="bg-[#F9F0D6] rounded-3xl shadow-xl overflow-hidden border border-[#D4A569]/20 max-w-5xl mx-auto">
                        <div class="grid grid-cols-1 xl:grid-cols-2 gap-0 items-center">
                            <!-- Image (Gambarnya dulu di atas pada tablet & mobile) -->
                            <div class="relative w-full xl:h-full flex items-center justify-center p-4 sm:p-6 md:p-8">
                                <!-- Clean Frame matching calendar image aspect ratio (never cropped) -->
                                <div class="w-full max-w-[480px] sm:max-w-[540px] md:max-w-[600px] xl:max-w-[460px] rounded-2xl overflow-hidden bg-[#F0F4F7] flex items-center justify-center border border-black/5" style="aspect-ratio: 655/481;">
                                    <img src="{{ Str::startsWith($brand->gambar, 'http') ? $brand->gambar : asset('storage/image_brand/' . $brand->gambar) }}" 
                                        alt="{{ \App\Helpers\SeoHelper::getImageAlt('brand', $brand->judul ?? $brand->nama_brand ?? 'Brand Activity') }}"
                                        class="w-full h-full object-cover transition-transform duration-700 hover:scale-105"
                                        loading="lazy">
                                </div>
                            </div>
                            <!-- Text (Teksnya di bawah pada tablet & mobile) -->
                            <div class="p-6 sm:p-8 md:p-10 xl:p-12 flex flex-col justify-center">
                                <h3 class="text-2xl sm:text-3xl font-black text-gray-900 mb-4 sm:mb-6 uppercase tracking-tight">
                                    {{ $judul }}
                                </h3>
                                <div class="prose prose-base md:prose-lg text-gray-600 font-light leading-relaxed mb-6 md:mb-8">
                                    {!! $deskripsi !!}
                                </div>
                                <div>
                                    <a href="https://wa.me/6281122334455?text=Hello,%20I%20am%20interested%20in%20Brand%20Activity:%20{{ urlencode($judul) }}" class="inline-flex px-6 sm:px-8 py-3.5 sm:py-4 bg-gray-900 text-white text-sm sm:text-base font-bold rounded-full hover:bg-[#5C3317] hover:text-white transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                        {{ __('Get Now') }} <i class="fa-solid fa-arrow-right ml-2 mt-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Details -->
                    @if (isset($brand->detail) && !empty($brand->detail))
                    <div class="mt-16 grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                        @foreach ($brand->detail as $d)
                        @php
                            $dTitle = is_array($d['title'] ?? '') ? (($d['title'][app()->getLocale()] ?? '') ?: ($d['title']['en'] ?? '') ?: ($d['title']['id'] ?? '')) : ($d['title'] ?? '');
                            $dDesc = is_array($d['description'] ?? '') ? (($d['description'][app()->getLocale()] ?? '') ?: ($d['description']['en'] ?? '') ?: ($d['description']['id'] ?? '')) : ($d['description'] ?? '');
                        @endphp
                        <div class="bg-[#F9F0D6] rounded-3xl shadow-xl overflow-hidden border border-[#D4A569]/20 group transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl">
                            <div class="aspect-[2.3/1] overflow-hidden relative bg-white">
                                <img src="{{ Str::startsWith($d['image_url'], 'http') ? $d['image_url'] : asset('storage/image_brand_details/' . $d['image_url']) }}" 
                                    class="w-full h-full object-contain transition-transform duration-700 group-hover:scale-110" 
                                    alt="{{ \App\Helpers\SeoHelper::getImageAlt('brand', $d['title'] ?? 'Brand Activity Detail') }}">
                            </div>
                            <div class="p-6 text-center">
                                <h4 class="text-xl font-bold text-gray-900 mb-2 uppercase tracking-tight">{{ $dTitle }}</h4>
                                <p class="text-gray-600 font-light">{{ $dDesc }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

        </div>
    </main>
    <x-footer />

    <script>
        function switchTab(tabIndex) {
            document.querySelectorAll('.btn-tab').forEach(btn => {
                btn.classList.remove('bg-gradient-to-r', 'from-[#8B5E3C]', 'to-[#A0522D]', 'text-white', 'shadow-lg');
                btn.classList.add('bg-white', 'text-gray-500', 'shadow', 'hover:bg-gray-50');
                if (parseInt(btn.dataset.tab) === tabIndex) {
                    btn.classList.add('bg-gradient-to-r', 'from-[#8B5E3C]', 'to-[#A0522D]', 'text-white', 'shadow-lg');
                    btn.classList.remove('bg-white', 'text-gray-500', 'shadow', 'hover:bg-gray-50');
                }
            });

            document.querySelectorAll('.service-content').forEach(content => {
                content.classList.add('hidden');
                if (parseInt(content.dataset.content) === tabIndex) {
                    content.classList.remove('hidden');
                }
            });

            history.pushState(null, null, `?tab=${tabIndex}`);
        }
    </script>
</body>
</html>
