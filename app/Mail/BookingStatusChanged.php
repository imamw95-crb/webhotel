<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking
    ) {}

    public function envelope(): Envelope
    {
        $subject = match ($this->booking->status) {
            'confirmed' => 'Booking Confirmed - '.config('app.name'),
            'cancelled' => 'Booking Cancelled - '.config('app.name'),
            default => 'Booking Update - '.config('app.name'),
        };

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.booking-status-changed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
