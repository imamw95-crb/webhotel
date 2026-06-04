@extends('layouts.app')

@section('content')

{{-- ============================================ --}}
{{-- AVAILABILITY RESULTS (shown after search) --}}
{{-- ============================================ --}}
<section id="av-results-section" class="section-padding" style="padding-bottom:0;">
    <div class="section-container">
        <div id="av-results" class="av-results" style="display:none;">
            <div class="av-results-header">
                <i class="fa-solid fa-building"></i>
                <span id="av-results-title">Checking availability...</span>
            </div>
            <div id="av-results-types" class="av-results-types"></div>
        </div>
    </div>
</section>

{{-- ============================================ --}}
{{-- ABOUT SECTION --}}
{{-- ============================================ --}}
@include('partials.about')

{{-- ============================================ --}}
{{-- ROOMS SECTION --}}
{{-- ============================================ --}}
@include('partials.rooms')

{{-- ============================================ --}}
{{-- FACILITIES SECTION --}}
{{-- ============================================ --}}
@include('partials.facilities')



{{-- ============================================ --}}
{{-- EXPLORE OUR SPACES SECTION --}}
{{-- ============================================ --}}
<section id="explore-spaces" class="section-padding">
    <div class="section-container">
        <div class="text-center mb-16 reveal">
            <span class="sec-label">{{ $sections['gallery_intro']['subtitle'] ?? 'Discover' }}</span>
            <h2 class="section-title">Explore Our Spaces</h2>
            <div class="gold-line centered"></div>
        </div>

        @php
            $spaceCategories = $galleryImages->count() > 0
                ? $galleryImages->groupBy('category')
                : collect([]);
        @endphp

        @if($spaceCategories->count() > 0)
            <div id="spaces-grid" class="spaces-grid stagger">
                @foreach($spaceCategories as $cat => $imgs)
                    @php
                        $first = $imgs->first();
                        $count = $imgs->count();
                        $photoData = $imgs->map(fn($i) => [
                            'src' => asset('storage/' . $i->image_path),
                            'title' => $i->title,
                        ]);
                    @endphp
                    <div class="space-card"
                         data-category="{{ $cat }}"
                         data-photos='{{ json_encode($photoData) }}'>
                        <div class="space-card-inner">
                            <img src="{{ asset('storage/' . $first->image_path) }}"
                                 alt="{{ $cat }}"
                                 class="space-card-img"
                                 loading="lazy">
                            <div class="space-card-overlay">
                                <div class="space-card-content">
                                    <span class="space-card-count">{{ $count }} {{ $count === 1 ? 'Photo' : 'Photos' }}</span>
                                    <h3 class="space-card-title">{{ $cat }}</h3>
                                    <span class="space-card-btn">
                                        Explore <i class="fa-solid fa-arrow-right"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Hidden carousel modal --}}
            <div id="space-carousel" class="space-carousel" role="dialog" aria-modal="true">
                <div class="sc-backdrop"></div>
                <button class="sc-close" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                <button class="sc-nav sc-prev" aria-label="Previous"><i class="fa-solid fa-chevron-left"></i></button>
                <button class="sc-nav sc-next" aria-label="Next"><i class="fa-solid fa-chevron-right"></i></button>
                <div class="sc-main">
                    <div class="sc-counter"></div>
                    <img class="sc-image" src="" alt="">
                    <div class="sc-caption"></div>
                </div>
                <div class="sc-thumbs"></div>
            </div>
        @else
            {{-- Fallback: static categories --}}
            @php
                $fallbackCategories = [
                    'Deluxe'     => ['img' => 'room-types/deluxe/IMG_20260302_144057.jpg', 'count' => 5],
                    'Executive'  => ['img' => 'room-types/executive/IMG_20260315_154622_380.jpg', 'count' => 24],
                    'Family'     => ['img' => 'room-types/family-107/IMG_20260312_134525_513.jpg', 'count' => 12],
                    'Superior'   => ['img' => 'room-types/superior-109/IMG_20260315_124433_350.jpg', 'count' => 6],
                    'Junior'     => ['img' => 'room-types/junior/junior-205/IMG_20260302_092144_155@1865609329.jpg', 'count' => 9],
                    'Swimming Pool' => ['img' => 'gallery/swimming-pool/ChatGPT Image May 28, 2026, 10_25_33 AM.png', 'count' => 1],
                    'Fitness'    => ['img' => 'gallery/fitness-gym/IMG_20260315_150318_768.jpg', 'count' => 6],
                    'Garden'     => ['img' => 'gallery/garden/IMG_20260315_132458_725.jpg', 'count' => 12],
                    'Lobby'      => ['img' => 'gallery/lobby/IMG_20260315_123014_195.jpg', 'count' => 5],
                    'Resto'      => ['img' => 'gallery/resto/ChatGPT Image Apr 1, 2026, 10_25_51 AM.jpg', 'count' => 12],
                    'Stone Terrace' => ['img' => 'gallery/stone-terrace/IMG_20260227_115235_059.jpg', 'count' => 3],
                    'Depan Hotel' => ['img' => 'gallery/depan-hotel/IMG_20260315_191002_644.jpg', 'count' => 27],
                    'Tampak Depan' => ['img' => 'gallery/tampak-depan/IMG_20260302_093513_414@-249047492.jpg', 'count' => 3],
                ];
            @endphp
            <div id="spaces-grid" class="spaces-grid stagger">
                @foreach($fallbackCategories as $cat => $data)
                    <div class="space-card" data-category="{{ $cat }}">
                        <div class="space-card-inner">
                            <img src="{{ asset('storage/' . $data['img']) }}"
                                 alt="{{ $cat }}"
                                 class="space-card-img"
                                 loading="lazy">
                            <div class="space-card-overlay">
                                <div class="space-card-content">
                                    <span class="space-card-count">{{ $data['count'] }} Photos</span>
                                    <h3 class="space-card-title">{{ $cat }}</h3>
                                    <span class="space-card-btn">
                                        Explore <i class="fa-solid fa-arrow-right"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ============================================ --}}
{{-- LOCATION & CONTACT SECTION --}}
{{-- ============================================ --}}
<section id="contact" class="section-padding">
    <div class="section-container">
        <div class="contact-layout">
            {{-- Contact Info --}}
            <div class="reveal-left">
                <span class="sec-label">{{ $sections['contact']['subtitle'] ?? 'Contact' }}</span>
                <h2 class="section-title">{{ $sections['contact']['title'] ?? 'Get In Touch' }}</h2>
                <div class="gold-line"></div>
                <p class="contact-desc">{{ $sections['contact']['content']['description'] ?? '' }}</p>

                <div class="contact-list">
                    @if($settings['address'] ?? false)
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fa-solid fa-location-dot"></i></div>
                            <div>
                                <p class="contact-item-label">Address</p>
                                <p class="contact-item-text">{{ $settings['address'] }}</p>
                            </div>
                        </div>
                    @endif
                    @if($settings['phone'] ?? false)
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fa-solid fa-phone"></i></div>
                            <div>
                                <p class="contact-item-label">Phone</p>
                                <p class="contact-item-text">{{ $settings['phone'] }}</p>
                            </div>
                        </div>
                    @endif
                    @if($settings['email'] ?? false)
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fa-solid fa-envelope"></i></div>
                            <div>
                                <p class="contact-item-label">Email</p>
                                <p class="contact-item-text">{{ $settings['email'] }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Map --}}
                @php $mapEmbed = $sections['location']['content']['map_embed'] ?? ''; @endphp
                @if($mapEmbed)
                    <div class="mt-8 rounded-2xl overflow-hidden shadow-lg">
                        <iframe src="{{ $mapEmbed }}" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                @endif
            </div>

            {{-- Contact Form --}}
            <div class="reveal-right contact-form-wrap">
                <h3 class="contact-form-title">Send Us a Message</h3>

                @if(session('success'))
                    <div class="alert-success">
                        <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    {{-- Honeypot --}}
                    <div style="position:absolute;left:-9999px" aria-hidden="true">
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="form-input" placeholder="Your name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="form-input" placeholder="your@email.com">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="+62 8xx-xxxx-xxxx">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" value="{{ old('subject') }}" class="form-input" placeholder="Booking inquiry">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Message *</label>
                        <textarea name="message" rows="5" required class="form-input form-textarea" placeholder="Tell us what you need...">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn-gold form-submit">
                        <i class="fa-solid fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* ---- Contact ---- */
.contact-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px;
    align-items: start;
}

.contact-desc {
    font-size: 15px;
    color: var(--text-secondary);
    line-height: 1.7;
    margin: 0 0 var(--space-xl);
}

.contact-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 16px;
}

.contact-icon {
    width: 48px;
    height: 48px;
    background: rgba(201, 168, 76, 0.1);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gold-primary);
    font-size: 18px;
    flex-shrink: 0;
}

.contact-item-label {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 2px;
}

.contact-item-text {
    font-size: 14px;
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.5;
}

/* ---- Contact Form ---- */
.contact-form-wrap {
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    border-radius: var(--radius-lg);
    padding: 36px;
}

.contact-form-title {
    font-family: var(--font-display);
    font-size: 26px;
    font-weight: 400;
    color: var(--text-primary);
    margin: 0 0 var(--space-lg);
}

.alert-success {
    padding: 14px 18px;
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.2);
    border-radius: var(--radius-md);
    color: #4ade80;
    margin-bottom: var(--space-lg);
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 16px;
}

.form-group {
    margin-bottom: 16px;
}

.form-row .form-group {
    margin-bottom: 0;
}

.form-label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: var(--text-secondary);
    margin-bottom: 6px;
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    background: var(--bg-surface-2);
    border: 1px solid var(--border-default);
    border-radius: var(--radius-md);
    color: var(--text-primary);
    font-family: var(--font-body);
    font-size: 14px;
    outline: none;
    transition: border-color 0.3s ease;
}

.form-input:focus {
    border-color: var(--gold-primary);
}

.form-input::placeholder {
    color: var(--text-muted);
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
}

.form-submit {
    width: 100%;
    margin-top: 8px;
}

/* ---- Responsive ---- */
@media (max-width: 1024px) {
    .contact-layout {
        grid-template-columns: 1fr;
        gap: 40px;
    }

}

@media (max-width: 640px) {
    .form-row {
        grid-template-columns: 1fr;
    }

    .contact-form-wrap {
        padding: 24px;
    }
}
</style>
@endpush
