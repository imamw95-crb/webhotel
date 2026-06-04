<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Services\PmsApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncPmsReservation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying.
     */
    public int $backoff = 10;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Booking $booking,
        public array $reservationData
    ) {}

    /**
     * Execute the job.
     */
    public function handle(PmsApiService $pms): void
    {
        try {
            $result = $pms->createReservation($this->reservationData);

            if ($result['success']) {
                $pmsData = $result['data']['data'] ?? $result['data'] ?? [];
                $pmsResNumber = $pmsData['reservation_number'] ?? null;

                if ($pmsResNumber) {
                    $this->booking->updateQuietly(['pms_reservation_number' => $pmsResNumber]);
                    Log::info('PMS reservation synced successfully', [
                        'booking_code' => $this->booking->booking_code,
                        'pms_reservation_number' => $pmsResNumber,
                    ]);
                }
            } else {
                // Non-critical error: retry later via backoff
                $errorMsg = is_string($result['errors']) ? $result['errors'] : json_encode($result['errors'] ?? 'unknown');
                Log::warning('PMS API createReservation failed in job', [
                    'booking_code' => $this->booking->booking_code,
                    'errors' => $result['errors'] ?? 'unknown',
                ]);

                throw new \RuntimeException('PMS API reservation failed: '.$errorMsg);
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Network error: retry later
            Log::warning('PMS API connection timeout in job', [
                'booking_code' => $this->booking->booking_code,
                'error' => $e->getMessage(),
            ]);

            throw $e; // Will retry via backoff
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(?\Throwable $exception): void
    {
        Log::error('SyncPmsReservation job failed permanently', [
            'booking_code' => $this->booking->booking_code,
            'error' => $exception?->getMessage(),
        ]);
    }
}
