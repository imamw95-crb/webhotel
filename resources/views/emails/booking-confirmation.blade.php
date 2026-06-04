@component('mail::message')
# Booking Request Received

Dear **{{ $booking->name }}**,

Thank you for choosing **{{ config('app.name') }}**! Your booking request has been received and is currently pending confirmation.

## Booking Details

| Detail | Info |
|:---|---:|
| **Booking Code** | **{{ $booking->booking_code }}** |
| **Check-in** | {{ \Carbon\Carbon::parse($booking->check_in)->format('l, d F Y') }} (14:00) |
| **Check-out** | {{ \Carbon\Carbon::parse($booking->check_out)->format('l, d F Y') }} (12:00) |
| **Guests** | {{ $booking->guests }} person(s) |
| **Room Type** | {{ $booking->room_type ?? '—' }} |
| **Status** | {{ ucfirst($booking->status) }} |

@if($booking->notes)
**Special Requests:** {{ $booking->notes }}
@endif

You can check your booking status anytime using your booking code.

@component('mail::button', ['url' => url('/booking/track?code=' . $booking->booking_code)])
Track My Booking
@endcomponent

We will confirm your reservation shortly. If you have any questions, please contact us.

Thanks,<br>
**{{ config('app.name') }}**
@endcomponent
