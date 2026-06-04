<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransService
{
    private bool $isProduction;

    private string $serverKey;

    private string $clientKey;

    public function __construct()
    {
        $this->isProduction = config('services.midtrans.is_production', false);
        $this->serverKey = config('services.midtrans.server_key', '');
        $this->clientKey = config('services.midtrans.client_key', '');

        // Configure Midtrans
        Config::$serverKey = $this->serverKey;
        Config::$isProduction = $this->isProduction;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function getClientKey(): string
    {
        return $this->clientKey;
    }

    /**
     * Get Snap transaction token for a booking.
     */
    public function getSnapToken(Booking $booking): ?string
    {
        $total = $booking->total_amount ?? 0;
        if ($total <= 0) {
            // Calculate from base price if not set
            $roomType = RoomType::where('name', $booking->room_type)->first();
            $pricePerNight = $roomType?->base_price ?? 0;
            $nights = Carbon::parse($booking->check_in)->diffInDays(Carbon::parse($booking->check_out));
            $total = $pricePerNight * max($nights, 1);
        }

        $params = [
            'transaction_details' => [
                'order_id' => 'BOOK-'.$booking->booking_code.'-'.time(),
                'gross_amount' => (int) $total,
            ],
            'customer_details' => [
                'first_name' => $booking->name,
                'email' => $booking->email,
                'phone' => $booking->phone,
            ],
            'item_details' => [
                [
                    'id' => $booking->room_type ?? 'ROOM',
                    'price' => (int) $total,
                    'quantity' => 1,
                    'name' => ($booking->room_type ?? 'Room').' - '.$booking->nightsLabel(),
                ],
            ],
        ];

        try {
            $token = Snap::getSnapToken($params);

            return $token;
        } catch (\Exception $e) {
            Log::error('Midtrans getSnapToken error: '.$e->getMessage());

            return null;
        }
    }

    /**
     * Verify Midtrans notification and update booking payment status.
     */
    public function handleNotification(array $notification): ?Booking
    {
        try {
            Transaction::notification($notification);
        } catch (\Exception $e) {
            Log::error('Midtrans notification verification failed: '.$e->getMessage());

            return null;
        }

        $orderId = $notification['order_id'] ?? '';
        $transactionStatus = $notification['transaction_status'] ?? '';
        $paymentType = $notification['payment_type'] ?? '';
        $fraudStatus = $notification['fraud_status'] ?? '';

        // Extract booking code from order_id: BOOK-{CODE}-{timestamp}
        preg_match('/^BOOK-([A-Z0-9]+)-/', $orderId, $matches);
        $bookingCode = $matches[1] ?? null;

        if (! $bookingCode) {
            Log::warning('Midtrans: Could not extract booking code from order_id', ['order_id' => $orderId]);

            return null;
        }

        $booking = Booking::byCode($bookingCode)->first();
        if (! $booking) {
            Log::warning('Midtrans: Booking not found', ['code' => $bookingCode]);

            return null;
        }

        $paymentStatus = 'unpaid';

        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            if ($fraudStatus === 'accept' || $fraudStatus === '') {
                $paymentStatus = 'paid';
            }
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            $paymentStatus = 'failed';
        } elseif ($transactionStatus === 'pending') {
            $paymentStatus = 'pending';
        }

        $booking->update([
            'payment_status' => $paymentStatus,
            'payment_method' => $paymentType,
            'paid_at' => $paymentStatus === 'paid' ? now() : $booking->paid_at,
        ]);

        return $booking;
    }
}
