<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Legality | Tokabe.id</title>
    <meta name="description" content="{{ __('Tokabe.id adalah agensi periklanan terbaik di Medan, Sumatera. Kami menyediakan layanan sewa Videotron (DOOH), Billboard (OOH), Event Organizer, dan Brand Activation.') }}">
    <meta name="keywords" content="Sewa videotron Medan, Billboard Sumatera, Event organizer Medan, Advertising agency Sumatera, Jasa OOH Medan">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="{{ __('Tokabe.id - Legality') }}">
    <meta property="og:description" content="{{ __('Tokabe.id adalah agensi periklanan terbaik di Medan, Sumatera. Kami menyediakan layanan sewa Videotron (DOOH), Billboard (OOH), Event Organizer, dan Brand Activation.') }}">
    <meta property="og:image" content="{{ asset('images/LogoTKB.jpg') }}">
    <meta property="og:url" content="{{ \App\Helpers\SeoHelper::getCanonicalUrl() }}">    
    <title>{{ __('Tokabe.id - Legality') }}</title>

    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PLCTPGGZ');</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    <link rel="preload" as="font" type="font/woff2" href="https://fonts.gstatic.com/s/poppins/v24/pxiEyp8kv8JHgFVrJJfecg.woff2" crossorigin>
    <link rel="preload" as="font" type="font/woff2" href="https://fonts.gstatic.com/s/poppins/v24/pxiByp8kv8JHgFVrLEj6Z1xlFQ.woff2" crossorigin>
    <link rel="canonical" href="{{ \App\Helpers\SeoHelper::getCanonicalUrl() }}">
    @if (! \Illuminate\Support\Facades\Vite::isRunningHot())
        <style id="app-css-inline">{!! \Illuminate\Support\Facades\Vite::content('resources/css/app.css') !!}</style>
        @vite('resources/js/app.js')
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <link rel="icon" type="image/png" href="{{ asset('images/LogoTKB.png') }}?v=3">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/LogoTKB.png') }}?v=3">
    <style>
        /* Inlined Poppins font-face to eliminate render-blocking external Google Fonts request */
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v24/pxiByp8kv8JHgFVrLDz8Z1xlFQ.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v24/pxiEyp8kv8JHgFVrJJfecg.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v24/pxiByp8kv8JHgFVrLGT9Z1xlFQ.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v24/pxiByp8kv8JHgFVrLEj6Z1xlFQ.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v24/pxiByp8kv8JHgFVrLCz7Z1xlFQ.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        body { font-family: 'Poppins', sans-serif; }
        
        /* Font Awesome font-display: swap override to prevent text blocking (LCP) */
        @font-face {
            font-family: 'Font Awesome 6 Free';
            font-style: normal;
            font-weight: 900;
            font-display: swap;
            src: url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2");
        }
        @font-face {
            font-family: 'Font Awesome 6 Free';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-regular-400.woff2") format("woff2");
        }
        @font-face {
            font-family: 'Font Awesome 6 Brands';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-brands-400.woff2") format("woff2");
        }
    </style>
</head>
<body class="bg-[#2C1A0E] antialiased text-[#F5EFE7] font-sans">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PLCTPGGZ"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
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
                <h2 class="text-xl font-bold text-[#F5EFE7] mb-2 text-center">{{ app()->getLocale() == 'en' ? $legality->name_en : $legality->name_id }}</h2>
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
