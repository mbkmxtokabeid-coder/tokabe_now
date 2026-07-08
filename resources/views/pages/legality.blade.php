<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Legality | Tokabe.id</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#2C1A0E] antialiased text-[#F5EFE7] font-sans">
    <x-navbar />
    <main>
        <!-- Header Hero Section -->
        <div class="bg-gradient-to-br from-[#1A0F07] via-[#2C1A0E] to-[#5C3317] pt-40 pb-24 text-center relative overflow-hidden">
            <!-- Decorative subtle glowing blur circles -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-white opacity-5 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-[#D4A574] opacity-10 blur-3xl"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white uppercase tracking-tight mb-4 drop-shadow-md">
                    {!! nl2br(__('Company Legality')) !!}
                </h1>
                <p class="text-base sm:text-lg lg:text-xl text-[#F5EFE7] max-w-3xl mx-auto font-light leading-relaxed drop-shadow-sm">
                    {{ __('Official documents and certifications ensuring Tokabe.id operates with full compliance, trust, and professionalism.') }}
                </p>
            </div>
        </div>

        <!-- Grid Layout Section -->
        <div class="bg-[#2C1A0E] py-16 sm:py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Grid Layout for Certificates -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            
            @foreach($legalities as $index => $legality)
            <div class="bg-[#5C3317]/30 backdrop-blur-md rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col items-center justify-center border border-[#8B5E3C]/30 group hover:bg-[#5C3317]/60 hover:border-[#D4A574]/50" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                <div class="w-32 h-32 mb-6 flex items-center justify-center bg-white rounded-full p-4 shadow-md transition-colors">
                    @if($legality->image)
                        <img src="{{ asset('storage/' . $legality->image) }}" alt="{{ \App\Helpers\SeoHelper::getImageAlt('legal', $legality->name_id . ' Tokabe.id') }}" class="max-w-full max-h-full object-contain filter drop-shadow-sm rounded-full" loading="lazy">
                    @else
                        <div class="text-[#8B5E3C]"><i class="fas fa-certificate fa-3x"></i></div>
                    @endif
                </div>
                <h3 class="text-xl font-bold text-[#F5EFE7] mb-2 text-center">{{ app()->getLocale() == 'en' ? $legality->name_en : $legality->name_id }}</h3>
                <p class="text-[#D4A574] font-medium text-center text-sm">{!! nl2br(e(app()->getLocale() == 'en' ? $legality->description_en : $legality->description_id)) !!}</p>
            </div>
            @endforeach

        </div>
    </div>
</div>
    </main>
    <x-footer />
</body>
</html>
