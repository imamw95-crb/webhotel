{{-- ============================================================
   PARTIAL: OFFERS & PACKAGES — The Icon Hotel Kuningan
   Promotional offers with animated cards
   ============================================================ --}}

<section id="offers" class="section-padding offers-section">
    <div class="section-container">
        <div class="text-center mb-16 reveal">
            <span class="sec-label">{{ $sections['offers_intro']['subtitle'] ?? 'Special Offers' }}</span>
            <h2 class="section-title">{{ $sections['offers_intro']['title'] ?? 'Exclusive Packages' }}</h2>
            <div class="gold-line centered"></div>
        </div>

        @php
            $offers = [
                [
                    'tag' => 'Best Value',
                    'title' => 'Weekend Getaway',
                    'desc' => 'Enjoy a relaxing weekend with complimentary breakfast for two, late checkout until 14:00, and a welcome drink.',
                    'original' => 1200000,
                    'price' => 899000,
                    'valid' => 'Valid until Dec 2026',
                    'features' => ['Breakfast for 2', 'Late Checkout 14:00', 'Welcome Drink', 'Free WiFi'],
                    'gradient' => 'from-amber-500/20 to-amber-600/5',
                ],
                [
                    'tag' => 'Popular',
                    'title' => 'Honeymoon Suite',
                    'desc' => 'Romantic escape with suite upgrade, candlelight dinner, flower arrangement, and spa credit for two.',
                    'original' => 2500000,
                    'price' => 1799000,
                    'valid' => 'Valid until Dec 2026',
                    'features' => ['Suite Upgrade', 'Candlelight Dinner', 'Flower Arrangement', 'Spa Credit 200K'],
                    'gradient' => 'from-rose-500/20 to-rose-600/5',
                ],
                [
                    'tag' => 'Limited',
                    'title' => 'Business Traveler',
                    'desc' => 'Perfect for business trips with meeting room access, airport transfer, express breakfast, and 24hr late checkout.',
                    'original' => 1500000,
                    'price' => 1099000,
                    'valid' => 'Valid until Dec 2026',
                    'features' => ['Meeting Room 2hr', 'Airport Transfer', 'Express Breakfast', '24hr Checkout'],
                    'gradient' => 'from-blue-500/20 to-blue-600/5',
                ],
            ];
        @endphp

        <div class="offers-grid stagger">
            @foreach($offers as $offer)
                <div class="offer-card card-dark" style="background: linear-gradient(135deg, var(--bg-surface), var(--bg-surface-2));">
                    {{-- Tag --}}
                    <div class="offer-tag">{{ $offer['tag'] }}</div>

                    {{-- Content --}}
                    <div class="offer-body">
                        <h3 class="offer-title">{{ $offer['title'] }}</h3>
                        <p class="offer-desc">{{ $offer['desc'] }}</p>

                        {{-- Features --}}
                        <div class="offer-features">
                            @foreach($offer['features'] as $feature)
                                <span class="offer-feature">
                                    <i class="fa-solid fa-check"></i>
                                    {{ $feature }}
                                </span>
                            @endforeach
                        </div>

                        {{-- Price --}}
                        <div class="offer-price-row">
                            <div>
                                <span class="offer-original">Rp {{ number_format($offer['original'], 0, ',', '.') }}</span>
                                <span class="offer-price">Rp {{ number_format($offer['price'], 0, ',', '.') }}</span>
                                <span class="offer-price-label">/ night</span>
                            </div>
                            <span class="offer-discount">-{{ round((1 - $offer['price'] / $offer['original']) * 100) }}%</span>
                        </div>

                        {{-- Valid --}}
                        <p class="offer-valid"><i class="fa-regular fa-clock"></i> {{ $offer['valid'] }}</p>

                        {{-- CTA --}}
                        <button type="button" class="btn-gold small offer-btn ripple-btn" onclick="window.openBookingModal ? window.openBookingModal() : null">
                            Book This Offer <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Trust Badge --}}
        <div class="offer-trust reveal">
            <i class="fa-solid fa-shield-check"></i>
            <span>Best Rate Guaranteed — Book directly for the lowest price</span>
        </div>
    </div>
</section>

@push('styles')
<style>
/* ---- Offers Section ---- */
.offers-section {
    background: var(--bg-page);
    border-top: 1px solid var(--border-default);
}

/* ---- Grid ---- */
.offers-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

/* ---- Card ---- */
.offer-card {
    position: relative;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-default);
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

.offer-card:hover {
    transform: translateY(-8px);
    border-color: rgba(212, 175, 55, 0.2);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4), 0 0 30px rgba(212, 175, 55, 0.05);
}

/* ---- Tag ---- */
.offer-tag {
    position: absolute;
    top: 16px;
    left: 16px;
    z-index: 2;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    padding: 5px 14px;
    border-radius: var(--radius-full);
    background: linear-gradient(135deg, var(--gold-primary), var(--gold-hover));
    color: #09090f;
}

/* ---- Body ---- */
.offer-body {
    padding: 52px 24px 24px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex: 1;
}

.offer-title {
    font-family: var(--font-display);
    font-size: 22px;
    font-weight: 500;
    color: var(--text-primary);
    margin: 0;
    line-height: 1.3;
}

.offer-desc {
    font-size: 13px;
    color: var(--text-secondary);
    line-height: 1.6;
    margin: 0;
}

/* ---- Features ---- */
.offer-features {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin: 4px 0;
}

.offer-feature {
    font-size: 12px;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 8px;
}

.offer-feature i {
    color: #4ade80;
    font-size: 10px;
}

/* ---- Price ---- */
.offer-price-row {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 12px;
    margin-top: auto;
    padding-top: 12px;
    border-top: 1px solid var(--border-default);
}

.offer-original {
    display: block;
    font-size: 13px;
    color: var(--text-muted);
    text-decoration: line-through;
}

.offer-price {
    font-family: var(--font-display);
    font-size: 28px;
    font-weight: 600;
    color: var(--gold-primary);
    line-height: 1.2;
}

.offer-price-label {
    font-size: 12px;
    color: var(--text-muted);
}

.offer-discount {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    font-size: 12px;
    font-weight: 700;
    color: #4ade80;
    background: rgba(74, 222, 128, 0.1);
    border-radius: var(--radius-sm);
}

/* ---- Valid ---- */
.offer-valid {
    font-size: 11px;
    color: var(--text-muted);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* ---- CTA ---- */
.offer-btn {
    width: 100%;
    margin-top: 4px;
}

/* ---- Trust Badge ---- */
.offer-trust {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-top: 32px;
    padding: 16px 24px;
    background: rgba(212, 175, 55, 0.04);
    border: 1px solid rgba(212, 175, 55, 0.1);
    border-radius: var(--radius-full);
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.offer-trust i {
    color: var(--gold-primary);
    font-size: 18px;
}

.offer-trust span {
    font-size: 13px;
    color: var(--text-secondary);
    font-weight: 500;
}

/* ---- Responsive ---- */
@media (max-width: 1024px) {
    .offers-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .offers-grid {
        grid-template-columns: 1fr;
    }

    .offer-card:hover {
        transform: translateY(-4px);
    }

    .offer-trust {
        flex-direction: column;
        text-align: center;
        border-radius: var(--radius-lg);
    }
}
</style>
@endpush
