@component('mail::message')
# New Booking Request

A new booking request has been submitted via the website.

## Guest Details

| Detail | Info |
|:---|---:|
| **Name** | {{ $booking->name }} |
| **Email** | {{ $booking->email }} |
| **Phone** | {{ $booking->phone }} |
| **Booking Code** | {{ $booking->booking_code }} |
| **Check-in** | {{ \Carbon\Carbon::parse($booking->check_in)->format('l, d F Y') }} |
| **Check-out** | {{ \Carbon\Carbon::parse($booking->check_out)->format('l, d F Y') }} |
| **Guests** | {{ $booking->guests }} person(s) |
| **Room Type** | {{ $booking->room_type ?? '—' }} |
| **Notes** | {{ $booking->notes ?? '—' }} |

@component('mail::button', ['url' => route('admin.bookings.show', $booking)])
View Booking in Admin
@endcomponent

Thanks,<br>
**{{ config('app.name') }}**
@endcomponent
