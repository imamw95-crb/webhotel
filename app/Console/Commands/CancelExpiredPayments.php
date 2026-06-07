<?php

namespace App\Console\Commands;

use App\Mail\BookingStatusChanged;
use App\Models\Booking;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

#[Signature('booking:auto-cancel-expired')]
#[Description('Batalkan otomatis booking yang sudah melebihi batas waktu pembayaran 3 jam')]
class CancelExpiredPayments extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $expiredBookings = Booking::where('status', 'pending')
            ->where('payment_due_at', '<=', now())
            ->where(function ($q) {
                $q->where('payment_status', '!=', 'paid')
                    ->orWhereNull('payment_status');
            })
            ->get();

        $count = 0;

        foreach ($expiredBookings as $booking) {
            $booking->update([
                'status' => 'cancelled',
                'payment_status' => 'expired',
            ]);

            // Kirim email notifikasi pembatalan ke pelanggan
            try {
                Mail::to($booking->email)->send(new BookingStatusChanged($booking));
            } catch (\Exception $e) {
                Log::warning('Gagal kirim email pembatalan otomatis', [
                    'booking_code' => $booking->booking_code,
                    'error' => $e->getMessage(),
                ]);
            }

            $count++;

            Log::info('Booking otomatis dibatalkan (batas pembayaran habis)', [
                'booking_code' => $booking->booking_code,
                'payment_due_at' => $booking->payment_due_at?->toDateTimeString(),
            ]);

            $this->info("Booking {$booking->booking_code} has been auto-cancelled (payment expired).");
        }

        $this->info("Total {$count} expired booking(s) have been cancelled.");

        return Command::SUCCESS;
    }
}
