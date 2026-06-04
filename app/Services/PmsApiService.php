<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PmsApiService
{
    private string $baseUrl;

    private string $apiKey;

    private int $timeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.pms_api.url', 'http://127.0.0.1:8000'), '/');
        $this->apiKey = config('services.pms_api.key', '');
        $this->timeout = (int) config('services.pms_api.timeout', 10);
    }

    /**
     * Get all rooms from PMS API.
     */
    public function getRooms(): array
    {
        return Cache::remember('pms_rooms', 300, function () {
            try {
                $response = Http::withHeaders($this->headers())
                    ->timeout($this->timeout)
                    ->get("{$this->baseUrl}/api/rooms");

                if ($response->successful()) {
                    return $response->json('data') ?? $response->json() ?? [];
                }

                Log::warning('PMS API getRooms failed', ['status' => $response->status()]);

                return [];
            } catch (\Exception $e) {
                Log::error('PMS API getRooms error: '.$e->getMessage());

                return [];
            }
        });
    }

    /**
     * Get available rooms for a date range.
     */
    public function getAvailableRooms(string $checkIn, string $checkOut): array
    {
        try {
            $response = Http::withHeaders($this->headers())
                ->timeout($this->timeout)
                ->get("{$this->baseUrl}/api/rooms/available", [
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                ]);

            if ($response->successful()) {
                return $response->json('data') ?? $response->json() ?? [];
            }

            Log::warning('PMS API getAvailableRooms failed', ['status' => $response->status()]);

            return [];
        } catch (\Exception $e) {
            Log::error('PMS API getAvailableRooms error: '.$e->getMessage());

            return [];
        }
    }

    /**
     * Get room types grouped from PMS rooms data.
     */
    public function getRoomTypes(): array
    {
        return Cache::remember('pms_room_types', 300, function () {
            $rooms = $this->getRooms();
            $types = [];

            foreach ($rooms as $room) {
                $typeName = $room['room_type_name'] ?? $room['room_type'] ?? 'Standard';
                $typeKey = strtolower(str_replace(' ', '_', $typeName));

                if (! isset($types[$typeKey])) {
                    $types[$typeKey] = [
                        'name' => $typeName,
                        'key' => $typeKey,
                        'rooms' => [],
                        'min_price' => $room['price_per_night'] ?? $room['price'] ?? 0,
                        'max_price' => $room['price_per_night'] ?? $room['price'] ?? 0,
                        'max_occupancy' => $room['max_occupancy'] ?? 2,
                        'facilities' => $room['facilities'] ?? [],
                    ];
                }

                $types[$typeKey]['rooms'][] = $room;

                $price = $room['price_per_night'] ?? $room['price'] ?? 0;
                if ($price < $types[$typeKey]['min_price']) {
                    $types[$typeKey]['min_price'] = $price;
                }
                if ($price > $types[$typeKey]['max_price']) {
                    $types[$typeKey]['max_price'] = $price;
                }
            }

            return array_values($types);
        });
    }

    /**
     * Create a reservation via PMS API.
     */
    public function createReservation(array $data): array
    {
        try {
            $response = Http::withHeaders($this->headers())
                ->timeout($this->timeout)
                ->post("{$this->baseUrl}/api/reservations", $data);

            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()];
            }

            return ['success' => false, 'errors' => $response->json('errors') ?? $response->json()];
        } catch (\Exception $e) {
            Log::error('PMS API createReservation error: '.$e->getMessage());

            return ['success' => false, 'errors' => [$e->getMessage()]];
        }
    }

    /**
     * Clear all PMS API caches.
     */
    public function clearCache(): void
    {
        Cache::forget('pms_rooms');
        Cache::forget('pms_room_types');
    }

    private function headers(): array
    {
        $headers = ['Accept' => 'application/json'];
        if ($this->apiKey) {
            $headers['X-API-Key'] = $this->apiKey;
        }

        return $headers;
    }
}
