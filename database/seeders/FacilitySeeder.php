<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            ['name' => 'Meeting Room', 'icon' => 'fa-solid fa-users', 'description' => '2 meeting rooms available for business events', 'sort_order' => 1],
            ['name' => 'Swimming Pool (Hot Water)', 'icon' => 'fa-solid fa-water-ladder', 'description' => 'Enjoy our warm swimming pool', 'sort_order' => 2],
            ['name' => 'Sky Terrace Restaurant', 'icon' => 'fa-solid fa-utensils', 'description' => 'Rooftop dining with panoramic views', 'sort_order' => 3],
            ['name' => 'SPA', 'icon' => 'fa-solid fa-spa', 'description' => 'Relax and rejuvenate at our spa', 'sort_order' => 4],
            ['name' => 'Parking Area', 'icon' => 'fa-solid fa-square-parking', 'description' => 'Spacious and secure parking area', 'sort_order' => 5],
            ['name' => 'Mushola', 'icon' => 'fa-solid fa-mosque', 'description' => 'Clean and comfortable prayer room', 'sort_order' => 6],
            ['name' => 'Convenience Store', 'icon' => 'fa-solid fa-store', 'description' => 'Daily necessities available 24/7', 'sort_order' => 7],
            ['name' => 'WiFi Up To 100 Mbps', 'icon' => 'fa-solid fa-wifi', 'description' => 'High-speed internet throughout the hotel', 'sort_order' => 8],
            ['name' => '24 Hours Reception & Security', 'icon' => 'fa-solid fa-bell-concierge', 'description' => 'Round-the-clock service and safety', 'sort_order' => 9],
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}
