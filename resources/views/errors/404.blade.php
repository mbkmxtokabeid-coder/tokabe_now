<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title id="meta-title">404 - Halaman Tidak Ditemukan | {{ config('app.name', 'Tokabe.id') }}</title>

    <link rel="icon" type="image/jpeg" href="{{ asset('images/LogoTKB.jpg') }}?v=2">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('images/LogoTKB.jpg') }}?v=2">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite Assets (Tailwind CSS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        @keyframes floatUpDown {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .animate-float {
            animation: floatUpDown 2.5s ease-in-out infinite;
        }
    </style>
</head>
<body class="h-full bg-[#1A0F07] text-white flex flex-col justify-between selection:bg-amber-500 selection:text-white relative overflow-x-hidden">

    <!-- Background Glow Effects -->
    <div class="pointer-events-none absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[450px] bg-gradient-to-tr from-amber-600/20 via-orange-500/15 to-transparent blur-3xl rounded-full"></div>
    <div class="pointer-events-none absolute bottom-0 right-0 w-96 h-96 bg-amber-700/10 blur-3xl rounded-full"></div>

    <!-- Header / Brand Logo & Language Switcher -->
    <header class="w-full py-6 px-6 sm:px-12 flex items-center justify-between z-10">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <img src="{{ asset('images/LogoTKB.jpg') }}" alt="Tokabe Logo" class="h-10 w-10 rounded-full object-cover shadow-md group-hover:scale-105 transition-transform duration-300">
            <span class="font-bold text-xl tracking-tight text-white group-hover:text-amber-400 transition-colors">
                Tokabe<span class="text-amber-500">.id</span>
            </span>
        </a>

        <!-- Language Switcher (ID / EN) -->
        <div class="inline-flex items-center bg-white/5 border border-white/10 rounded-full p-1 text-xs font-semibold backdrop-blur-md shadow-inner">
            <button type="button" 
                    id="btn-lang-id" 
                    onclick="switchLanguage('id')" 
                    class="px-3 py-1 rounded-full transition-all duration-300 bg-amber-500 text-black font-bold shadow-md">
                ID
            </button>
            <button type="button" 
                    id="btn-lang-en" 
                    onclick="switchLanguage('en')" 
                    class="px-3 py-1 rounded-full text-gray-400 hover:text-white transition-all duration-300">
                EN
            </button>
        </div>
    </header>

    <!-- Main 404 Content -->
    <main class="flex-grow flex items-center justify-center px-4 sm:px-6 py-12 z-10">
        <div class="max-w-2xl w-full text-center">

            <!-- Big 404 Display -->
            <h1 class="text-8xl sm:text-9xl font-extrabold tracking-tighter text-transparent bg-clip-text bg-gradient-to-b from-amber-200 via-amber-500 to-amber-700 select-none drop-shadow-2xl">
                404
            </h1>

            <!-- Not Found Emoji / Icon Display -->
            <div class="mt-2 mb-4 flex flex-col items-center justify-center">
                <div class="text-6xl sm:text-7xl animate-float select-none drop-shadow-lg cursor-pointer transition-transform hover:scale-110 active:scale-95 duration-200" title="Lost in space!">
                    😵‍💫
                </div>
                <div class="mt-3 inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-300/90 text-xs font-medium backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-ping"></span>
                    <span id="badge-lost">Oops! Halaman Tidak Ditemukan</span>
                </div>
            </div>

            <!-- Title -->
            <h2 id="text-title" class="mt-2 text-2xl sm:text-3xl font-bold text-white tracking-tight">
                Halaman Yang Anda Cari Tidak Ada
            </h2>

            <!-- Description -->
            <p id="text-desc" class="mt-3 text-sm sm:text-base text-gray-400 max-w-md mx-auto leading-relaxed">
                URL atau endpoint yang Anda tuju mungkin salah ketik, telah dihapus, atau sedang dalam pembaruan rute.
            </p>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4">
                <a href="{{ url('/') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 font-semibold text-sm bg-gradient-to-r from-[#C8902A] via-[#F0C97A] to-[#C8902A] text-[#1F1611] rounded-full hover:from-[#F0C97A] hover:to-[#C8902A] shadow-[0_0_25px_rgba(212,165,105,0.6)] hover:shadow-[0_0_40px_rgba(240,201,122,0.8)] transition-all duration-300 transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-house"></i>
                    <span id="btn-home">Kembali ke Beranda</span>
                </a>

                <button onclick="window.history.back()" 
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full font-medium text-sm text-gray-300 bg-white/5 hover:bg-white/10 border border-white/10 hover:border-white/20 transition-all duration-300">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span id="btn-back">Halaman Sebelumnya</span>
                </button>
            </div>

            <!-- Quick Links -->
            <div class="mt-12 pt-8 border-t border-white/10 max-w-lg mx-auto">
                <p id="quick-links-title" class="text-xs uppercase tracking-wider text-gray-500 font-semibold mb-4">
                    Navigasi Populer
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4 text-xs sm:text-sm text-gray-400">
                    <a href="{{ url('/') }}#services" id="link-services" class="hover:text-amber-400 transition-colors">Layanan</a>
                    <span class="text-gray-700">•</span>
                    <a href="{{ url('/portofolio') }}" id="link-portfolio" class="hover:text-amber-400 transition-colors">Portofolio</a>
                    <span class="text-gray-700">•</span>
                    <a href="https://wa.me/628115239999" target="_blank" rel="noopener noreferrer" class="hover:text-amber-400 transition-colors">
                        <i class="fa-brands fa-whatsapp text-emerald-400 mr-1"></i><span id="link-contact">Hubungi Kami</span>
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer Simple -->
    <footer id="footer-text" class="w-full py-4 text-center text-xs text-gray-500 z-10">
        &copy; {{ date('Y') }} Tokabe.id. Hak cipta dilindungi.
    </footer>

    <!-- Language Switcher Script -->
    <script>
        const translations = {
            id: {
                title: "404 - Halaman Tidak Ditemukan | {{ config('app.name', 'Tokabe.id') }}",
                badge: "Oops! Halaman Tidak Ditemukan",
                heading: "Halaman Yang Anda Cari Tidak Ada",
                desc: "URL atau endpoint yang Anda tuju mungkin salah ketik, telah dihapus, atau sedang dalam pembaruan rute.",
                home: "Kembali ke Beranda",
                back: "Halaman Sebelumnya",
                quickTitle: "Navigasi Populer",
                services: "Layanan",
                portfolio: "Portofolio",
                contact: "Hubungi Kami",
                footer: "© {{ date('Y') }} Tokabe.id. Hak cipta dilindungi."
            },
            en: {
                title: "404 - Page Not Found | {{ config('app.name', 'Tokabe.id') }}",
                badge: "Oops! Page Not Found",
                heading: "The Page You Are Looking For Does Not Exist",
                desc: "The URL or endpoint you are heading to may be mistyped, removed, or undergoing route updates.",
                home: "Back to Home",
                back: "Previous Page",
                quickTitle: "Popular Navigation",
                services: "Services",
                portfolio: "Portfolio",
                contact: "Contact Us",
                footer: "© {{ date('Y') }} Tokabe.id. All rights reserved."
            }
        };

        function switchLanguage(lang) {
            const data = translations[lang];
            if (!data) return;

            // Update text elements
            document.title = data.title;
            document.getElementById('badge-lost').innerText = data.badge;
            document.getElementById('text-title').innerText = data.heading;
            document.getElementById('text-desc').innerText = data.desc;
            document.getElementById('btn-home').innerText = data.home;
            document.getElementById('btn-back').innerText = data.back;
            document.getElementById('quick-links-title').innerText = data.quickTitle;
            document.getElementById('link-services').innerText = data.services;
            document.getElementById('link-portfolio').innerText = data.portfolio;
            document.getElementById('link-contact').innerText = data.contact;
            document.getElementById('footer-text').innerText = data.footer;

            // Toggle active button style
            const btnId = document.getElementById('btn-lang-id');
            const btnEn = document.getElementById('btn-lang-en');

            if (lang === 'id') {
                btnId.className = "px-3 py-1 rounded-full transition-all duration-300 bg-amber-500 text-black font-bold shadow-md";
                btnEn.className = "px-3 py-1 rounded-full text-gray-400 hover:text-white transition-all duration-300";
            } else {
                btnEn.className = "px-3 py-1 rounded-full transition-all duration-300 bg-amber-500 text-black font-bold shadow-md";
                btnId.className = "px-3 py-1 rounded-full text-gray-400 hover:text-white transition-all duration-300";
            }

            // Save choice
            localStorage.setItem('tokabe_lang', lang);
        }

        // Load saved language on page load
        document.addEventListener('DOMContentLoaded', () => {
            const savedLang = localStorage.getItem('tokabe_lang') || 'id';
            if (savedLang === 'en') {
                switchLanguage('en');
            }
        });
    </script>
</body>
</html>
