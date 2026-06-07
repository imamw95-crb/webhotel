<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'pms_reservation_number',
        'name',
        'email',
        'phone',
        'check_in',
        'check_out',
        'guests',
        'total_amount',
        'room_type',
        'room_id',
        'notes',
        'status',
        'payment_status',
        'payment_method',
        'paid_at',
        'payment_due_at',
        'source',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'guests' => 'integer',
        'room_id' => 'integer',
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'payment_due_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            if (empty($booking->booking_code)) {
                $booking->booking_code = static::generateBookingCode();
            }
        });
    }

    public static function generateBookingCode(): string
    {
        $prefix = 'ICN';
        do {
            $code = $prefix.strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 6));
        } while (static::where('booking_code', $code)->exists());

        return $code;
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByCode($query, string $code)
    {
        return $query->where('booking_code', $code);
    }

    public function scopePaymentDueExpired($query)
    {
        return $query->where('status', 'pending')
            ->where('payment_due_at', '<=', now())
            ->where(function ($q) {
                $q->where('payment_status', '!=', 'paid')
                    ->orWhereNull('payment_status');
            });
    }

    public function scopeAwaitingPayment($query)
    {
        return $query->where('payment_due_at', '>', now())
            ->where(function ($q) {
                $q->where('payment_status', '!=', 'paid')
                    ->orWhereNull('payment_status');
            });
    }

    public function nights(): int
    {
        return max(Carbon::parse($this->check_in)->diffInDays(Carbon::parse($this->check_out)), 1);
    }

    public function nightsLabel(): string
    {
        $n = $this->nights();

        return $n.' night'.($n > 1 ? 's' : '');
    }
}
