<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Tokabe.id - Contact Us & Help Center') }}</title>
    <meta name="description" content="{{ __('Hubungi Tokabe.id untuk solusi periklanan OOH, DOOH, dan Event Organizer di Sumatera. Kami siap membantu kampanye marketing bisnis Anda.') }}">
    <meta name="keywords" content="Hubungi Tokabe, Alamat Tokabe Medan, Kontak agensi iklan, Sewa reklame Medan">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ \App\Helpers\SeoHelper::getCanonicalUrl() }}">

    <meta property="og:title" content="{{ __('Tokabe.id - Contact Us & Help Center') }}">
    <meta property="og:description" content="{{ __('Hubungi Tokabe.id untuk solusi periklanan OOH, DOOH, dan Event Organizer di Sumatera. Kami siap membantu kampanye marketing bisnis Anda.') }}">
    <meta property="og:image" content="{{ asset('images/LogoTKB.jpg') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ \App\Helpers\SeoHelper::getCanonicalUrl() }}">
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-T6SH8FXD');</script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" type="image/png" href="{{ asset('images/LogoTKB.png') }}?v=3">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/LogoTKB.png') }}?v=3">
</head>
<body class="bg-[#2C1A0E] antialiased text-[#F5EFE7] font-sans overflow-x-hidden">
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T6SH8FXD"
        height="0" width="0" style="display:none;visibility:hidden">
    </iframe></noscript>
    <x-navbar />

    <main class="min-h-screen pb-20 bg-[#2C1A0E]">
        <!-- Header Hero Section -->
        <div class="bg-gradient-to-br from-[#1A0F07] via-[#2C1A0E] to-[#5C3317] pt-28 sm:pt-36 md:pt-40 pb-12 sm:pb-16 md:pb-24 text-center relative overflow-hidden">
            <!-- Decorative subtle glowing blur circles -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-white opacity-5 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-[#D4A574] opacity-10 blur-3xl"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-white uppercase tracking-tight mb-3 sm:mb-4 drop-shadow-md">
                    {!! __('Contact Us') !!}
                </h1>
                <p class="text-sm sm:text-lg lg:text-xl text-[#F5EFE7] max-w-3xl mx-auto mb-0 font-light leading-relaxed drop-shadow-sm">
                    {{ __('Get in touch with our team for any inquiries about advertising solutions in Medan and Sumatera.') }}
                </p>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="bg-[#2C1A0E] py-20 lg:py-28">
            <div class="max-w-[1100px] mx-auto px-5 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                    
                    <!-- Left Column: Info -->
                    <div class="lg:col-span-5" data-aos="fade-right" data-aos-duration="1000">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#D4A574]/10 border border-[#D4A574]/30 text-[#D4A574] text-xs font-bold rounded-lg uppercase tracking-wider">
                            <i class="far fa-envelope text-xs"></i> {{ __('Contact') }}
                        </span>
                        
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-[#F5EFE7] tracking-tight leading-tight mt-6 mb-4">
                            {{ __('How can we help you today?') }}
                        </h2>
                        
                        <p class="text-base sm:text-lg text-gray-300 font-light leading-relaxed mb-10">
                            {{ __('Our dedicated customer support team is just a message or call away.') }}
                        </p>
                        
                        @php
                            $contactEmail = isset($globalContact) && $globalContact->email ? $globalContact->email : 'info@tokabe.id';
                            $rawPhone = isset($globalContact) && $globalContact->phone ? $globalContact->phone : '628115239999';
                            $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
                            if (str_starts_with($cleanPhone, '0')) {
                                $cleanPhone = '62' . substr($cleanPhone, 1);
                            }
                            $displayPhone = '0811-5239-999';
                            if (isset($globalContact) && $globalContact->phone && $globalContact->phone !== '628115239999') {
                                $displayPhone = $globalContact->phone;
                            }
                        @endphp

                        <div class="flex flex-col gap-6">
                            <!-- Email Details -->
                            <div class="flex items-center gap-4 group">
                                <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $contactEmail }}" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-2xl bg-[#D4A574]/10 flex items-center justify-center text-[#D4A574] shadow-sm border border-[#D4A574]/20 flex-shrink-0 group-hover:bg-[#D4A574] group-hover:text-white transition-all duration-300">
                                    <i class="fas fa-envelope text-lg"></i>
                                </a>
                                <div class="min-w-0 flex-1">
                                    <span class="block text-[11px] text-gray-400 font-bold uppercase tracking-wider">{{ __('Email:') }}</span>
                                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $contactEmail }}" target="_blank" rel="noopener noreferrer" class="block text-sm sm:text-base lg:text-sm xl:text-base font-bold text-[#F5EFE7] hover:text-[#D4A574] transition-colors break-all">{{ $contactEmail }}</a>
                                </div>
                            </div>
                            
                            <!-- Phone Details -->
                            <div class="flex items-center gap-4 group">
                                <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" rel="noopener noreferrer" title="{{ __('Hubungi via WhatsApp / Telepon') }}" class="w-12 h-12 rounded-2xl bg-[#D4A574]/10 flex items-center justify-center text-[#D4A574] shadow-sm border border-[#D4A574]/20 flex-shrink-0 group-hover:bg-[#D4A574] group-hover:text-white transition-all duration-300">
                                    <i class="fas fa-phone-alt text-lg"></i>
                                </a>
                                <div class="min-w-0 flex-1">
                                    <span class="block text-[11px] text-gray-400 font-bold uppercase tracking-wider">{{ __('Phone:') }}</span>
                                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" rel="noopener noreferrer" title="{{ __('Hubungi via WhatsApp / Telepon') }}" class="block text-sm sm:text-base lg:text-sm xl:text-base font-bold text-[#F5EFE7] hover:text-[#D4A574] transition-colors">{{ $displayPhone }}</a>
                                </div>
                            </div>
                            
                            <!-- Location Details -->
                            <div class="flex items-start gap-4 group">
                                <a href="https://maps.app.goo.gl/m2DKjqNtE15Muzqg6" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-2xl bg-[#D4A574]/10 flex items-center justify-center text-[#D4A574] shadow-sm border border-[#D4A574]/20 flex-shrink-0 group-hover:bg-[#D4A574] group-hover:text-white transition-all duration-300 mt-0.5">
                                    <i class="fas fa-map-marker-alt text-lg"></i>
                                </a>
                                <div class="min-w-0 flex-1">
                                    <span class="block text-[11px] text-gray-400 font-bold uppercase tracking-wider">{{ __('Location:') }}</span>
                                    <a href="https://maps.app.goo.gl/m2DKjqNtE15Muzqg6" target="_blank" rel="noopener noreferrer" class="block text-sm sm:text-base lg:text-sm xl:text-base font-bold text-[#F5EFE7] hover:text-[#D4A574] transition-colors leading-snug sm:leading-relaxed break-words">
                                        {!! __('Komplek Setiabudi Point<br>No. D-10 Medan, Indonesia') !!}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column: Form Card -->
                    <div class="lg:col-span-7 lg:mt-14" data-aos="fade-left" data-aos-duration="1000">
                        <div class="bg-[#5C3317]/30 backdrop-blur-md rounded-[2rem] p-6 sm:p-8 lg:p-10 shadow-lg border border-[#8B5E3C]/30">
                            <!-- Keterangan Transparan Pengiriman via WhatsApp -->
                            <div class="mb-6 flex items-start gap-3 p-3.5 bg-[#D4A574]/10 border border-[#D4A574]/30 rounded-2xl text-xs text-[#F5EFE7]">
                                <i class="fa-brands fa-whatsapp text-lg text-[#F0C97A] mt-0.5 flex-shrink-0"></i>
                                <span class="leading-relaxed">
                                    {{ app()->getLocale() == 'en' ? 'Inquiries submitted through this form will directly open a WhatsApp chat with Tokabe Customer Support.' : 'Pesan yang Anda kirimkan melalui formulir ini akan langsung diarahkan ke chat WhatsApp Customer Support Tokabe.' }}
                                </span>
                            </div>

                            <!-- Alert Fallback / Popup Gagal Terbuka (Tautan Manual) -->
                            <div id="wa-fallback-alert" class="hidden mb-6 p-4 bg-amber-500/15 border border-amber-500/40 rounded-2xl text-amber-200 text-xs sm:text-sm animate-fade-in">
                                <div class="flex items-start gap-3">
                                    <i class="fa-solid fa-triangle-exclamation text-amber-400 text-lg mt-0.5 flex-shrink-0"></i>
                                    <div class="flex-1">
                                        <h4 class="font-bold text-amber-300 text-sm mb-1">
                                            {{ app()->getLocale() == 'en' ? 'Popup Blocked by Browser' : 'Popup Otomatis Diblokir Peramban' }}
                                        </h4>
                                        <p class="text-xs text-amber-200/90 leading-relaxed mb-3">
                                            {{ app()->getLocale() == 'en' ? 'Your browser prevented opening WhatsApp automatically. Please use the manual link below:' : 'Browser Anda memblokir pembukaan tab otomatis. Silakan klik tombol di bawah untuk membuka WhatsApp secara manual:' }}
                                        </p>
                                        <a id="wa-manual-link" href="#" target="_blank" rel="noopener noreferrer"
                                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-[#C8902A] via-[#F0C97A] to-[#C8902A] hover:from-[#F0C97A] hover:to-[#C8902A] text-[#2C1A0E] font-bold text-xs uppercase tracking-wider rounded-xl shadow-[0_0_15px_rgba(212,165,105,0.4)] hover:shadow-[0_0_25px_rgba(240,201,122,0.6)] transition-all transform hover:scale-105">
                                            <i class="fa-brands fa-whatsapp text-sm"></i>
                                            <span>{{ app()->getLocale() == 'en' ? 'Open WhatsApp Manually' : 'Buka WhatsApp Secara Manual' }}</span>
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                        </a>
                                    </div>
                                    <button type="button" id="close-wa-fallback" class="text-amber-400/80 hover:text-amber-200 p-1 text-base leading-none">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                            </div>

                            <form id="contact-form" data-phone="{{ $cleanPhone }}">
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                                    <div>
                                        <label for="name" class="block text-xs font-bold text-gray-200 mb-1.5 uppercase tracking-wide">{{ __('Name*') }}</label>
                                        <input type="text" id="name" required placeholder="{{ __('e.g. Budi Santoso') }}" 
                                            class="w-full px-4 py-3 bg-[#1A0F07]/50 border border-[#8B5E3C]/30 rounded-xl focus:ring-2 focus:ring-[#D4A574]/30 focus:border-[#D4A574] outline-none transition-all placeholder-gray-500 text-[#F5EFE7] text-sm font-medium">
                                    </div>
                                    <div>
                                        <label for="company" class="block text-xs font-bold text-gray-200 mb-1.5 uppercase tracking-wide">{{ __('Company*') }}</label>
                                        <input type="text" id="company" required placeholder="{{ __('e.g. PT Jaya Abadi') }}" 
                                            class="w-full px-4 py-3 bg-[#1A0F07]/50 border border-[#8B5E3C]/30 rounded-xl focus:ring-2 focus:ring-[#D4A574]/30 focus:border-[#D4A574] outline-none transition-all placeholder-gray-500 text-[#F5EFE7] text-sm font-medium">
                                    </div>
                                </div>
                                
                                <div class="mb-6">
                                    <label for="message" class="block text-xs font-bold text-gray-200 mb-1.5 uppercase tracking-wide">{{ __('Message*') }}</label>
                                    <textarea name="message" id="message" required rows="4" placeholder="{{ __('Enter a question, feedback, or suggestions...') }}" 
                                        class="w-full px-4 py-3 bg-[#1A0F07]/50 border border-[#8B5E3C]/30 rounded-xl focus:ring-2 focus:ring-[#D4A574]/30 focus:border-[#D4A574] outline-none transition-all placeholder-gray-500 text-[#F5EFE7] text-sm font-medium resize-none leading-relaxed"></textarea>
                                </div>

                                <button type="submit" id="submit-btn" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-3.5 bg-gradient-to-r from-[#C8902A] via-[#F0C97A] to-[#C8902A] hover:from-[#F0C97A] hover:to-[#C8902A] text-[#2C1A0E] font-bold rounded-xl shadow-[0_0_15px_rgba(212,165,105,0.4)] hover:shadow-[0_0_25px_rgba(240,201,122,0.6)] transform hover:scale-105 active:scale-95 transition-all duration-300 uppercase tracking-wider text-xs sm:text-sm disabled:opacity-70 disabled:cursor-not-allowed">
                                    <span id="btn-icon"><i class="fa-brands fa-whatsapp text-lg"></i></span>
                                    <span id="btn-text">{{ app()->getLocale() == 'en' ? 'Send via WhatsApp' : 'Kirim via WhatsApp' }}</span>
                                </button>
                            </form>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="bg-[#2C1A0E] border-t border-[#8B5E3C]/20 py-20 lg:py-28">
            <div class="max-w-[1100px] mx-auto px-5 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
                    
                    <!-- FAQ Left Column -->
                    <div class="lg:col-span-5" data-aos="fade-right" data-aos-duration="1000">
                        <h2 class="text-3xl sm:text-4xl font-black text-[#F5EFE7] tracking-tight leading-tight mb-4">
                            {{ __('Frequently asked question (FAQ)') }}
                        </h2>
                        
                        <p class="text-base sm:text-lg text-gray-300 font-light leading-relaxed mb-8">
                            {{ __('Got questions about our services? We\'ve got answers!') }}
                        </p>
                        
                        <a href="https://api.whatsapp.com/send/?phone=628115239999&text=Halo%20Admin" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#C8902A] via-[#F0C97A] to-[#C8902A] hover:from-[#F0C97A] hover:to-[#C8902A] text-[#2C1A0E] font-bold text-sm uppercase tracking-wider rounded-xl shadow-[0_0_15px_rgba(212,165,105,0.4)] hover:shadow-[0_0_25px_rgba(240,201,122,0.6)] transform hover:scale-105 transition-all duration-300">
                            {{ __('Help Center') }} <i class="fas fa-external-link-alt text-xs"></i>
                        </a>
                    </div>
                    
                    <!-- FAQ Right Column (Accordion) -->
                    <div class="lg:col-span-7" data-aos="fade-left" data-aos-duration="1000">
                        <div class="flex flex-col">
                            
                            @foreach($faqs as $faq)
                            <div class="faq-item border border-[#8B5E3C]/30 rounded-2xl bg-[#5C3317]/30 backdrop-blur-md shadow-sm overflow-hidden mb-4 transition-all duration-300">
                                <button class="faq-btn w-full px-6 py-5 flex justify-between items-center text-left text-[#F5EFE7] hover:text-[#D4A574] transition-colors font-semibold text-sm sm:text-base gap-4 focus:outline-none">
                                    <span>{{ app()->getLocale() == 'en' ? $faq->question_en : $faq->question_id }}</span>
                                    <svg class="faq-icon w-5 h-5 text-[#D4A574] transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                                <div class="faq-panel max-h-0 opacity-0 overflow-hidden transition-all duration-500 ease-in-out">
                                    <div class="px-6 pb-5 text-xs sm:text-sm text-gray-300 leading-relaxed font-light">
                                        {{ app()->getLocale() == 'en' ? $faq->answer_en : $faq->answer_id }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </main>

    <x-footer />



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Form logic to WhatsApp with loading state and popup blocker fallback
            const form = document.getElementById('contact-form');
            const submitBtn = document.getElementById('submit-btn');
            const btnIcon = document.getElementById('btn-icon');
            const btnText = document.getElementById('btn-text');
            const fallbackAlert = document.getElementById('wa-fallback-alert');
            const manualLink = document.getElementById('wa-manual-link');
            const closeFallback = document.getElementById('close-wa-fallback');

            if (closeFallback && fallbackAlert) {
                closeFallback.addEventListener('click', function() {
                    fallbackAlert.classList.add('hidden');
                });
            }

            if (form) {
                const targetPhone = form.getAttribute('data-phone') || '628115239999';
                const originalText = btnText ? btnText.innerText : 'Kirim via WhatsApp';
                const originalIcon = btnIcon ? btnIcon.innerHTML : '<i class="fa-brands fa-whatsapp text-lg"></i>';

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const name = document.getElementById('name').value.trim();
                    const company = document.getElementById('company').value.trim();
                    const message = document.getElementById('message').value.trim();

                    if (!name || !company || !message) {
                        return;
                    }

                    // 1. Loading State
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        if (btnIcon) btnIcon.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-lg"></i>';
                        if (btnText) btnText.innerText = '{{ app()->getLocale() == "en" ? "Opening WhatsApp..." : "Membuka WhatsApp..." }}';
                    }

                    let text = `Halo Admin Tokabe,\n\n`;
                    text += `Saya ingin mengirimkan pesan dari halaman kontak website.\n\n`;
                    text += `*Nama:* ${name}\n`;
                    text += `*Perusahaan:* ${company}\n`;
                    text += `*Pesan:* ${message}`;
                    
                    const waUrl = `https://api.whatsapp.com/send?phone=${encodeURIComponent(targetPhone)}&text=${encodeURIComponent(text)}`;
                    
                    // 2. Open WhatsApp window & detect popup blocker
                    let popupWindow = null;
                    try {
                        popupWindow = window.open(waUrl, '_blank');
                    } catch (err) {
                        popupWindow = null;
                    }

                    // 3. Fallback check & reset button state
                    setTimeout(function() {
                        const isBlocked = !popupWindow || popupWindow.closed || typeof popupWindow.closed === 'undefined';
                        
                        if (isBlocked) {
                            if (manualLink) {
                                manualLink.href = waUrl;
                            }
                            if (fallbackAlert) {
                                fallbackAlert.classList.remove('hidden');
                                fallbackAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                            }
                        } else {
                            if (fallbackAlert) {
                                fallbackAlert.classList.add('hidden');
                            }
                        }

                        // Restore button state
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            if (btnIcon) btnIcon.innerHTML = originalIcon;
                            if (btnText) btnText.innerText = originalText;
                        }
                    }, 650);
                });
            }

            // FAQ accordion logic
            const faqItems = document.querySelectorAll('.faq-item');
            faqItems.forEach(item => {
                const btn = item.querySelector('.faq-btn');
                const panel = item.querySelector('.faq-panel');
                const icon = item.querySelector('.faq-icon');
                
                btn.addEventListener('click', function() {
                    const isOpen = !panel.classList.contains('max-h-0');
                    
                    // Close all other FAQs first
                    faqItems.forEach(otherItem => {
                        const otherPanel = otherItem.querySelector('.faq-panel');
                        const otherIcon = otherItem.querySelector('.faq-icon');
                        otherPanel.classList.remove('max-h-[300px]', 'opacity-100', 'mt-2');
                        otherPanel.classList.add('max-h-0', 'opacity-0');
                        otherIcon.classList.remove('rotate-45', 'text-[#F0C97A]');
                        otherItem.classList.remove('border-[#D4A574]/40', 'bg-[#5C3317]/60');
                    });
                    
                    // Toggle current FAQ
                    if (!isOpen) {
                        panel.classList.remove('max-h-0', 'opacity-0');
                        panel.classList.add('max-h-[300px]', 'opacity-100', 'mt-2');
                        icon.classList.add('rotate-45', 'text-[#F0C97A]');
                        item.classList.add('border-[#D4A574]/40', 'bg-[#5C3317]/60');
                    }
                });
            });
            
            // Open the first FAQ item by default to match mockup
            if (faqItems.length > 0) {
                const firstItem = faqItems[0];
                const btn = firstItem.querySelector('.faq-btn');
                btn.click();
            }
        });
    </script>
</body>
</html>
