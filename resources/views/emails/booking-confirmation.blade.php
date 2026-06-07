@component('mail::message')
# Booking Request Received

Dear **{{ $booking->name }}**,

Thank you for choosing **{{ config('app.name') }}**! Your booking request has been received and is currently pending confirmation.

@if($booking->payment_due_at)
> ⏰ **Payment Deadline:** Please complete your payment within **3 hours** (before {{ $booking->payment_due_at->format('H:i') }}). Unpaid bookings will be **automatically cancelled** after the deadline.
@endif

## Booking Details

| Detail | Info |
|:---|---:|
| **Booking Code** | **{{ $booking->booking_code }}** |
| **Check-in** | {{ \Carbon\Carbon::parse($booking->check_in)->format('l, d F Y') }} (14:00) |
| **Check-out** | {{ \Carbon\Carbon::parse($booking->check_out)->format('l, d F Y') }} (12:00) |
| **Guests** | {{ $booking->guests }} person(s) |
| **Room Type** | {{ $booking->room_type ?? '—' }} |
| **Total Amount** | Rp {{ number_format($booking->total_amount ?? 0, 0, ',', '.') }} |
| **Status** | {{ ucfirst($booking->status) }} |

@if($booking->notes)
**Special Requests:** {{ $booking->notes }}
@endif

## Payment Instructions

Please transfer the total amount to one of our bank accounts and confirm your payment via WhatsApp. Your booking will be cancelled automatically if payment is not completed within **3 hours**.

@component('mail::button', ['url' => url('/booking/track?code=' . $booking->booking_code)])
Track My Booking
@endcomponent

If you have any questions, please contact us.

Thanks,<br>
**{{ config('app.name') }}**
@endcomponent
