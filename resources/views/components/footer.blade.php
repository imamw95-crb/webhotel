@php
    $footerSettings = [
        'hotel_name' => $settings['hotel_name'] ?? 'The Icon Hotel',
        'address' => $settings['address'] ?? '',
        'phone' => $settings['phone'] ?? '',
        'email' => $settings['email'] ?? '',
        'whatsapp' => $settings['whatsapp'] ?? '',
        'instagram_url' => $settings['instagram_url'] ?? '',
        'copyright_text' => $settings['copyright_text'] ?? 'Copyright 2026',
    ];
@endphp

<footer class="bg-navy-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            {{-- Brand --}}
            <div>
                <h3 class="font-display text-2xl font-bold text-gold-400 mb-4">{{ $footerSettings['hotel_name'] }}</h3>
                <p class="text-gray-400 text-sm leading-relaxed">A 4-star hotel offering an unforgettable stay experience for both business and leisure travelers in the heart of Kuningan.</p>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="font-semibold text-gold-400 mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="#about" class="hover:text-white transition">About Us</a></li>
                    <li><a href="#rooms" class="hover:text-white transition">Our Rooms</a></li>
                    <li><a href="#facilities" class="hover:text-white transition">Facilities</a></li>
                    <li><a href="#explore-spaces" class="hover:text-white transition">Gallery</a></li>
                    <li><a href="#hero" class="hover:text-white transition">Book Now</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="font-semibold text-gold-400 mb-4">Contact Us</h4>
                <ul class="space-y-3 text-sm text-gray-400">
                    @if($footerSettings['address'])
                        <li class="flex items-start gap-2"><i class="fa-solid fa-location-dot mt-1 text-gold-400"></i> {{ $footerSettings['address'] }}</li>
                    @endif
                    @if($footerSettings['phone'])
                        <li class="flex items-center gap-2"><i class="fa-solid fa-phone text-gold-400"></i> {{ $footerSettings['phone'] }}</li>
                    @endif
                    @if($footerSettings['email'])
                        <li class="flex items-center gap-2"><i class="fa-solid fa-envelope text-gold-400"></i> {{ $footerSettings['email'] }}</li>
                    @endif
                </ul>
            </div>

            {{-- Social --}}
            <div>
                <h4 class="font-semibold text-gold-400 mb-4">Follow Us</h4>
                <div class="flex gap-3">
                    @if($footerSettings['whatsapp'])
                        <a href="https://api.whatsapp.com/send?phone={{ $footerSettings['whatsapp'] }}" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-green-500 flex items-center justify-center transition">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    @endif
                    @if($footerSettings['instagram_url'])
                        <a href="{{ $footerSettings['instagram_url'] }}" target="_blank" class="w-10 h-10 rounded-full bg-white/10 hover:bg-pink-500 flex items-center justify-center transition">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    @endif
                </div>
                <p class="text-xs text-gray-500 mt-6">{{ $footerSettings['copyright_text'] }}</p>
            </div>
        </div>
    </div>

    {{-- Bottom bar --}}
    <div class="border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-center text-xs text-gray-500">
            Powered by <span class="text-gold-400">{{ $footerSettings['hotel_name'] }}</span> &copy; {{ date('Y') }}. All rights reserved.
        </div>
    </div>
</footer>
