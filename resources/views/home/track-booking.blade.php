@extends('layouts.track')

@section('content')
<div class="track-bg"></div>
<div class="track-wrapper">
    <div class="track-card">
        {{-- Header --}}
        <div class="text-center mb-8 track-header">
            <span class="sec-label">Track Your Booking</span>
            <h2 class="section-title" style="font-size:26px;">Check Booking Status</h2>
            <div class="gold-line centered" style="margin-bottom:12px;"></div>
            <p style="color:var(--text-secondary);font-size:14px;">Enter your booking code to check the status of your reservation.</p>
        </div>

        {{-- Search Form --}}
        <div class="track-form">
            <form method="POST" action="{{ route('booking.lookup') }}" style="display:flex;gap:8px;align-items:flex-end;">
                @csrf
                <div class="track-input-wrap">
                    <label class="track-input-label"><span>Booking Code</span> &mdash; masukkan kode booking</label>
                    <input type="text" name="booking_code" value="{{ old('booking_code') }}" required
                           placeholder="cth: ICNENRSGU atau RES-..."
                           class="bm-input" style="text-transform:uppercase;letter-spacing:0.08em;">
                    <i class="fa-solid fa-ticket track-input-icon"></i>
                    @error('booking_code')
                        <div class="track-input-error">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn-gold track-btn" style="flex-shrink:0;min-width:120px;">
                    <i class="fa-solid fa-search"></i> Track
                </button>
            </form>
        </div>

        {{-- Booking Result --}}
        @if($booking)
            <div class="bm-summary track-result-card track-result">
                <div style="display:flex;align-items:center;justify-content:space-between;padding-bottom:12px;border-bottom:1px solid var(--border-default);margin-bottom:16px;">
                    <h3 style="font-family:var(--font-display);font-size:18px;font-weight:700;color:var(--text-primary);margin:0;">Booking Details</h3>
                    <span class="track-badge"
                        style="{{ $booking->status === 'confirmed' ? 'background:rgba(34,197,94,0.15);color:#4ade80;' : '' }}
                        {{ $booking->status === 'pending' ? 'background:rgba(234,179,8,0.15);color:#eab308;' : '' }}
                        {{ $booking->status === 'cancelled' ? 'background:rgba(239,68,68,0.15);color:#f87171;' : '' }}
                        {{ $booking->status === 'checked_in' ? 'background:rgba(59,130,246,0.15);color:#60a5fa;' : '' }}
                        {{ $booking->status === 'checked_out' ? 'background:rgba(107,114,128,0.15);color:#9ca3af;' : '' }}">
                        <i class="fa-solid fa-circle" style="font-size:8px;"></i>
                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                    </span>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                    <div class="track-detail-item">
                        <p style="font-size:11px;color:var(--text-muted);text-transform:uppercase;font-weight:500;margin-bottom:2px;">Booking Code</p>
                        <p class="track-code-value" style="font-family:monospace;font-weight:700;font-size:18px;color:var(--gold-primary);margin:0;">{{ $booking->booking_code }}</p>
                    </div>
                    <div class="track-detail-item">
                        <p style="font-size:11px;color:var(--text-muted);text-transform:uppercase;font-weight:500;margin-bottom:2px;">Guest Name</p>
                        <p style="font-weight:500;color:var(--text-primary);margin:0;">{{ $booking->name }}</p>
                    </div>
                    <div class="track-detail-item">
                        <p style="font-size:11px;color:var(--text-muted);text-transform:uppercase;font-weight:500;margin-bottom:2px;">Check-in</p>
                        <p style="color:var(--text-primary);margin:0;">{{ \Carbon\Carbon::parse($booking->check_in)->format('l, d F Y') }}</p>
                        <p style="font-size:12px;color:var(--text-muted);margin:0;">From 14:00</p>
                    </div>
                    <div class="track-detail-item">
                        <p style="font-size:11px;color:var(--text-muted);text-transform:uppercase;font-weight:500;margin-bottom:2px;">Check-out</p>
                        <p style="color:var(--text-primary);margin:0;">{{ \Carbon\Carbon::parse($booking->check_out)->format('l, d F Y') }}</p>
                        <p style="font-size:12px;color:var(--text-muted);margin:0;">Until 12:00</p>
                    </div>
                    <div class="track-detail-item">
                        <p style="font-size:11px;color:var(--text-muted);text-transform:uppercase;font-weight:500;margin-bottom:2px;">Duration</p>
                        <p style="color:var(--text-primary);margin:0;">{{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }} night(s)</p>
                    </div>
                    <div class="track-detail-item">
                        <p style="font-size:11px;color:var(--text-muted);text-transform:uppercase;font-weight:500;margin-bottom:2px;">Guests</p>
                        <p style="color:var(--text-primary);margin:0;">{{ $booking->guests }} person(s)</p>
                    </div>
                    <div class="track-detail-item">
                        <p style="font-size:11px;color:var(--text-muted);text-transform:uppercase;font-weight:500;margin-bottom:2px;">Room Type</p>
                        <p style="color:var(--text-primary);margin:0;">{{ $booking->room_type ?? '&mdash;' }}</p>
                    </div>
                    <div class="track-detail-item">
                        <p style="font-size:11px;color:var(--text-muted);text-transform:uppercase;font-weight:500;margin-bottom:2px;">Total Amount</p>
                        <p style="font-weight:700;font-size:20px;color:var(--gold-primary);margin:0;">
                            Rp {{ number_format($booking->total_amount ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="track-detail-item">
                        <p style="font-size:11px;color:var(--text-muted);text-transform:uppercase;font-weight:500;margin-bottom:2px;">Payment Status</p>
                        <p style="font-weight:500;margin:0;{{ $booking->payment_status === 'paid' ? 'color:#4ade80;' : 'color:#eab308;' }}">
                            <i class="fa-solid fa-{{ $booking->payment_status === 'paid' ? 'check-circle' : 'clock' }}" style="font-size:12px;"></i>
                            {{ ucfirst($booking->payment_status ?? 'pending') }}
                        </p>
                    </div>
                    @if($booking->payment_due_at && $booking->payment_status !== 'paid' && $booking->status === 'pending')
                    <div class="track-detail-item" style="grid-column:1/-1;">
                        <div style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);border-radius:10px;padding:10px 14px;">
                            <p style="font-size:11px;color:#f87171;text-transform:uppercase;font-weight:500;margin-bottom:2px;">
                                <i class="fa-solid fa-clock"></i> Payment Deadline
                            </p>
                            <p style="color:#ef4444;margin:0;font-weight:600;font-size:14px;">
                                {{ $booking->payment_due_at->format('H:i') }} WIB — Auto-cancelled if unpaid
                            </p>
                        </div>
                    </div>
                    @endif
                </div>

                @if($booking->notes)
                    <div style="margin-top:16px;padding-top:12px;border-top:1px solid var(--border-default);">
                        <p style="font-size:11px;color:var(--text-muted);text-transform:uppercase;font-weight:500;margin-bottom:4px;">Special Requests</p>
                        <p style="color:var(--text-secondary);background:var(--bg-surface-2);border-radius:8px;padding:10px 14px;font-size:13px;margin:0;">{{ $booking->notes }}</p>
                    </div>
                @endif

                {{-- Payment Button --}}
                @if($booking->payment_status !== 'paid' && in_array($booking->status, ['pending', 'confirmed']))
                    <div class="track-pay-btn" style="margin-top:16px;padding-top:12px;border-top:1px solid var(--border-default);text-align:center;">
                        <a href="{{ route('payment.pay', $booking) }}"
                           class="btn-gold track-pay-btn" style="padding:14px 36px;">
                            <i class="fa-solid fa-credit-card"></i>
                            @if($booking->total_amount)
                                Pay Now &mdash; Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                            @else
                                Pay Now
                            @endif
                        </a>
                    </div>
                @elseif($booking->payment_status === 'paid')
                    <div class="track-pay-btn" style="margin-top:16px;padding-top:12px;border-top:1px solid var(--border-default);text-align:center;">
                        <span style="display:inline-flex;align-items:center;gap:6px;background:rgba(34,197,94,0.15);color:#4ade80;font-weight:600;padding:12px 24px;border-radius:10px;">
                            <i class="fa-solid fa-check-circle"></i> Payment Completed
                        </span>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
