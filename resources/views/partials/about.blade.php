{{-- ============================================================
   PARTIAL: ABOUT — The Icon Hotel Kuningan
   ============================================================ --}}

<section id="about" class="section-padding about-section">
    <div class="section-container">
        <div class="about-layout">
            {{-- Left Column: Image + Floating Stats --}}
            <div class="about-left reveal-left">
                <div class="about-image-frame">
                    <div class="about-image-wrap">
                        <img src="{{ asset('storage/room-types/executive/IMG_20260315_154656_154.jpg') }}"
                             alt="The Icon Hotel Kuningan"
                             class="about-image"
                             loading="lazy"
                             onerror="this.parentElement.classList.add('no-img')">
                    </div>

                    {{-- Floating Stat Cards --}}
                    @php
                        $stats = $sections['about']['content']['stats'] ?? [
                            ['label' => 'Rooms', 'value' => 29],
                            ['label' => 'Room Types', 'value' => 6],
                            ['label' => 'Facilities', 'value' => 9],
                            ['label' => 'Staff', 'value' => 24],
                        ];
                    @endphp
                    <div class="about-floating-stats">
                        @foreach(array_slice($stats, 0, 2) as $stat)
                            <div class="about-stat-card glass">
                                <span class="about-stat-num">{{ $stat['value'] }}</span>
                                <span class="about-stat-label">{{ $stat['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right Column: Content + Counters --}}
            <div class="about-right reveal-right">
                <span class="sec-label">{{ $sections['about']['subtitle'] ?? 'About Us' }}</span>
                <h2 class="section-title">{{ $sections['about']['title'] ?? 'The Icon Hotel Kuningan' }}</h2>
                <div class="gold-line"></div>

                <p class="about-text">
                    {{ $sections['about']['content']['description'] ?? 'The Icon Hotel is a 4-star hotel that offers an unforgettable stay experience for both business and leisure travelers in the heart of Kuningan.' }}
                </p>
                <p class="about-text about-text-secondary">
                    {{ $sections['about']['content']['description_2'] ?? 'With modern amenities, exceptional service, and a prime location, we ensure every moment of your stay is nothing short of extraordinary.' }}
                </p>

                {{-- Stat Counters --}}
                <div class="about-counters">
                    @foreach($stats as $stat)
                        <div class="about-counter">
                            <span class="count-num about-counter-num" data-target="{{ is_string($stat['value']) ? preg_replace('/[^0-9]/', '', $stat['value']) : $stat['value'] }}">0</span>
                            <span class="about-counter-label">{{ $stat['label'] }}</span>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="btn-gold" onclick="window.openBookingModal ? window.openBookingModal() : null">Book Now <i class="fa-solid fa-calendar-check"></i></button>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
/* ---- About Section ---- */
.about-section {
    background: var(--bg-page);
}

.about-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px;
    align-items: center;
}

/* ---- Left: Image ---- */
.about-image-frame {
    position: relative;
}

.about-image-wrap {
    border-radius: var(--radius-lg);
    overflow: hidden;
    position: relative;
    border: 1px solid var(--border-default);
}

.about-image-wrap::before {
    content: '';
    position: absolute;
    inset: -2px;
    border-radius: calc(var(--radius-lg) + 2px);
    background: linear-gradient(135deg, var(--gold-primary), transparent 50%, var(--gold-primary));
    z-index: -1;
    opacity: 0.3;
}

.about-image {
    width: 100%;
    height: auto;
    display: block;
    aspect-ratio: 4 / 3;
    object-fit: cover;
}

.about-image-wrap.no-img {
    background: var(--bg-surface-2);
    min-height: 300px;
}

/* ---- Floating Stat Cards ---- */
.about-floating-stats {
    position: absolute;
    bottom: -20px;
    right: -20px;
    display: flex;
    gap: 12px;
    z-index: 2;
}

.about-stat-card {
    padding: 16px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 80px;
}

.about-stat-num {
    font-family: var(--font-display);
    font-size: 28px;
    font-weight: 600;
    color: var(--gold-primary);
    line-height: 1.2;
}

.about-stat-label {
    font-size: 11px;
    color: var(--text-muted);
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

/* ---- Right: Content ---- */
.about-text {
    font-size: 15px;
    color: var(--text-secondary);
    line-height: 1.7;
    margin: 0 0 var(--space-md);
}

.about-text-secondary {
    color: var(--text-muted);
}

/* ---- Counters ---- */
.about-counters {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin: var(--space-xl) 0;
    padding: var(--space-lg) 0;
    border-top: 1px solid var(--border-default);
    border-bottom: 1px solid var(--border-default);
}

.about-counter {
    text-align: center;
}

.about-counter-num {
    display: block;
    font-family: var(--font-display);
    font-size: 36px;
    font-weight: 300;
    color: var(--gold-primary);
    line-height: 1.1;
}

.about-counter-label {
    display: block;
    font-size: 12px;
    color: var(--text-muted);
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-top: 4px;
}

/* ---- Responsive ---- */
@media (max-width: 1024px) {
    .about-layout {
        grid-template-columns: 1fr;
        gap: 48px;
    }

    .about-image-wrap {
        max-width: 500px;
        margin: 0 auto;
    }

    .about-floating-stats {
        right: 50%;
        transform: translateX(50%);
        bottom: -20px;
    }
}

@media (max-width: 640px) {
    .about-counters {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .about-floating-stats {
        position: static;
        transform: none;
        justify-content: center;
        margin-top: 16px;
    }
}
</style>
@endpush
