<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tokabe.id - Photography & Videography</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white antialiased text-gray-900 font-sans">
    <x-navbar theme="dark" />
    <main>
        <!-- Hero Section -->
        <div class="relative w-full h-[50vh] md:h-[60vh] bg-gray-900 overflow-hidden pt-20">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=1200&auto=format&fit=crop" alt="{{ \App\Helpers\SeoHelper::getImageAlt('photo', 'Jasa Dokumentasi Foto Video Event Medan') }}" class="w-full h-full object-cover opacity-60">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
            </div>
            <div class="relative h-full flex flex-col items-center justify-center text-center px-4 max-w-5xl mx-auto">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 uppercase tracking-tight shadow-sm">{{ __('Our Photography & Videography') }}</h1>
                <p class="text-xl text-gray-200 font-medium tracking-wide">{{ __('Capturing Moments, Creating Memories') }}</p>
            </div>
        </div>

        <!-- Content Section -->
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                @foreach ($photography as $photo)
                @php
                    $title = is_array($photo->title) ? (($photo->title[app()->getLocale()] ?? '') ?: ($photo->title['en'] ?? '') ?: ($photo->title['id'] ?? '')) : ($photo->title ?: $photo->getRawOriginal('title'));
                    $description = is_array($photo->description) ? (($photo->description[app()->getLocale()] ?? '') ?: ($photo->description['en'] ?? '') ?: ($photo->description['id'] ?? '')) : ($photo->description ?: $photo->getRawOriginal('description'));
                @endphp
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 group transition-all duration-500 hover:-translate-y-3 hover:shadow-2xl">
                    <div class="h-64 overflow-hidden relative">
                        <img src="{{ asset('storage/image_photography/' . $photo->image_url) }}" alt="{{ \App\Helpers\SeoHelper::getImageAlt('photo', $photo->title) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors"></div>
                    </div>
                    <div class="p-8 text-center">
                        <h3 class="text-2xl font-bold text-gray-900 mb-3 uppercase tracking-tight">{{ $title }}</h3>
                        <p class="text-gray-600 font-light leading-relaxed">
                            {{ $description }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
    <x-footer />
</body>
</html>
