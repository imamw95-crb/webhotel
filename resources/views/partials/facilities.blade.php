{{-- ============================================================
   PARTIAL: FACILITIES — The Icon Hotel Kuningan
   ============================================================ --}}

<section id="facilities" class="section-padding facilities-section">
    <div class="section-container">
        <div class="facilities-layout">
            {{-- Left: Sticky Content --}}
            <div class="facilities-left reveal-left">
                <span class="sec-label">{{ $sections['facilities_intro']['subtitle'] ?? 'Amenities' }}</span>
                <h2 class="section-title">{{ $sections['facilities_intro']['title'] ?? 'World-Class Facilities' }}</h2>
                <div class="gold-line"></div>
                <p class="facilities-desc">
                    {{ $sections['facilities_intro']['content']['description'] ?? 'We provide comprehensive facilities to make your stay comfortable and memorable.' }}
                </p>
                <a href="#explore-spaces" class="btn-ghost">View All <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            {{-- Right: Facility Cards Grid --}}
            <div class="facilities-right stagger">
                @php
                    $facilityList = [
                        ['icon' => 'fa-solid fa-briefcase', 'name' => 'Meeting Room', 'desc' => '2 meeting rooms available for business events'],
                        ['icon' => 'fa-solid fa-water', 'name' => 'Swimming Pool', 'desc' => 'Enjoy our warm swimming pool'],
                        ['icon' => 'fa-solid fa-utensils', 'name' => 'Sky Terrace Restaurant', 'desc' => 'Rooftop dining with panoramic views'],
                        ['icon' => 'fa-solid fa-spa', 'name' => 'SPA', 'desc' => 'Relax and rejuvenate with our spa services'],
                        ['icon' => 'fa-solid fa-car', 'name' => 'Parking', 'desc' => 'Spacious parking area available'],
                        ['icon' => 'fa-solid fa-moon', 'name' => 'Mushola', 'desc' => 'Prayer room for your convenience'],
                        ['icon' => 'fa-solid fa-bag-shopping', 'name' => 'Convenience Store', 'desc' => 'Small store for daily necessities'],
                        ['icon' => 'fa-solid fa-wifi', 'name' => 'WiFi 100Mbps', 'desc' => 'High-speed internet throughout the hotel'],
                        ['icon' => 'fa-solid fa-shield-halved', 'name' => '24H Security', 'desc' => 'Round-the-clock security & CCTV'],
                    ];

                    // Override with DB facilities if they exist
                    if (count($facilities) > 0) {
                        $facilityList = [];
                        foreach ($facilities as $fac) {
                            $facilityList[] = [
                                'icon' => $fac->icon,
                                'name' => $fac->name,
                                'desc' => $fac->description ?? '',
                            ];
                        }
                    }
                @endphp

                @foreach($facilityList as $fac)
                    <div class="facility-card glass">
                        <div class="facility-card-top"></div>
                        <div class="facility-card-inner">
                            <i class="{{ $fac['icon'] }} facility-icon"></i>
                            <h3 class="facility-name">{{ $fac['name'] }}</h3>
                            <p class="facility-desc">{{ $fac['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
/* ---- Facilities Section ---- */
.facilities-section {
    background: var(--bg-page);
    border-top: 1px solid var(--border-default);
    border-bottom: 1px solid var(--border-default);
}

.facilities-layout {
    display: grid;
    grid-template-columns: 38% 62%;
    gap: 48px;
    align-items: start;
}

/* ---- Left Side (Sticky) ---- */
.facilities-left {
    position: sticky;
    top: 100px;
}

.facilities-desc {
    font-size: 15px;
    color: var(--text-secondary);
    line-height: 1.7;
    margin: 0 0 var(--space-xl);
    max-width: 400px;
}

/* ---- Right Side (Grid) ---- */
.facilities-right {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

/* ---- Facility Card ---- */
.facility-card {
    position: relative;
    overflow: hidden;
    padding: 0;
    transition: all var(--transition-base);
}

.facility-card:hover {
    background: rgba(201, 168, 76, 0.06);
}

.facility-card-top {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: var(--gold-primary);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s ease;
}

.facility-card:hover .facility-card-top {
    transform: scaleX(1);
}

.facility-card-inner {
    padding: 28px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 10px;
}

.facility-icon {
    font-size: 28px;
    color: var(--gold-primary);
    transition: transform 0.3s ease;
}

.facility-card:hover .facility-icon {
    transform: scale(1.15);
}

.facility-name {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
    line-height: 1.3;
}

.facility-desc {
    font-size: 13px;
    color: var(--text-muted);
    margin: 0;
    line-height: 1.5;
}

/* ---- Responsive ---- */
@media (max-width: 1024px) {
    .facilities-layout {
        grid-template-columns: 1fr;
        gap: 32px;
    }

    .facilities-left {
        position: static;
        text-align: center;
    }

    .facilities-left .gold-line {
        margin-left: auto;
        margin-right: auto;
    }

    .facilities-desc {
        max-width: 100%;
    }

    .facilities-right {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .facilities-right {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
