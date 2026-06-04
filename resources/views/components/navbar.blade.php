@php
    $navSettings = [
        'hotel_name' => $settings['hotel_name'] ?? config('app.name', 'The Icon Hotel'),
        'phone' => $settings['phone'] ?? '',
        'whatsapp' => $settings['whatsapp'] ?? '',
        'instagram_url' => $settings['instagram_url'] ?? '',
    ];
@endphp

<nav x-data="{ scrolled: false, mobileOpen: false }"
     @scroll.window="scrolled = window.scrollY > 50"
     :class="scrolled ? 'bg-navy-900/95 backdrop-blur-md shadow-lg py-2' : 'bg-navy-900/80 backdrop-blur-sm py-4'"
     class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 text-white">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 group">
                <img src="{{ asset('storage/' . ($settings['logo_path'] ?? 'logo/icon.png')) }}"
                     onerror="this.style.display='none'"
                     class="h-10 w-auto rounded-lg object-cover shadow-lg group-hover:shadow-gold-400/20 transition-shadow"
                     alt="{{ $navSettings['hotel_name'] }}">
                <span class="font-display text-xl md:text-2xl font-bold text-gold-400 group-hover:text-gold-300 transition">{{ $navSettings['hotel_name'] }}</span>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden lg:flex items-center gap-6">
                <a href="#hero" class="text-sm font-medium hover:text-gold-400 transition">Home</a>
                <a href="#about" class="text-sm font-medium hover:text-gold-400 transition">About</a>
                <a href="#rooms" class="text-sm font-medium hover:text-gold-400 transition">Rooms</a>
                <a href="#facilities" class="text-sm font-medium hover:text-gold-400 transition">Facilities</a>
                <a href="#explore-spaces" class="text-sm font-medium hover:text-gold-400 transition">Gallery</a>
                <a href="#contact" class="text-sm font-medium hover:text-gold-400 transition">Contact</a>
                <a href="{{ route('booking.track') }}" class="text-sm font-medium hover:text-gold-400 transition flex items-center gap-1">
                    <i class="fa-regular fa-rectangle-list"></i> My Booking
                </a>
                <a href="/" class="bg-gold-400 hover:bg-gold-500 text-navy-900 font-semibold px-5 py-2 rounded-full text-sm transition flex items-center gap-1.5">
                    <i class="fa-solid fa-calendar-check"></i> Book Now
                </a>
            </div>

            {{-- Social Icons --}}
            <div class="hidden lg:flex items-center gap-3">
                @if($navSettings['whatsapp'])
                    <a href="https://api.whatsapp.com/send?phone={{ $navSettings['whatsapp'] }}" target="_blank" class="w-8 h-8 rounded-full bg-white/10 hover:bg-green-500 flex items-center justify-center transition">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                    </a>
                @endif
                @if($navSettings['instagram_url'])
                    <a href="{{ $navSettings['instagram_url'] }}" target="_blank" class="w-8 h-8 rounded-full bg-white/10 hover:bg-pink-500 flex items-center justify-center transition">
                        <i class="fa-brands fa-instagram text-sm"></i>
                    </a>
                @endif
            </div>

            {{-- Mobile Toggle --}}
            <button @click="mobileOpen = !mobileOpen" class="lg:hidden text-white">
                <i :class="mobileOpen ? 'fa-xmark' : 'fa-bars'" class="fa-solid text-xl"></i>
            </button>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileOpen" x-cloak x-transition class="lg:hidden mt-4 pb-4 border-t border-white/10 pt-4 space-y-3">
            <a href="#hero" @click="mobileOpen = false" class="block py-2 hover:text-gold-400">Home</a>
            <a href="#about" @click="mobileOpen = false" class="block py-2 hover:text-gold-400">About</a>
            <a href="#rooms" @click="mobileOpen = false" class="block py-2 hover:text-gold-400">Rooms</a>
            <a href="#facilities" @click="mobileOpen = false" class="block py-2 hover:text-gold-400">Facilities</a>
            <a href="#explore-spaces" @click="mobileOpen = false" class="block py-2 hover:text-gold-400">Gallery</a>
            <a href="#contact" @click="mobileOpen = false" class="block py-2 hover:text-gold-400">Contact</a>
            <a href="{{ route('booking.track') }}" @click="mobileOpen = false" class="block py-2 hover:text-gold-400"><i class="fa-regular fa-rectangle-list"></i> My Booking</a>
            <a href="/" @click="mobileOpen = false" class="block bg-gold-400 text-navy-900 font-semibold px-5 py-2 rounded-full text-center mt-3"><i class="fa-solid fa-calendar-check mr-1"></i> Book Now</a>
        </div>
    </div>
</nav>
