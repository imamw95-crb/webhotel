{{-- ============================================================
   PARTIAL: ROOMS — The Icon Hotel Kuningan
   ============================================================ --}}

<section id="rooms" class="section-padding rooms-section">
    <div class="section-container">
        {{-- Section Header --}}
        <div class="rooms-header reveal-scale">
            <span class="sec-label">{{ $sections['rooms_intro']['subtitle'] ?? 'Accommodation' }}</span>
            <h2 class="section-title">{{ $sections['rooms_intro']['title'] ?? 'Find Your Perfect Stay' }}</h2>
            <div class="gold-line centered"></div>
        </div>

        {{-- Room Cards --}}
        @php
            $usePms = count($pmsRoomTypes) > 0;
            $roomsSource = $usePms ? $pmsRoomTypes : $roomTypes;

            // Fallback default rooms if both sources empty
            $defaultRooms = [
                (object)[
                    'name' => 'Deluxe Room',
                    'base_price' => 350000,
                    'image_path' => 'room-types/deluxe/IMG_20260302_144057.jpg',
                    'description' => 'A comfortable Deluxe room with modern amenities, perfect for couples or solo travelers.',
                    'facilities' => ['AC', 'TV', 'WiFi', 'Mini Bar'],
                    'max_occupancy' => 2,
                ],
                (object)[
                    'name' => 'Executive Garden View',
                    'base_price' => 550000,
                    'image_path' => 'Tampak depan hotel/IMG_20260307_194925_415.jpg',
                    'description' => 'Spacious executive room with stunning garden views and premium amenities.',
                    'facilities' => ['AC', 'TV', 'WiFi', 'Bathtub', 'Mini Bar'],
                    'max_occupancy' => 3,
                ],
                (object)[
                    'name' => 'Family Room',
                    'base_price' => 750000,
                    'image_path' => 'room-types/family-107/IMG_20260312_134525_513.jpg',
                    'description' => 'Perfect for families with ample space, multiple beds, and family-friendly amenities.',
                    'facilities' => ['AC', 'TV', 'WiFi', 'Kitchen', 'Living Room'],
                    'max_occupancy' => 5,
                ],
                (object)[
                    'name' => 'Superior Room',
                    'base_price' => 450000,
                    'image_path' => 'room-types/superior-109/IMG_20260315_124433_350.jpg',
                    'description' => 'A well-appointed superior room with modern furnishings and excellent value.',
                    'facilities' => ['AC', 'TV', 'WiFi', 'Seating Area'],
                    'max_occupancy' => 2,
                ],
                (object)[
                    'name' => 'Junior Suite',
                    'base_price' => 650000,
                    'image_path' => 'room-types/junior/junior-205/IMG_20260302_092144_155@1865609329.jpg',
                    'description' => 'Our Junior Suite offers a blend of comfort and style with a separate living area.',
                    'facilities' => ['AC', 'TV', 'WiFi', 'Living Room', 'Bathtub'],
                    'max_occupancy' => 3,
                ],
                (object)[
                    'name' => 'ICON 5',
                    'base_price' => 950000,
                    'image_path' => 'room-types/executive/IMG_20260315_154802_635.jpg',
                    'description' => 'The premium ICON 5 room features luxurious furnishings and panoramic views.',
                    'facilities' => ['AC', 'TV', 'WiFi', 'Jacuzzi', 'Living Room', 'Butler'],
                    'max_occupancy' => 4,
                ],
            ];

            // Build image lookup from local RoomType models by flexible name matching
            $localTypeMap = [];
            if (isset($roomTypes) && count($roomTypes) > 0) {
                foreach ($roomTypes as $localType) {
                    $normalized = strtolower(trim(preg_replace('/[^a-z0-9]+/i', ' ', $localType->name)));
                    $localTypeMap[$normalized] = $localType;
                    // Also key by first word
                    $parts = explode(' ', $normalized);
                    $firstWord = $parts[0] ?? '';
                    if ($firstWord !== '') {
                        $localTypeMap['first:' . $firstWord] = $localType;
                    }
                    // Key by normalized no-space
                    $localTypeMap['ns:' . str_replace(' ', '', $normalized)] = $localType;
                }
            }

            /**
             * Match a PMS room type name to a local RoomType.
             * Tries: exact normalized match → contains match → first-word match.
             */
            $matchLocalType = function ($pmsName) use ($localTypeMap) {
                $search = strtolower(trim(preg_replace('/[^a-z0-9]+/i', ' ', $pmsName)));
                $searchNs = str_replace(' ', '', $search);
                $searchParts = explode(' ', $search);
                $searchFirst = $searchParts[0] ?? '';

                // 1. Exact normalized match
                if (isset($localTypeMap[$search])) {
                    return $localTypeMap[$search];
                }
                if (isset($localTypeMap['ns:' . $searchNs])) {
                    return $localTypeMap['ns:' . $searchNs];
                }

                // 2. First-word match
                if ($searchFirst !== '' && isset($localTypeMap['first:' . $searchFirst])) {
                    return $localTypeMap['first:' . $searchFirst];
                }

                // 3. Contains match — PMS name shares all words with a local name or vice versa
                foreach ($localTypeMap as $key => $localType) {
                    if (str_starts_with($key, 'first:') || str_starts_with($key, 'ns:')) {
                        continue;
                    }
                    $localWords = explode(' ', $key);
                    $common = array_intersect($localWords, $searchParts);
                    if (count($common) >= min(count($localWords), count($searchParts))) {
                        return $localType;
                    }
                }

                return null;
            };

            $displayRooms = [];
            if ($usePms) {
                foreach ($pmsRoomTypes as $key => $type) {
                    $typeName = $type['name'];
                    $matched = $matchLocalType($typeName);
                    $matchedImage = $matched?->image_path
                        ?? $type['image']
                        ?? null;

                    $displayRooms[] = (object)[
                        'name' => $typeName,
                        'base_price' => $type['min_price'],
                        'image_path' => $matchedImage ?? 'Tampak depan hotel/IMG_20260307_194925_415.jpg',
                        'description' => $type['description'] ?? ($matched?->description ?? ''),
                        'facilities' => $type['facilities'] ?? ($matched?->facilities ?? []),
                        'max_occupancy' => $type['max_occupancy'] ?? ($matched?->max_occupancy ?? 2),
                    ];
                }
            } elseif (count($roomTypes) > 0) {
                $displayRooms = $roomTypes;
            } else {
                $displayRooms = $defaultRooms;
            }
        @endphp

        <div class="rooms-grid stagger">
            @foreach($displayRooms as $room)
                @php
                    $price = $usePms ? ($room->base_price ?? $room['base_price']) : $room->base_price;
                    if (is_array($room)) {
                        $name = $room['name'];
                        $desc = $room['description'] ?? '';
                        $imgPath = $room['image_path'] ?? '';
                        $facilities = $room['facilities'] ?? [];
                        $maxOcc = $room['max_occupancy'] ?? 2;
                    } else {
                        $name = $room->name;
                        $desc = $room->description ?? '';
                        $imgPath = $room->image_path ?? '';
                        $facilities = $room->facilities ?? [];
                        $maxOcc = $room->max_occupancy ?? 2;
                    }
                    $priceNum = is_array($room) ? ($room['base_price'] ?? 0) : ($room->base_price ?? 0);
                    $availClass = $priceNum > 0 ? 'avail-available' : 'avail-unavailable';
                    $availText = $priceNum > 0 ? 'Available' : 'Sold Out';
                    $isPopular = $priceNum >= 750000;
                    $isBestValue = $priceNum >= 350000 && $priceNum <= 450000;
                @endphp
                <div class="room-card card-dark scale-press">
                    {{-- Image (fills entire card) --}}
                    <div class="room-card-img-wrap card-img-zoom">
                        @if($imgPath)
                            <img src="{{ asset('storage/' . $imgPath) }}"
                                 alt="{{ $name }}"
                                 class="room-card-img"
                                 loading="lazy"
                                 onerror="this.parentElement.classList.add('no-img'); this.style.display='none'">
                        @else
                            <div class="room-card-img-placeholder">
                                <i class="fa-solid fa-image"></i>
                            </div>
                        @endif

                        {{-- Image Overlay Gradient --}}
                        <div class="room-card-img-overlay"></div>

                        {{-- Badges --}}
                        @if($isPopular)
                            <span class="room-badge badge-popular"><i class="fa-solid fa-star"></i> Popular Choice</span>
                        @elseif($isBestValue)
                            <span class="room-badge badge-value"><i class="fa-solid fa-tag"></i> Best Value</span>
                        @endif
                        <span class="room-badge badge-availability {{ $availClass }}"><span class="avail-dot"></span> {{ $availText }}</span>
                    </div>

                    {{-- Curtain Content (slides up on hover) --}}
                    <div class="room-curtain">
                        <div class="room-curtain-inner">
                            <h3 class="room-name">{{ $name }}</h3>
                            <p class="room-desc">{{ Illuminate\Support\Str::limit($desc, 120) }}</p>

                            {{-- Amenity Pills --}}
                            @if(count($facilities) > 0)
                                <div class="room-amenities">
                                    @foreach(array_slice($facilities, 0, 4) as $fac)
                                        <span class="amenity-pill">{{ is_array($fac) ? ($fac['name'] ?? $fac) : $fac }}</span>
                                    @endforeach
                                    @if(count($facilities) > 4)
                                        <span class="amenity-pill amenity-more">+{{ count($facilities) - 4 }}</span>
                                    @endif
                                </div>
                            @endif

                            {{-- Price Row --}}
                            <div class="room-price-row">
                                <span class="room-price">Rp {{ number_format($priceNum, 0, ',', '.') }}</span>
                                <span class="room-price-label">/ night</span>
                            </div>

                            {{-- Buttons --}}
                            <div class="room-actions">
                                <a href="#hero" class="btn-ghost small ripple-btn">Details</a>
                                <button type="button"
                                        class="btn-gold small book-now-btn ripple-btn"
                                        data-room-type="{{ $name }}"
                                        data-room-id="{{ is_array($room) ? ($room['id'] ?? '') : ($room->id ?? '') }}">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@push('styles')
<style>
/* ---- Rooms Section ---- */
.rooms-section {
    background: var(--bg-page);
}

.rooms-header {
    text-align: center;
    margin-bottom: var(--space-3xl);
}

/* ---- Room Grid ----
   3-column responsive grid with elegant spacing
   ------------------------------------------------------- */
.rooms-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

@media (min-width: 1400px) {
    .rooms-grid {
        gap: 24px;
    }
}

/* ============================================================
   ROOM CARD — Curtain Reveal on Hover
   Image fills card, content curtain slides up from bottom
   ============================================================ */
.room-card {
    position: relative;
    will-change: transform;
    border-radius: var(--radius-lg);
    overflow: hidden;
    background: var(--bg-surface);
    border: 1px solid var(--border-default);
    transition: box-shadow 0.5s var(--ease-spring, cubic-bezier(0.16, 1, 0.3, 1)),
                border-color 0.5s var(--ease-spring, cubic-bezier(0.16, 1, 0.3, 1)),
                transform 0.5s var(--ease-spring, cubic-bezier(0.16, 1, 0.3, 1));
}

/* Gold border glow on hover */
.room-card::before {
    content: '';
    position: absolute;
    inset: -1px;
    border-radius: calc(var(--radius-lg) + 1px);
    background: linear-gradient(135deg, rgba(212, 175, 55, 0), rgba(212, 175, 55, 0.3), rgba(212, 175, 55, 0));
    opacity: 0;
    transition: opacity 0.5s var(--ease-spring, cubic-bezier(0.16, 1, 0.3, 1));
    z-index: 0;
    pointer-events: none;
}

.room-card:hover::before {
    opacity: 1;
}

.room-card > * {
    position: relative;
    z-index: 1;
}

/* ---- Image Wrap (fills card) ---- */
.room-card-img-wrap {
    position: relative;
    width: 100%;
    height: 300px;
    overflow: hidden;
    background: var(--bg-surface-2);
}

.room-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.7s var(--ease-spring, cubic-bezier(0.16, 1, 0.3, 1)),
                filter 0.5s ease;
}

.room-card:hover .room-card-img {
    transform: scale(1.1);
    filter: brightness(1.1) contrast(1.08);
}

.room-card-img-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    font-size: 32px;
    background: var(--bg-surface-2);
}

.no-img {
    background: var(--bg-surface-2);
}

/* ---- Image Overlay ---- */
.room-card-img-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to top,
        rgba(9, 9, 15, 0.9) 0%,
        rgba(9, 9, 15, 0.3) 40%,
        rgba(9, 9, 15, 0.05) 70%
    );
    z-index: 1;
    pointer-events: none;
    transition: opacity 0.5s ease;
}

.room-card:hover .room-card-img-overlay {
    opacity: 0.9;
}

/* ---- Badges ---- */
.room-badge {
    position: absolute;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.06em;
    padding: 6px 14px;
    border-radius: var(--radius-full);
    text-transform: uppercase;
    z-index: 5;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: transform 0.4s var(--ease-spring, cubic-bezier(0.16, 1, 0.3, 1)),
                box-shadow 0.4s ease;
}

.badge-popular {
    top: 12px;
    left: 12px;
    background: linear-gradient(135deg, #D4AF37, #e8c84a);
    color: #09090f;
    box-shadow: 0 2px 12px rgba(212, 175, 55, 0.4);
    animation: badgePulse 2s ease-in-out infinite;
}

.badge-popular i { font-size: 10px; }

.room-card:hover .badge-popular {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 6px 24px rgba(212, 175, 55, 0.5);
}

.badge-value {
    top: 12px;
    left: 12px;
    background: rgba(52, 211, 153, 0.9);
    color: #09090f;
    backdrop-filter: blur(8px);
}

.badge-value i { font-size: 10px; }

.room-card:hover .badge-value {
    transform: translateY(-2px) scale(1.05);
}

@keyframes badgePulse {
    0%, 100% { box-shadow: 0 2px 12px rgba(212, 175, 55, 0.4); }
    50% { box-shadow: 0 2px 20px rgba(212, 175, 55, 0.7); }
}

.badge-availability {
    top: 12px;
    right: 12px;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.room-card:hover .badge-availability {
    transform: translateY(-2px);
}

.avail-dot {
    display: inline-block;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #4ade80;
    animation: availDotPulse 1.5s ease-in-out infinite;
}

.avail-unavailable .avail-dot {
    background: #f87171;
    animation: none;
}

@keyframes availDotPulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(0.8); }
}

.avail-available { color: #4ade80; }
.avail-unavailable { color: #f87171; }

/* ============================================================
   CURTAIN REVEAL — Content slides up from bottom on hover
   ============================================================ */
.room-curtain {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 3;
    transform: translateY(calc(100% - 64px)); /* show only name area by default */
    transition: transform 0.55s var(--ease-spring, cubic-bezier(0.16, 1, 0.3, 1));
    will-change: transform;
}

.room-card:hover .room-curtain {
    transform: translateY(0); /* fully reveal on hover */
}

.room-curtain-inner {
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    background: linear-gradient(
        to top,
        var(--bg-surface) 0%,
        var(--bg-surface) 70%,
        rgba(17, 17, 25, 0.95) 100%
    );
    border-top: 1px solid var(--border-default);
}

/* ---- Curtain Children Staggered Entrance ---- */
.room-curtain-inner > * {
    opacity: 0;
    transform: translateY(12px);
    transition: opacity 0.4s ease, transform 0.4s var(--ease-spring, cubic-bezier(0.16, 1, 0.3, 1));
}

.room-card:hover .room-curtain-inner > * {
    opacity: 1;
    transform: translateY(0);
}

.room-card:hover .room-curtain-inner > *:nth-child(1) { transition-delay: 0.05s; }
.room-card:hover .room-curtain-inner > *:nth-child(2) { transition-delay: 0.10s; }
.room-card:hover .room-curtain-inner > *:nth-child(3) { transition-delay: 0.15s; }
.room-card:hover .room-curtain-inner > *:nth-child(4) { transition-delay: 0.20s; }
.room-card:hover .room-curtain-inner > *:nth-child(5) { transition-delay: 0.25s; }
.room-card:hover .room-curtain-inner > *:nth-child(6) { transition-delay: 0.30s; }

/* ---- Room Name (always visible in peek state) ---- */
.room-name {
    font-family: var(--font-display);
    font-size: 20px;
    font-weight: 500;
    color: var(--text-primary);
    margin: 0;
    line-height: 1.3;
    transition: color 0.3s ease;
    /* Always visible at bottom peek */
    opacity: 1 !important;
    transform: translateY(0) !important;
}

.room-card:hover .room-name {
    color: var(--gold-primary);
}

.room-desc {
    font-size: 13px;
    color: var(--text-secondary);
    line-height: 1.6;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* ---- Amenities ---- */
.room-amenities {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.amenity-pill {
    font-size: 10px;
    font-weight: 500;
    padding: 3px 9px;
    border-radius: var(--radius-full);
    background: var(--bg-surface-2);
    color: var(--text-secondary);
    border: 1px solid var(--border-default);
    transition: all 0.3s var(--ease-spring, cubic-bezier(0.16, 1, 0.3, 1));
}

.room-card:hover .amenity-pill {
    background: rgba(212, 175, 55, 0.08);
    border-color: rgba(212, 175, 55, 0.2);
    color: var(--text-primary);
    transform: translateY(-1px);
}

.amenity-more {
    color: var(--gold-primary);
    border-color: rgba(201, 168, 76, 0.2);
}

.room-card:hover .amenity-more {
    background: rgba(212, 175, 55, 0.15);
    border-color: var(--gold-primary);
}

/* ---- Price ---- */
.room-price-row {
    display: flex;
    align-items: baseline;
    gap: 4px;
}

.room-price {
    font-family: var(--font-display);
    font-size: 18px;
    font-weight: 600;
    color: var(--gold-primary);
    transition: text-shadow 0.3s ease;
}

.room-card:hover .room-price {
    text-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
}

.room-price-label {
    font-size: 12px;
    color: var(--text-muted);
}

/* ---- Actions ---- */
.room-actions {
    display: flex;
    gap: 8px;
    margin-top: 2px;
}

.room-actions .btn-ghost,
.room-actions .btn-gold {
    flex: 1;
    padding: 10px 18px;
    font-size: 11px;
}

/* ---- Responsive ---- */
@media (max-width: 1100px) {
    .rooms-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .room-card-img-wrap {
        height: 280px;
    }
}

@media (max-width: 640px) {
    .rooms-section {
        overflow: hidden;
    }

    .rooms-header {
        margin-bottom: var(--space-2xl);
    }

    .rooms-header .section-title {
        font-size: clamp(26px, 7vw, 32px);
    }

    .rooms-grid {
        display: flex;
        gap: 16px;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        padding: 0 0 16px 0;
        -webkit-overflow-scrolling: touch;
        margin: 0 calc(-1 * var(--space-md));
        padding-left: var(--space-md);
        padding-right: calc(var(--space-md) - 16px);
        scrollbar-width: thin;
        scrollbar-color: var(--border-hover) transparent;
    }

    .rooms-grid::-webkit-scrollbar {
        height: 4px;
    }

    .rooms-grid::-webkit-scrollbar-track {
        background: transparent;
    }

    .rooms-grid::-webkit-scrollbar-thumb {
        background: var(--border-hover);
        border-radius: 4px;
    }

    .room-card-img-wrap {
        height: 260px;
    }

    .room-curtain {
        transform: translateY(calc(100% - 56px));
    }

    .room-curtain-inner {
        padding: 14px;
        gap: 8px;
    }

    .room-name {
        font-size: 17px;
    }

    .room-price {
        font-size: 16px;
    }

    .room-card {
        min-width: 300px;
        max-width: 340px;
        scroll-snap-align: start;
        flex-shrink: 0;
    }

    .room-card:hover {
        transform: none;
    }

    .room-card:active {
        transform: scale(0.98);
    }

    .room-curtain-inner {
        padding: 16px;
        gap: 10px;
    }

    .room-name {
        font-size: 18px;
    }

    .room-desc {
        font-size: 13px;
        -webkit-line-clamp: 2;
    }

    .room-amenities {
        gap: 5px;
    }

    .amenity-pill {
        font-size: 10px;
        padding: 3px 8px;
    }

    .room-price {
        font-size: 18px;
    }

    .room-price-label {
        font-size: 12px;
    }

    .room-actions {
        gap: 8px;
        padding-top: 4px;
    }

    .room-actions .btn-ghost.small,
    .room-actions .btn-gold.small {
        padding: 8px 16px;
        font-size: 11px;
        min-height: 36px;
    }

    .badge-popular,
    .badge-value {
        top: 10px;
        left: 10px;
        font-size: 9px;
        padding: 4px 10px;
    }

    .badge-availability {
        top: 10px;
        right: 10px;
        font-size: 9px;
        padding: 4px 10px;
    }

    .room-card-img-wrap {
        height: 220px;
    }
}

@media (max-width: 380px) {
    .room-card {
        min-width: 260px;
    }

    .room-curtain-inner {
        padding: 14px;
        gap: 8px;
    }

    .room-name {
        font-size: 16px;
    }

    .room-actions .btn-ghost.small,
    .room-actions .btn-gold.small {
        padding: 6px 12px;
        font-size: 10px;
        min-height: 32px;
    }
}

/* ---- Availability Results ---- */
.av-results {
    background: var(--bg-surface);
    border: 1px solid var(--border-hover);
    border-radius: var(--radius-lg);
    padding: 24px 28px;
    margin-bottom: 32px;
    animation: avFadeSlide 0.45s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes avFadeSlide {
    from { opacity: 0; transform: translateY(-16px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.av-results-header {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 16px;
    padding-bottom: 14px;
    border-bottom: 1px solid var(--border-default);
}

.av-results-header .av-icon {
    width: 32px; height: 32px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%;
    font-size: 14px;
    flex-shrink: 0;
}

.av-results-header .av-icon.success {
    background: rgba(74, 222, 128, 0.12);
    color: #4ade80;
}

.av-results-header .av-icon.empty {
    background: rgba(248, 113, 113, 0.12);
    color: #f87171;
}

.av-results-header .av-icon.loading {
    background: rgba(201, 168, 76, 0.12);
    color: var(--gold-primary);
    animation: avPulse 1.2s ease-in-out infinite;
}

@keyframes avPulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.7; }
}

.av-results-title {
    flex: 1;
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.4;
}

.av-results-title strong {
    color: var(--text-primary);
    font-weight: 700;
}

.av-results-title .highlight {
    color: var(--gold-primary);
    font-weight: 700;
}

.av-results-status {
    font-size: 12px;
    color: var(--text-muted);
    flex-shrink: 0;
}

.av-results-types {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 12px;
}

.av-result-type {
    display: flex;
    align-items: center;
    gap: 14px;
    background: var(--bg-surface-2);
    border: 1px solid var(--border-default);
    border-radius: var(--radius-md);
    padding: 16px 18px;
    transition: all 0.3s ease;
    cursor: default;
    position: relative;
    overflow: hidden;
}

.av-result-type::before {
    content: '';
    position: absolute; top: 0; left: 0;
    width: 3px; height: 100%;
    background: var(--gold-primary);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.av-result-type:hover {
    border-color: var(--border-hover);
    background: rgba(201, 168, 76, 0.04);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

.av-result-type:hover::before {
    opacity: 1;
}

.av-result-type-icon {
    width: 44px; height: 44px;
    display: flex; align-items: center; justify-content: center;
    border-radius: var(--radius-sm);
    background: rgba(201, 168, 76, 0.08);
    color: var(--gold-primary);
    font-size: 18px;
    flex-shrink: 0;
}

.av-result-type-info {
    flex: 1;
    min-width: 0;
}

.av-result-type-name {
    font-size: 13px;
    font-weight: 700;
    color: var(--text-primary);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    line-height: 1.3;
}

.av-result-type-price {
    font-size: 16px;
    color: var(--gold-primary);
    font-weight: 700;
    margin-top: 3px;
    font-family: var(--font-display);
    letter-spacing: 0.02em;
}

.av-result-type-price small {
    font-size: 11px;
    font-weight: 500;
    color: var(--text-muted);
    font-family: var(--font-body);
}

.av-result-type-count {
    font-size: 12px;
    color: var(--text-muted);
    margin-top: 1px;
}

.av-result-type .book-av-btn {
    flex-shrink: 0;
}

/* ---- Skeleton Loading ---- */
.av-skeleton {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 12px;
}

.av-skeleton-card {
    height: 88px;
    background: var(--bg-surface-2);
    border: 1px solid var(--border-default);
    border-radius: var(--radius-md);
    padding: 16px 18px;
    display: flex;
    align-items: center;
    gap: 14px;
}

.av-skeleton-shape {
    background: linear-gradient(90deg, rgba(255,255,255,0.04) 25%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.04) 75%);
    background-size: 200% 100%;
    animation: avShimmer 1.5s ease-in-out infinite;
    border-radius: var(--radius-sm);
}

.av-skeleton-icon {
    width: 44px; height: 44px;
    border-radius: var(--radius-sm);
    flex-shrink: 0;
}

.av-skeleton-lines {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.av-skeleton-line {
    height: 10px;
}

.av-skeleton-line:nth-child(1) { width: 65%; }
.av-skeleton-line:nth-child(2) { width: 40%; }
.av-skeleton-line:nth-child(3) { width: 50%; }

.av-skeleton-btn {
    width: 72px; height: 32px;
    border-radius: var(--radius-sm);
    flex-shrink: 0;
}

@keyframes avShimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}

/* ---- Empty State ---- */
.av-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    text-align: center;
}

.av-empty-icon {
    width: 64px; height: 64px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%;
    background: rgba(248, 113, 113, 0.08);
    color: #f87171;
    font-size: 24px;
    margin-bottom: 16px;
}

.av-empty-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 6px;
}

.av-empty-desc {
    font-size: 13px;
    color: var(--text-muted);
    max-width: 360px;
    line-height: 1.6;
    margin-bottom: 20px;
}

.av-empty .btn-gold.small {
    padding: 8px 20px;
    font-size: 12px;
}

/* ---- Stagger Entrance ---- */
.av-result-type {
    opacity: 0;
    transform: translateY(12px);
    animation: avCardIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.av-result-type:nth-child(1) { animation-delay: 0.00s; }
.av-result-type:nth-child(2) { animation-delay: 0.06s; }
.av-result-type:nth-child(3) { animation-delay: 0.12s; }
.av-result-type:nth-child(4) { animation-delay: 0.18s; }
.av-result-type:nth-child(5) { animation-delay: 0.24s; }
.av-result-type:nth-child(6) { animation-delay: 0.30s; }
.av-result-type:nth-child(7) { animation-delay: 0.36s; }
.av-result-type:nth-child(8) { animation-delay: 0.42s; }

@keyframes avCardIn {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ---- Results mobile ---- */
@media (max-width: 640px) {
    .av-results {
        padding: 16px;
    }
    .av-results-types {
        grid-template-columns: 1fr;
    }
    .av-result-type {
        padding: 14px;
    }
}

.av-result-type .btn-gold.small {
    padding: 6px 14px;
    font-size: 12px;
    white-space: nowrap;
}
</style>
@endpush
