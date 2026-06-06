{{-- ============================================================
   PARTIAL: FOOTER — The Icon Hotel Kuningan
   ============================================================ --}}

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

<footer class="site-footer reveal">
    <div class="section-container">
        <div class="footer-grid">
            {{-- Brand --}}
            <div class="footer-brand">
                <h3 class="footer-logo">{{ $footerSettings['hotel_name'] }}</h3>
                <p class="footer-desc">A 4-star hotel offering an unforgettable stay experience for both business and leisure travelers in the heart of Kuningan.</p>
            </div>

            {{-- Quick Links --}}
            <div class="footer-col">
                <h4 class="footer-heading">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#rooms">Our Rooms</a></li>
                    <li><a href="#facilities">Facilities</a></li>
                    <li><a href="#explore-spaces">Gallery</a></li>
                    <li><a href="#hero">Book Now</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="footer-col">
                <h4 class="footer-heading">Contact Us</h4>
                <ul class="footer-contact">
                    @if($footerSettings['address'])
                        <li><i class="fa-solid fa-location-dot"></i> {{ $footerSettings['address'] }}</li>
                    @endif
                    @if($footerSettings['phone'])
                        <li><i class="fa-solid fa-phone"></i> {{ $footerSettings['phone'] }}</li>
                    @endif
                    @if($footerSettings['email'])
                        <li><i class="fa-solid fa-envelope"></i> {{ $footerSettings['email'] }}</li>
                    @endif
                </ul>
            </div>

            {{-- Social --}}
            <div class="footer-col">
                <h4 class="footer-heading">Follow Us</h4>
                <div class="footer-social">
                    @if($footerSettings['whatsapp'])
                        <a href="https://api.whatsapp.com/send?phone={{ $footerSettings['whatsapp'] }}" target="_blank" class="social-link" aria-label="WhatsApp">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                    @endif
                    @if($footerSettings['instagram_url'])
                        <a href="{{ $footerSettings['instagram_url'] }}" target="_blank" class="social-link" aria-label="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    @endif
                </div>
                <p class="footer-copy">{{ $footerSettings['copyright_text'] }}</p>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="footer-bottom">
        <div class="section-container">
            <p>Powered by <span class="footer-brand-name">{{ $footerSettings['hotel_name'] }}</span> &copy; {{ date('Y') }}. All rights reserved.</p>
        </div>
    </div>
</footer>

