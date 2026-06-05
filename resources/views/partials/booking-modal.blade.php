{{-- ============================================================
   PARTIAL: BOOKING MODAL — The Icon Hotel Kuningan
   Pure HTML/CSS/JS (no Alpine dependency)
   ============================================================ --}}

<div id="booking-modal" class="booking-modal-overlay" role="dialog" aria-modal="true">
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm bm-backdrop" id="bm-backdrop"></div>

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

            {{-- Check-in, Check-out & Guests Row --}}
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
/* ---- Overlay (Backdrop + Centering) ---- */
.booking-modal-overlay {
    position: fixed; inset: 0; z-index: 9999;
    display: flex; align-items: center; justify-content: center;
    padding: 1rem;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
}
.booking-modal-overlay.open {
    opacity: 1;
    pointer-events: auto;
}
.booking-modal-overlay.closing {
    opacity: 0;
    pointer-events: none;
}
.booking-modal-overlay > .fixed {
    position: fixed; inset: 0; z-index: 1;
}
.booking-modal-overlay > .relative {
    position: relative; z-index: 2;
}

/* ---- Backdrop fade ---- */
.bm-backdrop {
    transition: opacity 0.3s ease;
}

/* ---- Modal Container ---- */
.bm-modal {
    background: var(--bg-surface);
    border: 1px solid rgba(201, 168, 76, 0.15);
    transform: translateY(24px) scale(0.95);
    opacity: 0;
    transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.3s ease;
}
.booking-modal-overlay.open .bm-modal {
    transform: translateY(0) scale(1);
    opacity: 1;
}
.booking-modal-overlay.closing .bm-modal {
    transform: translateY(24px) scale(0.95);
    opacity: 0;
    transition: transform 0.25s ease-in, opacity 0.2s ease;
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

<script>window.bmApiUrl = '{{ route('api.check-availability') }}';</script>
<script src="{{ asset('js/booking-modal.js') }}"></script>
