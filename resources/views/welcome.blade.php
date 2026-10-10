<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Tokabe.id - Advertising Agency Solutions in Medan, Sumatera') }}</title>
    <meta name="description" content="{{ __('Tokabe.id adalah agensi periklanan terbaik di Medan, Sumatera. Kami menyediakan layanan sewa Videotron (DOOH), Billboard (OOH), Event Organizer, dan Brand Activation.') }}">
    <meta name="keywords" content="Sewa videotron Medan, Billboard Sumatera, Event organizer Medan, Advertising agency Sumatera, Jasa OOH Medan">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/') }}">
    
    <meta property="og:title" content="{{ __('Tokabe.id - Advertising Agency Solutions in Medan, Sumatera') }}">
    <meta property="og:description" content="{{ __('Tokabe.id adalah agensi periklanan terbaik di Medan, Sumatera. Kami menyediakan layanan sewa Videotron (DOOH), Billboard (OOH), Event Organizer, dan Brand Activation.') }}">
    <meta property="og:image" content="{{ asset('images/LogoTKB.jpg') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">

    <!-- JSON-LD Schema Markup -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "AdvertisingAgency",
      "name": "Tokabe.id",
      "image": "{{ asset('images/LogoTKB.jpg') }}",
      "@id": "{{ url('/') }}",
      "url": "{{ url('/') }}",
      "description": "Tokabe.id Videotron DOOH, OOH, Event Organizer, Brand Activity, Sponsor Agency.",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Medan",
        "addressRegion": "Sumatera Utara",
        "addressCountry": "ID"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 3.5952,
        "longitude": 98.6722
      }
    }
    </script>

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preload" as="font" type="font/woff2" href="https://fonts.gstatic.com/s/poppins/v24/pxiEyp8kv8JHgFVrJJfecg.woff2" crossorigin>
    <link rel="preload" as="font" type="font/woff2" href="https://fonts.gstatic.com/s/poppins/v24/pxiByp8kv8JHgFVrLEj6Z1xlFQ.woff2" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
    
    @if(isset($heroes) && count($heroes) > 0 && $heroes->first()->gambar)
    <link rel="preload" as="image" href="{{ asset('storage/image_hero/' . $heroes->first()->gambar) }}">
    @endif
    
    {{-- Tailwind CSS di-inline agar tidak render-blocking (menghemat 1 round-trip sebelum first paint / LCP).
         Saat dev server Vite berjalan (public/hot), pakai @vite biasa supaya HMR tetap jalan. --}}
    @if (! \Illuminate\Support\Facades\Vite::isRunningHot())
        <style id="app-css-inline">{!! \Illuminate\Support\Facades\Vite::content('resources/css/app.css') !!}</style>
        @vite('resources/js/app.js')
    @else
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <link rel="icon" type="image/jpeg" href="{{ asset('images/LogoTKB.jpg') }}?v=2">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('images/LogoTKB.jpg') }}?v=2">

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
            font-family: 'Font Awesome 6 Brands';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-brands-400.woff2") format("woff2");
        }
    </style>
</head>
<body class="bg-[#2C1A0E] antialiased text-gray-900">

    <x-navbar />

    <main>
        <x-home.hero :heroes="$heroes" />

        <x-home.partners :partners="$partners" />

        <x-home.about :about="$about" />

        <x-home.services :services="$services" />


        <x-home.map />

        <x-home.advertising-sites :lokasi="$lokasi" :lokasiooh="$lokasiooh" />

        <x-home.cta />
    </main>

    <x-footer />

</body>
</html>
