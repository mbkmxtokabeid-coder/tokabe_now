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
                        <li><a href="#services" class="hover:text-white">{{ __('Services') }}</a></li>
                        <li><a href="#partners" class="hover:text-white">{{ __('Partners') }}</a></li>
                        <li><a href="#news" class="hover:text-white">{{ __('News') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-3">{{ __('Contact') }}</h4>
                    <ul class="space-y-2 text-sm">
                        @php
                            $email = isset($globalContact) && $globalContact->email ? $globalContact->email : 'info@tokabe.id';
                            $phone = isset($globalContact) && $globalContact->phone ? $globalContact->phone : '628115239999';
                            $location = isset($globalContact) && $globalContact->location ? $globalContact->location : '';
                        @endphp
                        <li>Email: {{ $email }}</li>
                        <li>Phone: +{{ $phone }}</li>
                        @if($location)
                            <li class="mt-2"><i class="fas fa-map-marker-alt w-5"></i> {{ $location }}</li>
                        @endif
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
