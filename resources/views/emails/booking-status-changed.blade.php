@component('mail::message')
# Booking {{ ucfirst($booking->status) }}

Dear **{{ $booking->name }}**,

@if($booking->status === 'confirmed')
Your booking at **{{ config('app.name') }}** has been **confirmed**! We look forward to welcoming you.
@elseif($booking->status === 'cancelled')
Your booking at **{{ config('app.name') }}** has been **cancelled**. If this was a mistake, please contact us.
@else
Your booking status has been updated to **{{ $booking->status }}**.
@endif

## Booking Summary

| Detail | Info |
|:---|---:|
| **Booking Code** | **{{ $booking->booking_code }}** |
| **Check-in** | {{ \Carbon\Carbon::parse($booking->check_in)->format('l, d F Y') }} |
| **Check-out** | {{ \Carbon\Carbon::parse($booking->check_out)->format('l, d F Y') }} |
| **Guests** | {{ $booking->guests }} person(s) |
| **Status** | **{{ ucfirst($booking->status) }}** |

@if($booking->status === 'confirmed')
@component('mail::button', ['url' => url('/booking/track?code=' . $booking->booking_code)])
View Booking
@endcomponent
@endif

If you have any questions, please don't hesitate to contact us.

Thanks,<br>
**{{ config('app.name') }}**
@endcomponent
