<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Tokabe.id - Discover Location') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" type="image/jpeg" href="{{ asset('images/LogoTKB.jpg') }}?v=2">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('images/LogoTKB.jpg') }}?v=2">

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-white antialiased text-gray-900 flex flex-col min-h-screen">

    <x-navbar theme="dark" />

    @php
        $countOoh = collect($lokasiOoh)->count();
        $countDooh = collect($lokasiDooh)->count();
    @endphp

    <main class="flex-grow pt-32 pb-24">
        <div class="max-w-[1600px] mx-auto px-6 sm:px-8 lg:px-12">
            
            <!-- Header Section -->
            <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100 mb-12">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                    <div class="md:w-1/2">
                        <span class="text-[#D4A574] font-bold tracking-widest text-sm uppercase mb-3 block">
                            {{ $countOoh }} OOH & {{ $countDooh }} DOOH
                        </span>
                        <h1 class="text-4xl md:text-5xl font-black text-gray-900 leading-tight">
                            @if($countDooh > 0 && $countOoh > 0)
                                {{ __('Discover Our DOOH & OOH Locations') }}
                            @elseif($countDooh > 0)
                                {{ __('Discover Our DOOH Locations') }}
                            @else
                                {{ __('Discover Our OOH Locations') }}
                            @endif
                            @if($region)
                                <span class="text-[#D4A574]">in {{ $region }}</span>
                            @endif
                        </h1>
                        <p class="text-gray-500 mt-6 text-lg">
                            @if($countDooh > 0 && $countOoh > 0)
                                {{ __('Explore our digital and static outdoor advertising locations across provinces to reach audiences with dynamic and engaging visual advertising.') }}
                            @elseif($countDooh > 0)
                                {{ __('Explore digital out-of-home (DOOH) screens across provinces to reach audiences with dynamic and engaging visual advertising.') }}
                            @else
                                {{ __('Explore our static outdoor advertising locations (OOH) by province to boost your brand visibility across Indonesia.') }}
                            @endif
                        </p>
                    </div>

                    <!-- Search Form -->
                    <div class="md:w-1/2 w-full">
                        <form method="GET" action="{{ route('discover') }}" class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                            <h3 class="text-xl font-bold mb-4">{{ __('Search Strategic Location') }}</h3>
                            <div class="flex flex-col sm:flex-row gap-3">
                                @if($region)
                                    <input type="hidden" name="region" value="{{ $region }}">
                                @endif
                                <select name="type" class="form-select w-full sm:w-1/3 rounded-xl border-gray-300 shadow-sm focus:border-yellow-400 focus:ring focus:ring-yellow-400 focus:ring-opacity-50">
                                    <option value="" {{ !request('type') ? 'selected' : '' }}>{{ __('All') }}</option>
                                    <option value="DOOH" {{ request('type') === 'DOOH' ? 'selected' : '' }}>DOOH</option>
                                    <option value="OOH" {{ request('type') === 'OOH' ? 'selected' : '' }}>OOH</option>
                                </select>
                                <input type="text" name="s" class="form-input w-full rounded-xl border-gray-300 shadow-sm focus:border-yellow-400 focus:ring focus:ring-yellow-400 focus:ring-opacity-50" placeholder="{{ __('Search...') }}" value="{{ request('s') }}">
                                <button type="submit" class="bg-yellow-400 text-black font-bold py-2 px-6 rounded-xl hover:bg-yellow-500 transition-colors shadow-sm whitespace-nowrap">
                                    {{ __('Search') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- DOOH Section -->
            @if($countDooh > 0)
            <div class="mb-16">
                <div class="flex items-center gap-4 mb-8">
                    <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tight">Digital Out-of-Home (DOOH)</h2>
                    <div class="flex-grow h-px bg-gray-300"></div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($lokasiDooh as $item)
                    <div onclick="window.location.href='{{ route('dooh.detail', $item->id) }}'" class="cursor-pointer bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100/80 hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 group flex flex-col h-full">
                        <div class="w-full aspect-video overflow-hidden relative bg-black">
                            <img src="{{ $item->gambar ? asset('storage/image_lokasi/' . $item->gambar) : 'https://images.unsplash.com/photo-1542204165-65bf26472b9b?q=80&w=600&auto=format&fit=crop' }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="{{ is_array($item->nama) ? ($item->nama['id'] ?? collect($item->nama)->first()) : $item->nama }}">
                            <span class="absolute top-4 left-4 px-3 py-1.5 bg-black/70 backdrop-blur-md text-[#D4A574] text-xs font-bold uppercase tracking-wider rounded-full shadow-md">
                                {{ $item->provinsi ?? 'Location' }}
                            </span>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-[#D4A574] transition-colors">
                                {{ is_array($item->nama) ? ($item->nama[app()->getLocale()] ?? $item->nama['id'] ?? $item->nama['en'] ?? collect($item->nama)->first() ?? '') : $item->nama }}
                            </h3>
                            <p class="text-gray-600 line-clamp-3 text-sm mb-6 flex-grow">
                                {{ strip_tags(is_array($item->deskripsi_lokasi) ? ($item->deskripsi_lokasi[app()->getLocale()] ?? $item->deskripsi_lokasi['id'] ?? $item->deskripsi_lokasi['en'] ?? collect($item->deskripsi_lokasi)->first() ?? '') : $item->deskripsi_lokasi) }}
                            </p>
                            <a href="{{ route('dooh.detail', $item->id) }}" class="inline-flex items-center text-sm font-bold text-[#D4A574] hover:text-[#b58b60]">
                                {{ __('Read More') }} <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if(isset($totalPagesDooh) && $totalPagesDooh > 1)
                <div class="flex justify-center mt-10 gap-2">
                    @if($page > 1)
                        <a href="{{ route('discover', array_merge(request()->query(), ['page' => $page - 1])) }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium hover:bg-gray-50">Previous</a>
                    @endif
                    <span class="px-4 py-2 bg-yellow-400 text-black font-bold rounded-lg">Page {{ $page }} of {{ $totalPagesDooh }}</span>
                    @if($page < $totalPagesDooh)
                        <a href="{{ route('discover', array_merge(request()->query(), ['page' => $page + 1])) }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium hover:bg-gray-50">Next</a>
                    @endif
                </div>
                @endif
            </div>
            @endif

            <!-- OOH Section -->
            @if($countOoh > 0)
            <div class="mb-16">
                <div class="flex items-center gap-4 mb-8">
                    <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tight">Out-of-Home (OOH)</h2>
                    <div class="flex-grow h-px bg-gray-300"></div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($lokasiOoh as $item)
                    <div onclick="window.location.href='{{ route('ooh.detail', $item->id) }}'" class="cursor-pointer bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100/80 hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 group flex flex-col h-full">
                        <div class="w-full aspect-video overflow-hidden relative bg-black">
                            <img src="{{ $item->gambar ? asset('storage/image_lokasiooh/' . $item->gambar) : 'https://images.unsplash.com/photo-1542204165-65bf26472b9b?q=80&w=600&auto=format&fit=crop' }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" alt="{{ is_array($item->nama) ? ($item->nama['id'] ?? collect($item->nama)->first()) : $item->nama }}">
                            <span class="absolute top-4 left-4 px-3 py-1.5 bg-black/70 backdrop-blur-md text-[#D4A574] text-xs font-bold uppercase tracking-wider rounded-full shadow-md">
                                {{ $item->wilayah ?? $item->provinsi ?? 'Location' }}
                            </span>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-[#D4A574] transition-colors">
                                {{ is_array($item->nama) ? ($item->nama[app()->getLocale()] ?? $item->nama['id'] ?? $item->nama['en'] ?? collect($item->nama)->first() ?? '') : $item->nama }}
                            </h3>
                            <p class="text-gray-600 line-clamp-3 text-sm mb-6 flex-grow">
                                {{ strip_tags(is_array($item->deskripsi_lokasi) ? ($item->deskripsi_lokasi[app()->getLocale()] ?? $item->deskripsi_lokasi['id'] ?? $item->deskripsi_lokasi['en'] ?? collect($item->deskripsi_lokasi)->first() ?? '') : $item->deskripsi_lokasi) }}
                            </p>
                            <a href="{{ route('ooh.detail', $item->id) }}" class="inline-flex items-center text-sm font-bold text-[#D4A574] hover:text-[#b58b60]">
                                {{ __('Read More') }} <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if(isset($totalPagesOoh) && $totalPagesOoh > 1)
                <div class="flex justify-center mt-10 gap-2">
                    @if($page > 1)
                        <a href="{{ route('discover', array_merge(request()->query(), ['page' => $page - 1])) }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium hover:bg-gray-50">Previous</a>
                    @endif
                    <span class="px-4 py-2 bg-yellow-400 text-black font-bold rounded-lg">Page {{ $page }} of {{ $totalPagesOoh }}</span>
                    @if($page < $totalPagesOoh)
                        <a href="{{ route('discover', array_merge(request()->query(), ['page' => $page + 1])) }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium hover:bg-gray-50">Next</a>
                    @endif
                </div>
                @endif
            </div>
            @endif

            @if($countDooh == 0 && $countOoh == 0)
            <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-gray-100">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 text-gray-400 mb-4">
                    <i class="fas fa-search text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Locations Found</h3>
                <p class="text-gray-500">We couldn't find any DOOH or OOH locations matching your criteria.</p>
                <a href="{{ route('discover') }}" class="inline-block mt-6 px-6 py-2 bg-yellow-400 text-black font-bold rounded-lg hover:bg-yellow-500 transition-colors">Clear Search</a>
            </div>
            @endif

        </div>
    </main>

    <x-footer />

    @if(isset($notificationMessage) && $notificationMessage)
    <!-- Notification Toast -->
    <div id="notification-toast" class="fixed bottom-5 right-5 bg-white border-l-4 border-yellow-400 rounded shadow-xl p-4 flex items-start gap-4 z-50 transform transition-transform duration-300 translate-y-0">
        <div class="text-[#D4A574]">
            <i class="fas fa-exclamation-circle text-xl"></i>
        </div>
        <div>
            <h4 class="font-bold text-gray-900">Notice</h4>
            <p class="text-sm text-gray-600">{{ $notificationMessage }}</p>
        </div>
        <button onclick="document.getElementById('notification-toast').style.display='none'" class="text-gray-400 hover:text-gray-600">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('notification-toast');
            if(toast) {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }
        }, 5000);
    </script>
    @endif

</body>
</html>
