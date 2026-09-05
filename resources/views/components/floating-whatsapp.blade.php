@php
    $contact = \App\Models\Contact::first();
    $rawPhone = ($contact && !empty($contact->phone)) ? $contact->phone : '628115239999';
    $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
    if (str_starts_with($cleanPhone, '0')) {
        $cleanPhone = '62' . substr($cleanPhone, 1);
    }
    if (empty($cleanPhone)) {
        $cleanPhone = '628115239999';
    }

    $currentRoute = request()->route() ? request()->route()->getName() : '';
    $currentPath = request()->path();

    // Default configuration
    $pageCategory = 'General';
    $badgeTitle = 'Konsultasi Iklan & Event';
    $tooltipText = 'Butuh penawaran harga videotron, baliho, atau event? Chat kami!';
    $messageTemplate = 'Halo Tokabe.id, saya berkunjung ke website Tokabe dan ingin berkonsultasi mengenai kebutuhan periklanan/event untuk perusahaan saya. Boleh info selengkapnya?';

    // Check service detail route: /services/{id}
    $serviceId = request()->route('id');
    if (!$serviceId && preg_match('#^services/(\d+)#', $currentPath, $sMatches)) {
        $serviceId = $sMatches[1];
    }
    $isServiceDetail = (request()->routeIs('services.show') && $serviceId) || (str_starts_with($currentPath, 'services/') && !empty($serviceId));
    $isServiceIndex = request()->routeIs('services.index') || $currentPath === 'services';

    // Page-specific detection
    if ($isServiceDetail) {
        $svcObj = null;
        if (isset($service) && is_object($service) && isset($service->judul)) {
            $svcObj = $service;
        } elseif ($serviceId) {
            $svcObj = \App\Models\Service::find($serviceId);
        }

        $svcTitle = '';
        if ($svcObj && isset($svcObj->judul)) {
            $svcTitle = is_array($svcObj->judul) 
                ? ($svcObj->judul[app()->getLocale()] ?? $svcObj->judul['id'] ?? $svcObj->judul['en'] ?? collect($svcObj->judul)->first() ?? '') 
                : $svcObj->judul;
        }
        $svcTitleLower = strtolower($svcTitle);

        if (str_contains($svcTitleLower, 'videotron') || str_contains($svcTitleLower, 'dooh')) {
            $pageCategory = 'Layanan Videotron DOOH';
            $badgeTitle = 'Sewa Videotron DOOH';
            $tooltipText = 'Tanyakan harga sewa & titik strategis Videotron (DOOH) Tokabe!';
            $messageTemplate = 'Halo Tokabe.id, saya tertarik dengan layanan ' . ($svcTitle ?: 'Periklanan Videotron (DOOH)') . ' di Medan/Sumatera. Boleh minta katalog titik strategis, ketersediaan slot tayang, dan penawaran harganya?';
        } elseif (str_contains($svcTitleLower, 'baliho') || str_contains($svcTitleLower, 'billboard') || str_contains($svcTitleLower, 'ooh')) {
            $pageCategory = 'Layanan Billboard OOH';
            $badgeTitle = 'Sewa Billboard & Baliho';
            $tooltipText = 'Tanyakan titik billboard & baliho strategis di Sumatera Utara!';
            $messageTemplate = 'Halo Tokabe.id, saya sedang mencari vendor advertising OOH & sewa billboard di Sumatera Utara. Boleh minta info katalog titik lokasi yang ready beserta harganya?';
        } elseif (str_contains($svcTitleLower, 'acara') || str_contains($svcTitleLower, 'event') || str_contains($svcTitleLower, 'merek') || str_contains($svcTitleLower, 'brand')) {
            $pageCategory = 'Layanan Event & Brand Activity';
            $badgeTitle = 'Event & Corporate Gathering';
            $tooltipText = 'Rencanakan event gathering atau brand activation perusahaan Anda bersama Tokabe!';
            $messageTemplate = 'Halo Tokabe.id, saya tertarik dengan layanan ' . ($svcTitle ?: 'Kegiatan Acara & Merek') . ' di Medan. Boleh minta katalog portofolio, proposal event gathering, dan jadwal diskusinya?';
        } elseif (str_contains($svcTitleLower, 'foto') || str_contains($svcTitleLower, 'video')) {
            $pageCategory = 'Layanan Videografi & Fotografi';
            $badgeTitle = 'Videografi & Fotografi';
            $tooltipText = 'Tanyakan paket produksi video promosi komersial & foto profesional!';
            $messageTemplate = 'Halo Tokabe.id, saya tertarik dengan layanan ' . ($svcTitle ?: 'Videografi & Fotografi') . ' Tokabe untuk kebutuhan promosi/branding. Boleh minta info paket dan rate harganya?';
        } elseif (str_contains($svcTitleLower, 'cetak') || str_contains($svcTitleLower, 'print')) {
            $pageCategory = 'Layanan Percetakan Digital';
            $badgeTitle = 'Percetakan Digital';
            $tooltipText = 'Cetak materi promosi, spanduk, banner & baliho berkualitas!';
            $messageTemplate = 'Halo Tokabe.id, saya ingin menanyakan layanan ' . ($svcTitle ?: 'Percetakan Digital') . ' untuk kebutuhan materi promosi/banner perusahaan saya. Boleh minta info daftar harga dan estimasi pengerjaannya?';
        } else {
            $pageCategory = 'Layanan ' . ($svcTitle ?: 'Advertising');
            $badgeTitle = $svcTitle ?: 'Detail Layanan';
            $tooltipText = 'Konsultasikan kebutuhan ' . ($svcTitle ?: 'layanan') . ' Anda bersama kami!';
            $messageTemplate = 'Halo Tokabe.id, saya tertarik dengan layanan ' . ($svcTitle ?: '{ITEM_TITLE}') . ' di website Tokabe. Boleh minta penjelasan lebih detail dan penawaran harganya?';
        }
    } elseif ($isServiceIndex) {
        $pageCategory = 'Katalog Layanan';
        $badgeTitle = 'Katalog Layanan Tokabe';
        $tooltipText = 'Bingung memilih media iklan yang tepat? Konsultasi gratis di sini!';
        $messageTemplate = 'Halo Tokabe.id, saya sedang melihat katalog layanan periklanan di website Tokabe. Boleh bantu rekomendasikan solusi promosi yang paling efektif untuk bisnis saya?';
    } elseif (request()->routeIs('home') || $currentPath === '/' || $currentPath === '') {
        $pageCategory = 'Homepage';
        $badgeTitle = 'Tanya Tokabe';
        $tooltipText = 'Solusi Videotron, Billboard & Event di Medan & Sumut. Konsultasikan di sini!';
        $messageTemplate = 'Halo Tokabe.id, saya tertarik untuk konsultasi kebutuhan periklanan (Videotron / Billboard / Event Organizer) untuk brand/perusahaan saya. Boleh minta info selengkapnya?';
    } elseif (request()->routeIs('dooh.detail') || str_starts_with($currentPath, 'lokasi/dooh')) {
        $pageCategory = 'DOOH Detail';
        $badgeTitle = 'Sewa Videotron Outdoor';
        $tooltipText = 'Tanyakan ketersediaan slot tayang & harga titik Videotron ini!';
        $messageTemplate = 'Halo Tokabe.id, saya tertarik untuk sewa titik Videotron Outdoor (DOOH) strategis di {ITEM_TITLE}. Apakah slot penayangan masih tersedia dan boleh minta penawaran harganya?';
    } elseif (request()->routeIs('ooh.detail') || str_starts_with($currentPath, 'lokasi/ooh')) {
        $pageCategory = 'OOH Detail';
        $badgeTitle = 'Sewa Billboard OOH';
        $tooltipText = 'Tanyakan harga sewa & periode ketersediaan Billboard ini!';
        $messageTemplate = 'Halo Tokabe.id, saya tertarik untuk sewa media Billboard / Baliho (OOH) di titik {ITEM_TITLE}. Boleh minta info rate card dan ketersediaan titiknya?';
    } elseif (str_starts_with($currentPath, 'periklanan/1') || (request()->routeIs('periklanan.show') && request()->route('id') == 1)) {
        $pageCategory = 'Videotron DOOH Medan';
        $badgeTitle = 'Sewa Videotron Medan';
        $tooltipText = 'Cari titik videotron outdoor Medan yang strategis? Tanya ketersediaannya!';
        $messageTemplate = 'Halo Tokabe.id, saya sedang mencari sewa videotron outdoor Medan di titik strategis. Boleh minta informasi katalog titik DOOH yang ready dan rate card-nya?';
    } elseif (str_starts_with($currentPath, 'periklanan/2') || (request()->routeIs('periklanan.show') && request()->route('id') == 2)) {
        $pageCategory = 'Billboard OOH Sumut';
        $badgeTitle = 'Vendor Billboard Sumut';
        $tooltipText = 'Butuh vendor advertising billboard & baliho di Sumatera Utara? Hubungi kami!';
        $messageTemplate = 'Halo Tokabe.id, saya sedang mencari vendor advertising OOH & sewa billboard di Sumatera Utara. Boleh minta info titik lokasi yang tersedia beserta harganya?';
    } elseif (request()->routeIs('brand') || str_starts_with($currentPath, 'showbrand')) {
        $pageCategory = 'Event Management & Brand Activation';
        $badgeTitle = 'Event & Gathering';
        $tooltipText = 'Rencanakan corporate gathering atau brand activation perusahaan Anda bersama kami!';
        $messageTemplate = 'Halo Tokabe.id, saya membutuhkan jasa event management / corporate gathering & brand activation di Medan. Boleh minta katalog portofolio, proposal, dan jadwal diskusinya?';
    } elseif (request()->routeIs('showPhoto') || str_starts_with($currentPath, 'photo-video')) {
        $pageCategory = 'Commercial Photo & Video';
        $badgeTitle = 'Photo & Video Production';
        $tooltipText = 'Butuh video promosi komersial atau dokumentasi profesional? Chat tim kreatif kami!';
        $messageTemplate = 'Halo Tokabe.id, saya tertarik dengan layanan komersial Photo & Video production Tokabe untuk kebutuhan promosi/branding. Boleh info paket dan rate harganya?';
    } elseif (request()->routeIs('portofolio.detail') || str_starts_with($currentPath, 'portofolio/detail')) {
        $pageCategory = 'Portfolio Detail';
        $badgeTitle = 'Diskusi Project Serupa';
        $tooltipText = 'Tertarik membuat campaign atau event seperti project ini? Diskusikan dengan kami!';
        $messageTemplate = 'Halo Tokabe.id, saya melihat portofolio project "{ITEM_TITLE}" di website Tokabe dan tertarik mendiskusikan kampanye/event serupa untuk brand kami.';
    } elseif (request()->routeIs('portofolio*') || str_starts_with($currentPath, 'portofolio')) {
        $pageCategory = 'Portfolio Showcase';
        $badgeTitle = 'Portofolio Tokabe';
        $tooltipText = 'Lihat hasil karya Tokabe dan wujudkan kampanye sukses untuk brand Anda!';
        $messageTemplate = 'Halo Tokabe.id, saya baru saja melihat portofolio Tokabe dan ingin berkonsultasi mengenai rencana kerja sama periklanan untuk perusahaan kami.';
    } elseif (request()->routeIs('contact') || str_starts_with($currentPath, 'contact')) {
        $pageCategory = 'Contact & Support';
        $badgeTitle = 'Respon Cepat Tokabe';
        $tooltipText = 'Ingin penawaran harga cepat tanpa isi form panjang? Langsung chat kami di sini!';
        $messageTemplate = 'Halo Admin Tokabe.id, saya menghubungi dari halaman Kontak website Tokabe untuk menanyakan penawaran harga & kerja sama advertising.';
    } elseif (request()->routeIs('discover') || str_starts_with($currentPath, 'discover')) {
        $pageCategory = 'Discover Map';
        $badgeTitle = 'Peta Titik Reklame';
        $tooltipText = 'Ingin cek titik iklan yang terlihat di peta? Hubungi kami langsung!';
        $messageTemplate = 'Halo Tokabe.id, saya sedang melihat peta titik iklan di halaman Discover Tokabe dan ingin cek ketersediaan titik di wilayah tertentu.';
    } elseif (request()->routeIs('legalitas') || str_starts_with($currentPath, 'legality')) {
        $pageCategory = 'Legalitas Perizinan';
        $badgeTitle = 'Izin & Legalitas Reklame';
        $tooltipText = 'Pemasangan reklame aman, berizin resmi & taat pajak. Konsultasi sekarang!';
        $messageTemplate = 'Halo Tokabe.id, saya ingin konsultasi mengenai aspek legalitas dan perizinan resmi pemasangan media reklame/billboard di Sumatera Utara.';
    }

    $initialWaUrl = "https://api.whatsapp.com/send?phone={$cleanPhone}&text=" . urlencode($messageTemplate);
@endphp

<!-- FLOATING WHATSAPP WIDGET (TOKABE INTERACTIVE CTA) -->
<div id="tokabe-floating-wa-container" 
     class="fixed bottom-6 right-5 sm:right-6 z-50 flex flex-col items-end pointer-events-none select-none"
     data-phone="{{ $cleanPhone }}"
     data-raw-template="{{ $messageTemplate }}"
     data-page-category="{{ $pageCategory }}">

    <!-- Interactive Chat Bubble / Tooltip -->
    <div id="tokabe-wa-tooltip" 
         class="pointer-events-auto opacity-0 translate-y-3 transition-all duration-500 ease-out mb-3 max-w-[270px] sm:max-w-[300px] bg-[#1F140D]/95 backdrop-blur-md text-[#F5EFE7] rounded-2xl p-3.5 shadow-[0_10px_35px_rgba(0,0,0,0.6)] border border-[#D4A574]/40 relative group cursor-pointer hover:border-[#F0C97A] hover:shadow-[0_12px_40px_rgba(212,165,105,0.25)]">
        
        <!-- Close button -->
        <button type="button" 
                id="tokabe-wa-close-btn"
                aria-label="Tutup pesan"
                class="absolute -top-2 -left-2 w-5 h-5 bg-[#2C1A0E] hover:bg-[#D4A574] text-gray-300 hover:text-[#1A0F07] rounded-full border border-white/20 flex items-center justify-center text-[10px] transition-colors duration-200 shadow-md">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- Header: Online indicator -->
        <div class="flex items-center gap-2 mb-1.5">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#25D366] opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#25D366]"></span>
            </span>
            <span class="text-[11px] font-bold uppercase tracking-wider text-[#F0C97A]">
                {{ $badgeTitle }}
            </span>
            <span class="text-[10px] text-gray-400 ml-auto flex items-center gap-1">
                <i class="fa-solid fa-bolt text-[#F0C97A] text-[9px]"></i> Fast
            </span>
        </div>

        <!-- Body text -->
        <p id="tokabe-wa-tooltip-text" class="text-xs text-gray-200 font-medium leading-relaxed m-0">
            {{ $tooltipText }}
        </p>

        <!-- Call to Action Prompt -->
        <div class="mt-2 pt-2 border-t border-white/10 flex items-center justify-between text-[11px] text-[#D4A574] font-semibold group-hover:text-[#F0C97A]">
            <span>Mulai Chat Sekarang</span>
            <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
        </div>

        <!-- Decorative Arrow indicator pointing down to button -->
        <div class="absolute -bottom-2 right-6 w-0 h-0 border-l-[8px] border-l-transparent border-r-[8px] border-r-transparent border-t-[8px] border-t-[#1F140D]/95"></div>
    </div>

    <!-- The Floating Button Link -->
    <a href="{{ $initialWaUrl }}" 
       id="floating-whatsapp-btn"
       target="_blank" 
       rel="noopener noreferrer"
       aria-label="Chat WhatsApp Tokabe.id"
       class="pointer-events-auto relative flex items-center justify-center w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-gradient-to-tr from-[#1EBE5D] via-[#25D366] to-[#4ADE80] text-white shadow-[0_8px_25px_rgba(37,211,102,0.45)] hover:shadow-[0_12px_35px_rgba(37,211,102,0.7)] ring-2 ring-[#D4A574]/50 ring-offset-2 ring-offset-[#1A0F07] transform hover:scale-110 active:scale-95 transition-all duration-300 group"
       data-gtm-event="whatsapp_click"
       data-event-category="Conversion"
       data-event-action="Click Floating WhatsApp"
       data-event-label="{{ $pageCategory }}">

        <!-- Pulse Radar Glow Animation -->
        <span class="absolute -inset-1 rounded-full bg-[#25D366] opacity-35 animate-ping pointer-events-none"></span>

        <!-- Online Badge Indicator -->
        <span class="absolute top-0.5 right-0.5 w-3.5 h-3.5 bg-[#22c55e] border-2 border-[#1A0F07] rounded-full shadow-sm"></span>

        <!-- WhatsApp Icon (SVG for maximum crispness and zero loading delay) -->
        <svg class="w-8 h-8 sm:w-9 sm:h-9 fill-current drop-shadow-md transform group-hover:rotate-12 transition-transform duration-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2zm.01 1.67c4.54 0 8.24 3.7 8.24 8.24 0 2.2-.86 4.28-2.42 5.83a8.18 8.18 0 0 1-5.82 2.41c-1.47 0-2.93-.39-4.21-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24zm4.52 11.64c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.12-.17.25-.64.81-.79.97-.14.17-.29.19-.54.07-.25-.12-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.39-1.72-.14-.25-.02-.38.11-.5.11-.11.25-.29.37-.43.12-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.34-.76-1.84-.2-.49-.4-.42-.56-.43h-.47c-.17 0-.43.06-.66.31-.22.25-.86.84-.86 2.05s.88 2.38 1 2.54c.12.17 1.73 2.64 4.2 3.7 2.46 1.07 2.46.71 2.91.67.44-.05 1.47-.6 1.67-1.18.21-.59.21-1.09.15-1.19-.06-.1-.23-.16-.48-.28z"/>
        </svg>
    </a>
</div>

<!-- CLIENT-SIDE SCRIPT FOR DYNAMIC CONTEXT & GTM TRACKING -->
<script>
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('tokabe-floating-wa-container');
            if (!container) return;

            const tooltip = document.getElementById('tokabe-wa-tooltip');
            const closeBtn = document.getElementById('tokabe-wa-close-btn');
            const waBtn = document.getElementById('floating-whatsapp-btn');
            const phone = container.getAttribute('data-phone') || '628115239999';
            let rawTemplate = container.getAttribute('data-raw-template') || '';
            let pageCategory = container.getAttribute('data-page-category') || 'General';

            // 1. Detect dynamic title/item if we are on a detail page or service page
            let detectedTitle = '';
            const h1Element = document.querySelector('h1');
            if (h1Element) {
                detectedTitle = h1Element.innerText.replace(/\s+/g, ' ').trim();
            }

            if (!detectedTitle) {
                detectedTitle = document.title.replace(/\s*-\s*Tokabe\.id.*$/i, '').trim();
            }

            let resolvedMessage = rawTemplate;
            const pathname = window.location.pathname;

            // Intelligent detection for service pages
            if (pathname.includes('/services') && detectedTitle) {
                const titleLower = detectedTitle.toLowerCase();
                let dynamicMsg = '';
                let dynamicBadge = '';
                let dynamicTooltip = '';

                if (titleLower.includes('videotron') || titleLower.includes('dooh')) {
                    dynamicMsg = 'Halo Tokabe.id, saya tertarik dengan layanan ' + detectedTitle + ' di Medan/Sumatera. Boleh minta info titik videotron strategis, ketersediaan slot tayang, dan penawaran harganya?';
                    dynamicBadge = 'Sewa Videotron DOOH';
                    dynamicTooltip = 'Tanyakan harga sewa & titik strategis Videotron (DOOH) Tokabe!';
                    pageCategory = 'Layanan Videotron DOOH';
                } else if (titleLower.includes('baliho') || titleLower.includes('billboard') || titleLower.includes('ooh')) {
                    dynamicMsg = 'Halo Tokabe.id, saya sedang mencari vendor advertising OOH & sewa billboard di Sumatera Utara. Boleh minta info katalog titik lokasi yang ready beserta harganya?';
                    dynamicBadge = 'Sewa Billboard & Baliho';
                    dynamicTooltip = 'Tanyakan titik billboard & baliho strategis di Sumatera Utara!';
                    pageCategory = 'Layanan Billboard OOH';
                } else if (titleLower.includes('acara') || titleLower.includes('event') || titleLower.includes('merek') || titleLower.includes('brand')) {
                    dynamicMsg = 'Halo Tokabe.id, saya tertarik dengan layanan ' + detectedTitle + ' di Medan. Boleh minta portofolio, proposal event gathering, dan jadwal diskusinya?';
                    dynamicBadge = 'Event & Gathering';
                    dynamicTooltip = 'Rencanakan event gathering & brand activation Anda bersama Tokabe!';
                    pageCategory = 'Layanan Event & Brand Activity';
                } else if (titleLower.includes('foto') || titleLower.includes('video')) {
                    dynamicMsg = 'Halo Tokabe.id, saya tertarik dengan layanan ' + detectedTitle + ' Tokabe untuk kebutuhan promosi/branding. Boleh info paket dan rate harganya?';
                    dynamicBadge = 'Photo & Video Production';
                    dynamicTooltip = 'Tanyakan paket video komersial & fotografi profesional!';
                    pageCategory = 'Layanan Videografi & Fotografi';
                } else if (titleLower.includes('cetak') || titleLower.includes('print')) {
                    dynamicMsg = 'Halo Tokabe.id, saya ingin menanyakan layanan ' + detectedTitle + ' untuk kebutuhan banner/materi promosi perusahaan saya. Boleh minta info daftar harga dan estimasi pengerjaannya?';
                    dynamicBadge = 'Percetakan Digital';
                    dynamicTooltip = 'Cetak materi promosi, spanduk, banner & baliho berkualitas!';
                    pageCategory = 'Layanan Percetakan Digital';
                } else if (pathname === '/services' || pathname === '/services/') {
                    dynamicMsg = 'Halo Tokabe.id, saya sedang melihat katalog layanan periklanan di website Tokabe. Boleh bantu rekomendasikan solusi promosi yang paling efektif untuk bisnis saya?';
                    dynamicBadge = 'Katalog Layanan';
                    dynamicTooltip = 'Bingung memilih media iklan yang tepat? Konsultasi gratis di sini!';
                    pageCategory = 'Katalog Layanan';
                } else {
                    dynamicMsg = 'Halo Tokabe.id, saya tertarik dengan layanan "' + detectedTitle + '" di website Tokabe. Boleh minta penjelasan lebih detail dan penawaran harganya?';
                    dynamicBadge = detectedTitle.length > 24 ? detectedTitle.substring(0, 22) + '...' : detectedTitle;
                    dynamicTooltip = 'Konsultasikan kebutuhan ' + detectedTitle + ' Anda bersama kami!';
                    pageCategory = 'Layanan ' + detectedTitle;
                }

                if (dynamicMsg) {
                    resolvedMessage = dynamicMsg;
                }
                if (dynamicBadge && tooltip) {
                    const badgeEl = tooltip.querySelector('.uppercase');
                    if (badgeEl) badgeEl.innerText = dynamicBadge;
                }
                if (dynamicTooltip) {
                    const tooltipTextEl = document.getElementById('tokabe-wa-tooltip-text');
                    if (tooltipTextEl) tooltipTextEl.innerText = dynamicTooltip;
                }
            } else if (resolvedMessage.includes('{ITEM_TITLE}')) {
                // For DOOH detail, OOH detail, Portfolio detail
                if (detectedTitle && detectedTitle.length > 2) {
                    resolvedMessage = resolvedMessage.replace('{ITEM_TITLE}', '"' + detectedTitle + '"');
                } else {
                    resolvedMessage = resolvedMessage.replace('{ITEM_TITLE}', 'titik strategis ini');
                }
            }

            // Update the WhatsApp link with the final encoded message
            const finalWaUrl = 'https://api.whatsapp.com/send?phone=' + encodeURIComponent(phone) + '&text=' + encodeURIComponent(resolvedMessage);
            waBtn.setAttribute('href', finalWaUrl);
            waBtn.setAttribute('data-event-label', pageCategory);

            // 2. Animate Tooltip appearance after short delay (1.2s)
            const isDismissed = sessionStorage.getItem('tokabe_wa_dismissed');
            if (!isDismissed && tooltip) {
                setTimeout(function() {
                    tooltip.classList.remove('opacity-0', 'translate-y-3');
                    tooltip.classList.add('opacity-100', 'translate-y-0');
                }, 1200);
            }

            // Close button click
            if (closeBtn && tooltip) {
                closeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    tooltip.classList.remove('opacity-100', 'translate-y-0');
                    tooltip.classList.add('opacity-0', 'translate-y-3', 'pointer-events-none');
                    sessionStorage.setItem('tokabe_wa_dismissed', 'true');
                });
            }

            // Clicking the tooltip directly also opens WhatsApp
            if (tooltip) {
                tooltip.addEventListener('click', function(e) {
                    if (e.target.closest('#tokabe-wa-close-btn')) return;
                    waBtn.click();
                });
            }

            // 3. GTM & Analytics Event Dispatcher
            waBtn.addEventListener('click', function() {
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push({
                    event: 'whatsapp_click',
                    event_category: 'Conversion',
                    event_action: 'Click Floating WhatsApp',
                    event_label: pageCategory,
                    page_name: detectedTitle || pageCategory,
                    page_url: window.location.href,
                    target_phone: phone,
                    message_preview: resolvedMessage.substring(0, 80)
                });
            });
        });
    })();
</script>
