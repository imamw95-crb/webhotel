{{-- ============================================================
   PARTIAL: ROOMS — The Icon Hotel Kuningan
   ============================================================ --}}

<section id="rooms" class="section-padding rooms-section">
    <div class="section-container">
        {{-- Section Header --}}
        <div class="rooms-header reveal">
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
                    'image_path' => 'room-types/executive/IMG_20260315_154656_154.jpg',
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

            $displayRooms = [];
            if ($usePms) {
                foreach ($pmsRoomTypes as $key => $type) {
                    $displayRooms[] = (object)[
                        'name' => $type['name'],
                        'base_price' => $type['min_price'],
                        'image_path' => $type['image'] ?? 'room-types/executive/IMG_20260315_154656_154.jpg',
                        'description' => $type['description'] ?? '',
                        'facilities' => $type['facilities'] ?? [],
                        'max_occupancy' => $type['max_occupancy'] ?? 2,
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
                @endphp
                <div class="room-card card-dark">
                    {{-- Image --}}
                    <div class="room-card-img-wrap">
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

                        {{-- Badges --}}
                        <span class="room-badge badge-category">{{ Illuminate\Support\Str::limit($name, 18) }}</span>
                        <span class="room-badge badge-availability {{ $availClass }}">{{ $availText }}</span>
                    </div>

                    {{-- Body --}}
                    <div class="room-card-body">
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
                            <a href="#hero" class="btn-ghost small">Details</a>
                            <button type="button"
                                    class="btn-gold small book-now-btn"
                                    data-room-type="{{ $name }}"
                                    data-room-id="{{ is_array($room) ? ($room['id'] ?? '') : ($room->id ?? '') }}">
                                Book Now
                            </button>
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

/* ---- Room Grid ---- */
.rooms-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

/* ---- Room Card ---- */
.room-card {
    display: flex;
    flex-direction: column;
}

.room-card-img-wrap {
    position: relative;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    background: var(--bg-surface-2);
}

.room-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.7s ease;
}

.room-card:hover .room-card-img {
    transform: scale(1.07);
}

.room-card-img-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    font-size: 32px;
}

.no-img {
    background: var(--bg-surface-2);
}

/* ---- Badges ---- */
.room-badge {
    position: absolute;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.04em;
    padding: 5px 12px;
    border-radius: var(--radius-full);
    text-transform: uppercase;
}

.badge-category {
    top: 12px;
    left: 12px;
    background: var(--gold-primary);
    color: #09090f;
}

.badge-availability {
    top: 12px;
    right: 12px;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.avail-available {
    color: #4ade80;
}

.avail-unavailable {
    color: #f87171;
}

/* ---- Card Body ---- */
.room-card-body {
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex: 1;
}

.room-name {
    font-family: var(--font-display);
    font-size: 22px;
    font-weight: 400;
    color: var(--text-primary);
    margin: 0;
    line-height: 1.3;
}

.room-desc {
    font-size: 14px;
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
    gap: 6px;
}

.amenity-pill {
    font-size: 11px;
    font-weight: 500;
    padding: 4px 10px;
    border-radius: var(--radius-full);
    background: var(--bg-surface-2);
    color: var(--text-secondary);
    border: 1px solid var(--border-default);
}

.amenity-more {
    color: var(--gold-primary);
    border-color: rgba(201, 168, 76, 0.2);
}

/* ---- Price ---- */
.room-price-row {
    display: flex;
    align-items: baseline;
    gap: 4px;
}

.room-price {
    font-family: var(--font-display);
    font-size: 20px;
    font-weight: 600;
    color: var(--gold-primary);
}

.room-price-label {
    font-size: 13px;
    color: var(--text-muted);
}

/* ---- Actions ---- */
.room-actions {
    display: flex;
    gap: 10px;
    margin-top: auto;
    padding-top: 8px;
}

.room-actions .btn-ghost,
.room-actions .btn-gold {
    flex: 1;
}

/* ---- Responsive ---- */
@media (max-width: 1024px) {
    .rooms-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .rooms-grid {
        display: flex;
        gap: 16px;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        padding-bottom: 12px;
        -webkit-overflow-scrolling: touch;
    }

    .rooms-grid::-webkit-scrollbar {
        height: 4px;
    }

    .rooms-grid::-webkit-scrollbar-thumb {
        background: var(--border-hover);
        border-radius: 4px;
    }

    .room-card {
        min-width: 280px;
        scroll-snap-align: start;
        flex-shrink: 0;
    }
}

/* ---- Availability Results ---- */
.av-results {
    background: var(--bg-surface);
    border: 1px solid var(--border-hover);
    border-radius: var(--radius-lg);
    padding: 20px 24px;
    margin-bottom: 28px;
    animation: fadeSlideDown 0.4s ease;
}

@keyframes fadeSlideDown {
    from { opacity: 0; transform: translateY(-12px); }
    to { opacity: 1; transform: translateY(0); }
}

.av-results-header {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 14px;
    padding-bottom: 12px;
    border-bottom: 1px solid var(--border-default);
}

.av-results-header span {
    color: var(--gold-primary);
}

.av-results-types {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.av-result-type {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--bg-surface-2);
    border: 1px solid var(--border-default);
    border-radius: var(--radius-md);
    padding: 12px 16px;
    flex: 1;
    min-width: 200px;
    transition: border-color 0.2s, background 0.2s;
}

.av-result-type:hover {
    border-color: var(--border-hover);
    background: rgba(201, 168, 76, 0.03);
}

.av-result-type-info {
    flex: 1;
}

.av-result-type-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-primary);
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.av-result-type-price {
    font-size: 14px;
    color: var(--gold-primary);
    font-weight: 600;
    margin-top: 2px;
}

.av-result-type-count {
    font-size: 12px;
    color: var(--text-muted);
    margin-top: 1px;
}

.av-result-type .btn-gold.small {
    padding: 6px 14px;
    font-size: 11px;
    white-space: nowrap;
    letter-spacing: 0.04em;
}

.av-result-type .btn-gold.small {
    padding: 6px 14px;
    font-size: 12px;
    white-space: nowrap;
}
</style>
@endpush
