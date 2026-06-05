{{-- ============================================================
   PARTIAL: BOOKING MODAL — The Icon Hotel Kuningan
   Pure HTML/CSS/JS (no Alpine dependency)
   ============================================================ --}}

<div id="booking-modal" class="booking-modal-overlay" style="display:none;" role="dialog" aria-modal="true">
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" id="bm-backdrop"></div>

    {{-- Modal --}}
    <div class="relative rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto z-10 bm-modal">
        {{-- Header --}}
        <div class="sticky top-0 px-6 py-4 flex items-center justify-between z-10 bm-header">
            <div>
                <h3 class="bm-title">Book a Room</h3>
                <p class="bm-subtitle">Fill in your details to complete the booking</p>
            </div>
            <button id="bm-close" class="bm-close-btn" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('booking.submit') }}" class="p-6 space-y-5" id="bm-form">
            @csrf

            {{-- Honeypot --}}
            <div style="position:absolute;left:-9999px" aria-hidden="true">
                <input type="text" name="website" tabindex="-1" autocomplete="off">
            </div>

            {{-- Hidden room_id --}}
            <input type="hidden" name="room_id" id="bm-room-id">

            {{-- Date & Guests Row --}}
            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="bm-label">Check-in <span class="text-red-400">*</span></label>
                    <input type="date" name="check_in" id="bm-checkin" required
                           class="bm-input"
                           onchange="bmUpdateCheckoutMin(); bmUpdateSummary();">
                </div>
                <div>
                    <label class="bm-label">Check-out <span class="text-red-400">*</span></label>
                    <input type="date" name="check_out" id="bm-checkout" required
                           class="bm-input"
                           onchange="bmUpdateSummary();">
                </div>
                <div>
                    <label class="bm-label">Guests <span class="text-red-400">*</span></label>
                    <select name="guests" id="bm-guests" required class="bm-input">
                        @for($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ $i === 2 ? 'selected' : '' }}>{{ $i }} {{ $i > 1 ? 'Adults' : 'Adult' }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            {{-- Guest Details Row --}}
            <div class="grid sm:grid-cols-3 gap-4">
                <div class="sm:col-span-3">
                    <label class="bm-label">Full Name <span class="text-red-400">*</span></label>
                    <input type="text" name="name" id="bm-name" required
                           class="bm-input" placeholder="Your full name">
                </div>
                <div>
                    <label class="bm-label">Email <span class="text-red-400">*</span></label>
                    <input type="email" name="email" id="bm-email" required
                           class="bm-input" placeholder="your@email.com">
                </div>
                <div>
                    <label class="bm-label">Phone <span class="text-red-400">*</span></label>
                    <input type="tel" name="phone" id="bm-phone" required
                           class="bm-input" placeholder="+62 8xx-xxxx-xxxx">
                </div>
                <div>
                    <label class="bm-label">Room Type</label>
                    <select name="room_type" id="bm-room-type" class="bm-input">
                        <option value="">Select room type</option>
                        @isset($pmsRoomTypes)
                            @foreach($pmsRoomTypes as $type)
                                <option value="{{ $type['name'] }}">{{ $type['name'] }}</option>
                            @endforeach
                        @else
                            @isset($roomTypes)
                                @foreach($roomTypes as $room)
                                    <option value="{{ $room->name }}">{{ $room->name }}</option>
                                @endforeach
                            @endisset
                        @endisset
                    </select>
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label class="bm-label">Special Requests</label>
                <textarea name="notes" id="bm-notes" rows="3" class="bm-input bm-textarea"
                          placeholder="Any special requests? (optional)"></textarea>
            </div>

            {{-- Math Captcha --}}
            <div>
                <label class="bm-label">Verification <span class="text-red-400">*</span></label>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium text-gray-300 whitespace-nowrap">{{ $captchaQuestion ?? '5 + 2 = ?' }}</span>
                    <input type="number" name="captcha_answer" id="bm-captcha" required
                           class="bm-input w-24" placeholder="Answer"
                           autocomplete="off">
                </div>
                @error('captcha_answer')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Summary --}}
            <div id="bm-summary" class="bm-summary" style="display:none;">
                <p class="bm-summary-title">Booking Summary</p>
                <div class="bm-summary-body">
                    <p><span class="font-medium">Check-in:</span> <span id="bm-sum-checkin"></span></p>
                    <p><span class="font-medium">Check-out:</span> <span id="bm-sum-checkout"></span></p>
                    <p><span class="font-medium">Duration:</span> <span id="bm-sum-duration"></span></p>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="bm-submit-btn">
                <i class="fa-solid fa-calendar-check"></i>
                Confirm Booking
            </button>

            <p class="text-xs text-gray-400 text-center">
                By clicking "Confirm Booking", you agree to our terms and conditions.
                Check-in: 14:00 &middot; Check-out: 12:00
            </p>
        </form>
    </div>
</div>

{{-- Inline styles --}}
<style>
.booking-modal-overlay {
    position: fixed; inset: 0; z-index: 9999;
    display: flex; align-items: center; justify-content: center;
    padding: 1rem;
}
.booking-modal-overlay > .fixed {
    position: fixed; inset: 0; z-index: 1;
}
.booking-modal-overlay > .relative {
    position: relative; z-index: 2;
}

/* ---- Modal Container ---- */
.bm-modal {
    background: var(--bg-surface);
    border: 1px solid rgba(201, 168, 76, 0.15);
}

/* ---- Header ---- */
.bm-header {
    background: var(--bg-surface);
    border-bottom: 1px solid var(--border-default);
}

.bm-title {
    font-family: var(--font-display);
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
}

.bm-subtitle {
    font-size: 13px;
    color: var(--text-muted);
    margin-top: 2px;
}

.bm-close-btn {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    border: none;
    background: rgba(255, 255, 255, 0.04);
    color: var(--text-muted);
    font-size: 20px;
    cursor: pointer;
    transition: background 0.2s, color 0.2s, transform 0.2s;
}

.bm-close-btn:hover {
    background: var(--bg-surface-2);
    color: var(--text-primary);
    transform: rotate(90deg);
}

.bm-close-btn:focus-visible {
    outline: 2px solid var(--gold-primary);
    outline-offset: 2px;
}

/* ---- Labels ---- */
.bm-label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: var(--text-secondary);
    margin-bottom: 6px;
}

/* ---- Inputs ---- */
.bm-input {
    width: 100%;
    padding: 10px 14px;
    background: var(--bg-surface-2);
    border: 1px solid var(--border-default);
    border-radius: var(--radius-md);
    color: var(--text-primary);
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    -webkit-appearance: none;
    appearance: none;
}

.bm-input:focus {
    border-color: var(--gold-primary);
    box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.15);
}

.bm-input::placeholder {
    color: var(--text-muted);
}

.bm-input option {
    background: var(--bg-surface);
    color: var(--text-primary);
}

/* Fix date input icon color in dark theme */
.bm-input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(0.7);
    cursor: pointer;
}

/* ---- Textarea ---- */
.bm-textarea {
    resize: none;
    min-height: 80px;
}

/* ---- Summary ---- */
.bm-summary {
    background: var(--bg-surface-2);
    border: 1px solid rgba(201, 168, 76, 0.15);
    border-radius: var(--radius-md);
    padding: 14px 16px;
}

.bm-summary-title {
    font-size: 13px;
    font-weight: 600;
    color: var(--gold-primary);
    margin-bottom: 8px;
}

.bm-summary-body {
    font-size: 13px;
    color: var(--text-secondary);
    line-height: 1.8;
}

.bm-summary-body .font-medium {
    color: var(--text-primary);
}

/* ---- Submit Button ---- */
.bm-submit-btn {
    width: 100%;
    background: linear-gradient(135deg, var(--gold-primary), #b8942e);
    color: #09090f;
    font-weight: 700;
    font-size: 15px;
    padding: 12px 24px;
    border: none;
    border-radius: var(--radius-md);
    cursor: pointer;
    transition: opacity 0.2s, transform 0.2s, box-shadow 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.bm-submit-btn:hover {
    opacity: 0.9;
    transform: translateY(-1px);
    box-shadow: 0 4px 20px rgba(201, 168, 76, 0.3);
}

.bm-submit-btn:active {
    transform: translateY(0);
}
</style>

<script>
// Booking Modal State
var bm = {
    today: function() {
        return new Date().toISOString().split('T')[0];
    },
    tomorrow: function() {
        var d = new Date(); d.setDate(d.getDate() + 1);
        return d.toISOString().split('T')[0];
    },
    minCheckOut: function() {
        var ci = document.getElementById('bm-checkin').value;
        if (!ci) return bm.tomorrow();
        var d = new Date(ci); d.setDate(d.getDate() + 1);
        return d.toISOString().split('T')[0];
    },
    formatDate: function(dateStr) {
        if (!dateStr) return '';
        var parts = dateStr.split('-');
        return parts[2] + '/' + parts[1] + '/' + parts[0];
    },
    nights: function() {
        var ci = document.getElementById('bm-checkin').value;
        var co = document.getElementById('bm-checkout').value;
        if (!ci || !co) return 0;
        return Math.max((new Date(co) - new Date(ci)) / 86400000, 0);
    }
};

// Set min attributes on check-in and pre-fill defaults
function bmInitDates() {
    var ci = document.getElementById('bm-checkin');
    var co = document.getElementById('bm-checkout');
    if (ci) {
        ci.setAttribute('min', bm.today());
        if (!ci.value) ci.value = bm.today();
    }
    if (co) {
        co.setAttribute('min', bm.tomorrow());
        if (!co.value) co.value = bm.tomorrow();
    }
}

// Update check-out min when check-in changes
function bmUpdateCheckoutMin() {
    var ci = document.getElementById('bm-checkin');
    var co = document.getElementById('bm-checkout');
    if (ci && co) {
        co.setAttribute('min', bm.minCheckOut());
        if (co.value && co.value <= ci.value) co.value = '';
    }
}

// Update booking summary
function bmUpdateSummary() {
    var ci = document.getElementById('bm-checkin').value;
    var co = document.getElementById('bm-checkout').value;
    var summary = document.getElementById('bm-summary');
    if (ci && co) {
        document.getElementById('bm-sum-checkin').textContent = bm.formatDate(ci);
        document.getElementById('bm-sum-checkout').textContent = bm.formatDate(co);
        var n = bm.nights();
        document.getElementById('bm-sum-duration').textContent = n + (n > 1 ? ' nights' : ' night');
        summary.style.display = 'block';
    } else {
        summary.style.display = 'none';
    }
}

// Open modal
window.openBookingModal = function(options) {
    options = options || {};
    var modal = document.getElementById('booking-modal');
    if (!modal) return;

    // Set values
    if (options.checkIn) document.getElementById('bm-checkin').value = options.checkIn;
    if (options.checkOut) document.getElementById('bm-checkout').value = options.checkOut;
    if (options.guests) document.getElementById('bm-guests').value = options.guests;
    if (options.roomType) document.getElementById('bm-room-type').value = options.roomType;
    if (options.roomId) document.getElementById('bm-room-id').value = options.roomId;

    // Reset name/email/phone/notes/captcha
    document.getElementById('bm-name').value = '';
    document.getElementById('bm-email').value = '';
    document.getElementById('bm-phone').value = '';
    document.getElementById('bm-notes').value = '';
    var cap = document.getElementById('bm-captcha');
    if (cap) cap.value = '';

    // Init dates and show
    bmInitDates();
    bmUpdateCheckoutMin();
    bmUpdateSummary();
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
};

// Close modal
function bmClose() {
    var modal = document.getElementById('booking-modal');
    if (modal) modal.style.display = 'none';
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', function() {
    // Close buttons
    document.getElementById('bm-close').addEventListener('click', bmClose);
    document.getElementById('bm-backdrop').addEventListener('click', bmClose);

    // ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') bmClose();
    });

    // Room card "Book Now" buttons
    document.querySelectorAll('.book-now-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            window.openBookingModal({
                checkIn: (document.getElementById('av-checkin') || {}).value || '',
                checkOut: (document.getElementById('av-checkout') || {}).value || '',
                guests: (document.getElementById('av-guests') || {}).value || 2,
                roomType: this.dataset.roomType || '',
                roomId: this.dataset.roomId || '',
            });
        });
    });

    // Format number to IDR
    function bmFormatPrice(num) {
        return 'Rp ' + Number(num).toLocaleString('id-ID');
    }

    // Calculate nights from dates
    function bmCalcNights(ci, co) {
        if (!ci || !co) return 0;
        return Math.max((new Date(co) - new Date(ci)) / 86400000, 0);
    }

    // Update availability results display
    function bmShowResults(rooms, checkIn, checkOut, guests) {
        var container = document.getElementById('av-results');
        var title = document.getElementById('av-results-title');
        var typesContainer = document.getElementById('av-results-types');
        if (!container || !title || !typesContainer) return;

        var total = rooms.length;
        var nights = bmCalcNights(checkIn, checkOut);

        // Group by room type
        var typeMap = {};
        rooms.forEach(function(r) {
            var key = r.room_type_name || 'Unknown';
            if (!typeMap[key]) {
                typeMap[key] = { name: key, rooms: [], price: r.price_per_night || 0 };
            }
            typeMap[key].rooms.push(r);
            // Take the lowest price for display
            var p = parseFloat(r.price_per_night || 0);
            if (p < typeMap[key].price || typeMap[key].price === 0) {
                typeMap[key].price = p;
            }
        });

        var typeKeys = Object.keys(typeMap);

        if (total === 0) {
            title.innerHTML = '<span style="color:#f87171;">\u2716</span> No rooms available for ' + bm.formatDate(checkIn) + ' - ' + bm.formatDate(checkOut);
            typesContainer.innerHTML = '<p style="color:var(--text-muted);font-size:14px;">Please try different dates or contact us directly.</p>';
        } else {
            title.innerHTML = '<span style="color:#4ade80;">\u2714</span> ' + total + ' room' + (total > 1 ? 's' : '') + ' available for ' + bm.formatDate(checkIn) + ' - ' + bm.formatDate(checkOut) + ' (' + nights + ' night' + (nights > 1 ? 's' : '') + ')';
            typesContainer.innerHTML = '';
            typeKeys.forEach(function(key) {
                var t = typeMap[key];
                var div = document.createElement('div');
                div.className = 'av-result-type';
                div.innerHTML =
                    '<div class="av-result-type-info">' +
                        '<div class="av-result-type-name">' + t.name + '</div>' +
                        '<div class="av-result-type-price">' + bmFormatPrice(t.price) + ' / night</div>' +
                        '<div class="av-result-type-count">' + t.rooms.length + ' room' + (t.rooms.length > 1 ? 's' : '') + ' available</div>' +
                    '</div>' +
                    '<button type="button" class="btn-gold small book-av-btn" data-room-type="' + t.name + '" data-room-id="">Book Now</button>';
                typesContainer.appendChild(div);
            });

            // Attach event listeners to the new Book Now buttons
            typesContainer.querySelectorAll('.book-av-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.openBookingModal({
                        checkIn: checkIn,
                        checkOut: checkOut,
                        guests: guests,
                        roomType: this.dataset.roomType || '',
                        roomId: this.dataset.roomId || '',
                    });
                });
            });
        }

        container.style.display = 'block';

        // Scroll to availability results
        var target = document.getElementById('av-results-section');
        if (!target) target = document.getElementById('rooms');
        if (target) {
            var nav = document.querySelector('nav');
            var h = nav ? nav.offsetHeight : 0;
            window.scrollTo({
                top: target.getBoundingClientRect().top + window.scrollY - h,
                behavior: 'smooth'
            });
        }
    }

    // Availability search button - call API then show results
    var searchBtn = document.getElementById('av-search-btn');
    if (searchBtn) {
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            var ci = (document.getElementById('av-checkin') || {}).value || '';
            var co = (document.getElementById('av-checkout') || {}).value || '';
            var g = (document.getElementById('av-guests') || {}).value || 2;

            if (!ci || !co) {
                alert('Please select both check-in and check-out dates.');
                return;
            }

            // Show loading state
            searchBtn.textContent = 'Checking...';
            searchBtn.disabled = true;

            // Show loading in results area
            var container = document.getElementById('av-results');
            var title = document.getElementById('av-results-title');
            var typesContainer = document.getElementById('av-results-types');
            if (container) container.style.display = 'block';
            if (title) title.textContent = 'Checking availability...';
            if (typesContainer) typesContainer.innerHTML = '<p style="color:var(--text-muted);font-size:14px;">Please wait...</p>';

            // Scroll to availability results
            var target = document.getElementById('av-results-section');
            if (!target) target = document.getElementById('rooms');
            if (target) {
                var nav = document.querySelector('nav');
                var h = nav ? nav.offsetHeight : 0;
                window.scrollTo({
                    top: target.getBoundingClientRect().top + window.scrollY - h,
                    behavior: 'smooth'
                });
            }

            // Call availability API (using key from .env via backend)
            var url = '/webhotel/public/api/check-availability?check_in=' + encodeURIComponent(ci) + '&check_out=' + encodeURIComponent(co);

            fetch(url)
                .then(function(response) { return response.json(); })
                .then(function(result) {
                    searchBtn.textContent = 'Search';
                    searchBtn.disabled = false;

                    if (result.success && result.data) {
                        bmShowResults(result.data, ci, co, g);
                    } else {
                        bmShowResults([], ci, co, g);
                    }
                })
                .catch(function(err) {
                    searchBtn.textContent = 'Search';
                    searchBtn.disabled = false;
                    console.error('Availability check failed:', err);
                    bmShowResults([], ci, co, g);
                });
        });
    }
});
</script>
