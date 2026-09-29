<footer class="w-full bg-[#1A0F07] text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-2xl font-semibold mb-4">Tokabe.id</h3>
                <p class="text-gray-300 leading-relaxed max-w-xl">
                    {{ __('We help your brand stand out with professional DOOH, OOH, video, and photography advertising solutions.') }}
                </p>
            </div>
            <div class="grid grid-cols-2 gap-6 text-gray-300">
                <div>
                    <h4 class="font-semibold mb-3">{{ __('Company') }}</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}#services" class="hover:text-white">{{ __('Services') }}</a></li>
                        <li><a href="{{ route('home') }}#partners" class="hover:text-white">{{ __('Partners') }}</a></li>
                        <!-- <li><a href="#news" class="hover:text-white">{{ __('News') }}</a></li> -->
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-3">{{ __('Contact') }}</h4>
                    <ul class="space-y-2 text-sm">
                        @php
                            $email = isset($globalContact) && $globalContact->email ? $globalContact->email : 'info@tokabe.id';
                            $phone = isset($globalContact) && $globalContact->phone ? $globalContact->phone : '628115239999';
                            $cleanPhoneFooter = preg_replace('/[^0-9]/', '', $phone);
                            if (str_starts_with($cleanPhoneFooter, '0')) {
                                $cleanPhoneFooter = '62' . substr($cleanPhoneFooter, 1);
                            }
                            $location = isset($globalContact) && $globalContact->location ? $globalContact->location : 'Komplek Setia Budi Point No. D-10 Medan, Indonesia';
                        @endphp
                        <li>{{ __('Email:') }} <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $email }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">{{ $email }}</a></li>
                        <li>{{ __('Phone:') }} <a href="https://wa.me/{{ $cleanPhoneFooter }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">+{{ $phone }}</a></li>
                        <li>{{ __('Location:') }} <a href="https://maps.app.goo.gl/m2DKjqNtE15Muzqg6" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">{{ __($location) }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-t border-white/10 mt-10 pt-6 text-sm text-gray-400 flex flex-col sm:flex-row justify-between gap-4">
            <span>© {{ date('Y') }} Tokabe.id. {{ __('All Rights Reserved.') }}</span>
            <span>{{ __('Designed for Indonesian advertising clients.') }}</span>
        </div>
    </div>

    <!-- Floating Interactive WhatsApp Widget with dynamic per-page messaging -->
    <x-floating-whatsapp />
</footer>
