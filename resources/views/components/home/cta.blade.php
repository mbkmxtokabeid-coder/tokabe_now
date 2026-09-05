<section id="cta-section" class="py-10 lg:py-16 bg-[#2C1A0E] relative overflow-hidden border-t border-white/5">
    @php
        $globalContact = \App\Models\Contact::first();
        $ctaPhone = isset($globalContact) && $globalContact->phone ? $globalContact->phone : '628115239999';
        $ctaMessage = urlencode("Halo, saya tertarik untuk memulai kampanye periklanan dengan Tokabe.id");
    @endphp

    <!-- Dekorasi background ringan -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-[#D4A574] opacity-5 blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 rounded-full bg-white opacity-5 blur-[100px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-12 lg:gap-8 xl:gap-20">
            
            <!-- Left Side: Content -->
            <div class="w-full lg:w-1/2 text-left">
                <h2 class="text-3xl md:text-5xl lg:text-4xl xl:text-5xl font-black text-white leading-[1.15] mb-6 lg:mb-4 xl:mb-6 tracking-tight">
                    Mulai Kampanye <br class="hidden sm:block"/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#D4A574] to-[#F0C97A]">Periklanan Anda</span>
                </h2>
                <p class="text-gray-400 text-base md:text-lg lg:text-sm xl:text-lg mb-10 lg:mb-6 xl:mb-10 leading-relaxed max-w-lg">
                    Lebih dari sekadar iklan. Kami menciptakan pengalaman visual yang tak terlupakan melalui Videotron DOOH, Billboard, dan Aktivasi Merek di seluruh Sumatera. Konsultasikan kebutuhan Anda sekarang.
                </p>
                
                <div class="flex flex-wrap items-center gap-4">
                    <a href="https://drive.google.com/file/d/1tjBPWl-gIRPUJhSGqP3-ZdFsq_hXCkOI/view?usp=sharing" target="_blank" rel="noopener noreferrer" id="btn-compro-cta" data-gtm-event="download_company_profile" class="px-8 py-3.5 lg:px-5 lg:py-2.5 xl:px-8 xl:py-3.5 lg:text-sm xl:text-base bg-gradient-to-r from-[#C8902A] via-[#F0C97A] to-[#C8902A] text-[#1F1611] font-extrabold rounded-full shadow-[0_0_15px_rgba(212,165,105,0.6)] hover:shadow-[0_0_25px_rgba(240,201,122,0.8)] hover:from-[#F0C97A] hover:to-[#C8902A] transform hover:-translate-y-1 hover:scale-105 transition-all duration-300 flex items-center gap-2">
                        <i class="fa-solid fa-file-pdf"></i> Company Profile
                    </a>
                    <a href="{{ route('portofolio') }}" class="px-8 py-3.5 lg:px-5 lg:py-2.5 xl:px-8 xl:py-3.5 lg:text-sm xl:text-base bg-transparent border border-gray-500 text-gray-300 font-bold rounded-full hover:border-[#F0C97A] hover:text-[#F0C97A] hover:-translate-y-1 transition-all duration-300">
                        Lihat Portofolio
                    </a>
                </div>
            </div>

            <!-- Right Side: Graphic/Card -->
            <div class="w-full lg:w-1/2 flex justify-end">
                <div class="w-full max-w-lg bg-[#F5EFE7] rounded-3xl shadow-2xl relative group overflow-hidden border border-[#D4A574]/20 @if(!isset($globalContact) || !$globalContact->cta_image) p-10 md:p-16 @endif">
                    <!-- Subtle hover gradient inside card -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-[#D4A574]/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 z-20"></div>
                    
                    <div class="aspect-[4/3] flex flex-col items-center justify-center relative z-10 w-full">
                        @if(isset($globalContact) && $globalContact->cta_image)
                            <img src="{{ Storage::url($globalContact->cta_image) }}" alt="Tokabe Advertising" loading="lazy" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="relative">
                                <div class="absolute -inset-4 bg-[#D4A574]/20 rounded-full blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                                <i class="fa-solid fa-bullseye text-8xl md:text-[140px] text-[#2C1A0E] group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500 relative z-10 drop-shadow-xl"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>