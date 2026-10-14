<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Single Detail Lokasi - Dummy - Tokabe.id</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('images/LogoTKB.png') }}?v=3">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/LogoTKB.png') }}?v=3">
</head>
<body class="bg-white antialiased text-gray-900 font-sans">
    <x-navbar />
    <main>
<div class="min-h-screen bg-gray-50 pt-32 pb-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Dummy Image -->
            <div class="h-96 bg-gray-200 relative">
                <img src="https://images.unsplash.com/photo-1542204165-65bf26472b9b?q=80&w=1200&auto=format&fit=crop" alt="{{ \App\Helpers\SeoHelper::getImageAlt('dooh', 'Putri Hijau Street, Next To GMP Building') }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-8 left-8 text-white">
                    <span class="px-4 py-2 bg-purple-600 rounded-full text-sm font-semibold uppercase tracking-wider mb-4 inline-block">Location Details</span>
                    <h1 class="text-4xl md:text-5xl font-bold">Putri Hijau Street, Next To GMP Building</h1>
                </div>
            </div>

            <!-- Dummy Content -->
            <div class="p-8 md:p-12">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <div class="lg:col-span-2 space-y-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Point of Interest</h2>
                            <p class="text-gray-600 text-lg leading-relaxed">
                                The ONE and ONLY in Medan two screens Videotron, connecting vertical and horizontal motion also HIGHLIGHTS the SYNCHRONIZED MOTION. This location offers unparalleled visibility and is positioned at one of the busiest intersections in the city.
                            </p>
                        </div>

                        <!-- Dummy Map -->
                        <div class="rounded-2xl overflow-hidden shadow-md">
                            <iframe
                                src="https://www.google.com/maps?q=3.5852,98.6756&hl=es;z=14&output=embed"
                                width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>
                        </div>
                    </div>

                    <!-- Sidebar Info -->
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 h-fit">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Location Specifications</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                                <span class="text-gray-500 font-medium">Ad Duration</span>
                                <span class="text-gray-900 font-bold">15 Seconds</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                                <span class="text-gray-500 font-medium">Screen Size</span>
                                <span class="text-gray-900 font-bold">8m x 4m</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                                <span class="text-gray-500 font-medium">Type</span>
                                <span class="text-gray-900 font-bold">LED Videotron</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                                <span class="text-gray-500 font-medium">Ad Display Hours</span>
                                <span class="text-gray-900 font-bold">06:00 - 24:00</span>
                            </div>
                            
                            <div class="mt-8 pt-4">
                                <a href="https://wa.me/6281112345678" target="_blank" class="w-full flex items-center justify-center px-8 py-4 bg-green-500 text-white font-bold rounded-xl hover:bg-green-600 transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.573-.187-.981-.342-1.714-.652-2.824-2.412-2.909-2.527-.085-.115-.693-.935-.693-1.782 0-.847.435-1.265.588-1.428.153-.163.333-.204.444-.204.111 0 .222.001.318.005.099.004.233-.038.358.261.129.309.439 1.077.478 1.155.039.078.065.168.013.272-.052.104-.078.169-.156.262-.078.093-.165.205-.234.283-.078.087-.162.183-.071.341.091.157.405.67.873 1.085.606.538 1.111.705 1.272.783.161.078.255.065.352-.043.097-.108.419-.489.531-.657.111-.168.222-.14.368-.087.146.053.923.435 1.082.514.159.079.265.118.304.183.039.065.039.381-.105.786z"></path></svg>
                                    Contact Admin
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
    <x-footer />
</body>
</html>
