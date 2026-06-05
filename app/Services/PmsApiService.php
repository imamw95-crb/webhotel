<?php

namespace App\Services;

use App\Models\RoomType;
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
     * Results are cached for 2 minutes per date combination.
     */
    public function getAvailableRooms(string $checkIn, string $checkOut): array
    {
        $cacheKey = 'pms_available_rooms|'.$checkIn.'|'.$checkOut;

        return Cache::remember($cacheKey, 120, function () use ($checkIn, $checkOut) {
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
        });
    }

    /**
     * Get room types grouped from PMS rooms data.
     * Uses the dedicated room-types/prices endpoint for accurate pricing.
     */
    public function getRoomTypes(): array
    {
        return Cache::remember('pms_room_types', 300, function () {
            // Prefer dedicated room-types/prices endpoint
            $typePrices = $this->getRoomTypePrices();
            if (! empty($typePrices)) {
                return $this->buildRoomTypesFromPrices($typePrices);
            }

            // Fallback: group from /api/rooms
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
     * Build room types array from dedicated room-types/prices endpoint data.
     */
    private function buildRoomTypesFromPrices(array $typePrices): array
    {
        $types = [];

        foreach ($typePrices as $type) {
            $price = $type['prices']['effective_min'] ?? 0;
            $types[] = [
                'name' => $type['name'],
                'key' => strtolower(str_replace(' ', '_', $type['name'])),
                'rooms' => [],
                'min_price' => $price,
                'max_price' => $price,
                'max_occupancy' => 2,
                'facilities' => [],
                'description' => $type['description'] ?? '',
                'code' => $type['code'] ?? '',
                'prices' => $type['prices'] ?? [],
            ];
        }

        return $types;
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
     * Ambil data tipe kamar dengan harga efektif dari PMS.
     * Endpoint: GET /api/room-types/prices
     */
    public function getRoomTypePrices(): array
    {
        try {
            $response = Http::withHeaders($this->headers())
                ->timeout($this->timeout)
                ->get("{$this->baseUrl}/api/room-types/prices");

            if ($response->successful()) {
                return $response->json('data') ?? [];
            }

            Log::warning('PMS API getRoomTypePrices failed', ['status' => $response->status()]);

            return [];
        } catch (\Exception $e) {
            Log::error('PMS API getRoomTypePrices error: '.$e->getMessage());

            return [];
        }
    }

    /**
     * Sinkronisasi harga tipe kamar dari PMS ke database lokal.
     * Mencocokkan berdasarkan kode (code) atau nama.
     *
     * @return array{updated: int, failed: int, errors: array}
     */
    public function syncRoomTypePrices(): array
    {
        $pmsTypes = $this->getRoomTypePrices();
        $updated = 0;
        $failed = 0;
        $errors = [];

        if (empty($pmsTypes)) {
            return ['updated' => 0, 'failed' => 0, 'errors' => ['No data from PMS']];
        }

        foreach ($pmsTypes as $pmsType) {
            try {
                // Cari local room type by code dulu, lalu by name
                $local = RoomType::where('code', $pmsType['code'])
                    ->orWhere('name', $pmsType['name'])
                    ->first();

                if (! $local) {
                    $failed++;
                    $errors[] = "Room type not found: {$pmsType['name']} ({$pmsType['code']})";

                    continue;
                }

                $effectiveMin = $pmsType['prices']['effective_min'] ?? 0;

                if ($effectiveMin > 0 && (float) $local->base_price !== (float) $effectiveMin) {
                    $local->update(['base_price' => $effectiveMin]);
                    $updated++;
                }
            } catch (\Exception $e) {
                $failed++;
                $errors[] = "Error updating {$pmsType['name']}: {$e->getMessage()}";
            }
        }

        // Clear cache agar data terbaru dipakai
        $this->clearCache();

        return ['updated' => $updated, 'failed' => $failed, 'errors' => $errors];
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
