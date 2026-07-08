@props(['brands' => collect([]), 'activeTab' => 0])

<style>
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<!-- Tabs -->
<div class="flex flex-nowrap md:flex-wrap overflow-x-auto md:justify-center gap-3 md:gap-4 mb-8 md:mb-12 pb-4 md:pb-0 px-4 md:px-0 snap-x hide-scrollbar">
    @foreach ($brands as $brand)
    @php
        $rawTabTitle = $brand->tab_title ?? '';
        $tabTitle = is_array($rawTabTitle)
            ? (($rawTabTitle[app()->getLocale()] ?? '') ?: ($rawTabTitle['en'] ?? '') ?: ($rawTabTitle['id'] ?? '') ?: collect($rawTabTitle)->first() ?? '')
            : ($rawTabTitle ?: (method_exists($brand, 'getRawOriginal') ? $brand->getRawOriginal('tab_title') : 'Brand'));
    @endphp
        <button type="button" 
            class="btn-tab shrink-0 snap-center whitespace-nowrap px-5 md:px-6 py-2.5 md:py-3 rounded-full font-bold text-xs md:text-sm tracking-widest uppercase transition-all duration-300 {{ $activeTab == $loop->index ? 'bg-gradient-to-r from-[#8B5E3C] to-[#A0522D] text-white shadow-lg' : 'bg-white text-gray-500 shadow hover:bg-gray-50' }}"
            data-tab="{{ $loop->index }}" 
            onclick="switchTab({{ $loop->index }})">
            {{ $tabTitle }}
        </button>
    @endforeach
</div>

<!-- Content -->
<div class="service-contents">
    @foreach ($brands as $brand)    
    @php
        $rawJudul = $brand->judul ?? '';
        $judul = is_array($rawJudul)
            ? (($rawJudul[app()->getLocale()] ?? '') ?: ($rawJudul['en'] ?? '') ?: ($rawJudul['id'] ?? '') ?: collect($rawJudul)->first() ?? '')
            : ($rawJudul ?: (method_exists($brand, 'getRawOriginal') ? $brand->getRawOriginal('judul') : ''));

        $rawDeskripsi = $brand->deskripsi ?? '';
        $deskripsi = is_array($rawDeskripsi)
            ? (($rawDeskripsi[app()->getLocale()] ?? '') ?: ($rawDeskripsi['en'] ?? '') ?: ($rawDeskripsi['id'] ?? '') ?: collect($rawDeskripsi)->first() ?? '')
            : ($rawDeskripsi ?: (method_exists($brand, 'getRawOriginal') ? $brand->getRawOriginal('deskripsi') : ''));
    @endphp
    <div class="service-content {{ $activeTab == $loop->index ? '' : 'hidden' }}" data-content="{{ $loop->index }}">
        <div class="bg-gradient-to-br from-[#2C1A0E] via-[#3D2514] to-[#2C1A0E] rounded-3xl shadow-2xl overflow-hidden border border-white/10 max-w-5xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                <!-- Image -->
                <div class="h-64 md:h-auto overflow-hidden relative bg-[#2C1A0E]">
                    <!-- Premium Skeleton Loader -->
                    <div class="absolute inset-0 bg-gradient-to-br from-[#3E2718] to-[#2C1A0E] flex items-center justify-center skeleton-loader" style="z-index: 1;">
                        <div class="absolute inset-0 bg-black/20 animate-pulse"></div>
                        <div class="relative flex flex-col items-center gap-3 animate-pulse">
                            <i class="fas fa-image text-[#D4A574]/30 text-5xl"></i>
                            <div class="h-2 w-24 bg-[#D4A574]/20 rounded-full"></div>
                        </div>
                    </div>
                    <img src="{{ Str::startsWith($brand->gambar, 'http') ? $brand->gambar : asset('storage/image_brand/' . $brand->gambar) }}" 
                        alt="{{ \App\Helpers\SeoHelper::getImageAlt('brand', $brand->judul ?? $brand->nama_brand ?? 'Brand Activity') }}"
                        class="w-full h-full object-cover transition-transform duration-700 hover:scale-110 relative" style="z-index: 2;" onload="this.previousElementSibling.style.display='none'" loading="lazy">
                </div>
                <!-- Text -->
                <div class="p-8 md:p-12 flex flex-col justify-center">
                    <h3 class="text-3xl font-black text-white mb-6 uppercase tracking-tight">
                        {{ $judul }}
                    </h3>
                    <div class="prose prose-lg prose-invert text-gray-300 font-light leading-relaxed mb-8">
                        {!! $deskripsi !!}
                    </div>
                    <div>
                        <a href="https://wa.me/6281122334455?text=Hello,%20I%20am%20interested%20in%20Brand%20Activity:%20{{ urlencode($judul) }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-[#C8902A] via-[#F0C97A] to-[#C8902A] hover:from-[#F0C97A] hover:to-[#C8902A] text-[#1F1611] border-0 text-base font-bold rounded-full shadow-[0_0_20px_rgba(212,165,105,0.4)] hover:shadow-[0_0_35px_rgba(240,201,122,0.6)] transform hover:-translate-y-1 transition-all duration-300">
                            {{ __('Get Now') }} <i class="fa-solid fa-arrow-right ml-2 mt-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Details -->
        @if (isset($brand->detail) && !empty($brand->detail))
        <div class="mt-16 flex flex-col md:flex-row gap-8 max-w-4xl mx-auto items-start">
            <!-- Left Column -->
            <div class="w-full md:w-1/2 flex flex-col gap-8">
                @foreach ($brand->detail as $d)
                @if($loop->odd)
                @php
                    $dTitle = is_array($d['title'] ?? '') ? (($d['title'][app()->getLocale()] ?? '') ?: ($d['title']['en'] ?? '') ?: ($d['title']['id'] ?? '')) : ($d['title'] ?? '');
                    $dDesc = is_array($d['description'] ?? '') ? (($d['description'][app()->getLocale()] ?? '') ?: ($d['description']['en'] ?? '') ?: ($d['description']['id'] ?? '')) : ($d['description'] ?? '');
                @endphp
                <div class="w-full">
                    <!-- Actual interactive card -->
                    <div x-data="{ expanded: false, isTouch: false }" 
                         @touchstart="isTouch = true"
                         @mouseenter="if (!isTouch) expanded = true"
                         @mouseleave="if (!isTouch) expanded = false"
                         @click="if (isTouch) expanded = !expanded"
                         class="relative w-full bg-gradient-to-br from-[#2C1A0E] via-[#3D2514] to-[#2C1A0E] rounded-3xl shadow-xl overflow-hidden border border-white/10 transition-all duration-300 ease-out cursor-pointer flex flex-col"
                         :class="expanded ? '-translate-y-2 shadow-2xl shadow-black/50' : ''">
                        <div class="h-48 overflow-hidden relative shrink-0 bg-[#2C1A0E]">
                            <!-- Premium Skeleton Loader -->
                            <div class="absolute inset-0 bg-gradient-to-br from-[#3E2718] to-[#2C1A0E] flex items-center justify-center skeleton-loader" style="z-index: 1;">
                                <div class="absolute inset-0 bg-black/20 animate-pulse"></div>
                                <div class="relative flex flex-col items-center gap-3 animate-pulse">
                                    <i class="fas fa-image text-[#D4A574]/30 text-3xl"></i>
                                    <div class="h-1.5 w-16 bg-[#D4A574]/20 rounded-full"></div>
                                </div>
                            </div>
                            <img src="{{ Str::startsWith($d['image_url'], 'http') ? $d['image_url'] : asset('storage/image_brand_details/' . $d['image_url']) }}" 
                                class="w-full h-full object-cover transition-transform duration-700 relative" style="z-index: 2;"
                                :class="expanded ? 'scale-110' : ''"
                                onload="this.previousElementSibling.style.display='none'" loading="lazy"
                                alt="{{ \App\Helpers\SeoHelper::getImageAlt('brand', $d['title'] ?? 'Brand Activity Detail') }}">
                            <div class="absolute inset-0 transition-colors" style="z-index: 3;" :class="expanded ? 'bg-black/0' : 'bg-black/20'"></div>
                        </div>
                        <div class="p-6 text-center flex flex-col flex-1">
                            <h4 class="text-xl font-bold text-white mb-2 uppercase tracking-tight transition-all duration-300">{{ $dTitle }}</h4>
                            <div class="relative overflow-hidden transition-all duration-1000 ease-in-out" 
                                 :class="expanded ? 'max-h-[250px]' : 'max-h-[4.5rem]'"
                                 :style="expanded ? '' : '-webkit-mask-image: linear-gradient(to bottom, black 50%, transparent 100%); mask-image: linear-gradient(to bottom, black 50%, transparent 100%);'">
                                <p class="text-gray-300 font-light pb-2">{{ $dDesc }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            
            <!-- Right Column -->
            <div class="w-full md:w-1/2 flex flex-col gap-8">
                @foreach ($brand->detail as $d)
                @if($loop->even)
                @php
                    $dTitle = is_array($d['title'] ?? '') ? (($d['title'][app()->getLocale()] ?? '') ?: ($d['title']['en'] ?? '') ?: ($d['title']['id'] ?? '')) : ($d['title'] ?? '');
                    $dDesc = is_array($d['description'] ?? '') ? (($d['description'][app()->getLocale()] ?? '') ?: ($d['description']['en'] ?? '') ?: ($d['description']['id'] ?? '')) : ($d['description'] ?? '');
                @endphp
                <div class="w-full">
                    <!-- Actual interactive card -->
                    <div x-data="{ expanded: false, isTouch: false }" 
                         @touchstart="isTouch = true"
                         @mouseenter="if (!isTouch) expanded = true"
                         @mouseleave="if (!isTouch) expanded = false"
                         @click="if (isTouch) expanded = !expanded"
                         class="relative w-full bg-gradient-to-br from-[#2C1A0E] via-[#3D2514] to-[#2C1A0E] rounded-3xl shadow-xl overflow-hidden border border-white/10 transition-all duration-300 ease-out cursor-pointer flex flex-col"
                         :class="expanded ? '-translate-y-2 shadow-2xl shadow-black/50' : ''">
                        <div class="h-48 overflow-hidden relative shrink-0 bg-[#2C1A0E]">
                            <!-- Premium Skeleton Loader -->
                            <div class="absolute inset-0 bg-gradient-to-br from-[#3E2718] to-[#2C1A0E] flex items-center justify-center skeleton-loader" style="z-index: 1;">
                                <div class="absolute inset-0 bg-black/20 animate-pulse"></div>
                                <div class="relative flex flex-col items-center gap-3 animate-pulse">
                                    <i class="fas fa-image text-[#D4A574]/30 text-3xl"></i>
                                    <div class="h-1.5 w-16 bg-[#D4A574]/20 rounded-full"></div>
                                </div>
                            </div>
                            <img src="{{ Str::startsWith($d['image_url'], 'http') ? $d['image_url'] : asset('storage/image_brand_details/' . $d['image_url']) }}" 
                                class="w-full h-full object-cover transition-transform duration-700 relative" style="z-index: 2;"
                                :class="expanded ? 'scale-110' : ''"
                                onload="this.previousElementSibling.style.display='none'" loading="lazy"
                                alt="{{ \App\Helpers\SeoHelper::getImageAlt('brand', $d['title'] ?? 'Brand Activity Detail') }}">
                            <div class="absolute inset-0 transition-colors" style="z-index: 3;" :class="expanded ? 'bg-black/0' : 'bg-black/20'"></div>
                        </div>
                        <div class="p-6 text-center flex flex-col flex-1">
                            <h4 class="text-xl font-bold text-white mb-2 uppercase tracking-tight transition-all duration-300">{{ $dTitle }}</h4>
                            <div class="relative overflow-hidden transition-all duration-1000 ease-in-out" 
                                 :class="expanded ? 'max-h-[250px]' : 'max-h-[4.5rem]'"
                                 :style="expanded ? '' : '-webkit-mask-image: linear-gradient(to bottom, black 50%, transparent 100%); mask-image: linear-gradient(to bottom, black 50%, transparent 100%);'">
                                <p class="text-gray-300 font-light pb-2">{{ $dDesc }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @endforeach
</div>

<script>
    if (typeof switchTab !== 'function') {
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
    }
</script>
