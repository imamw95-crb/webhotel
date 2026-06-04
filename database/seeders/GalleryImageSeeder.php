<?php

namespace Database\Seeders;

use App\Models\GalleryImage;
use Illuminate\Database\Seeder;

class GalleryImageSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            // Room images (only those with downloaded photos)
            ['title' => 'Deluxe Room', 'image_path' => 'room-types/deluxe/deluxe_01.jpg', 'category' => 'rooms', 'sort_order' => 1],
            ['title' => 'Deluxe Room - Angle 2', 'image_path' => 'room-types/deluxe/deluxe_02.jpg', 'category' => 'rooms', 'sort_order' => 2],
            ['title' => 'Executive Room', 'image_path' => 'room-types/executive/IMG_20260315_154622_380.jpg', 'category' => 'rooms', 'sort_order' => 3],
            ['title' => 'Executive Room - Angle 2', 'image_path' => 'room-types/executive/IMG_20260315_154645_649.jpg', 'category' => 'rooms', 'sort_order' => 4],
            ['title' => 'Executive Room - Angle 3', 'image_path' => 'room-types/executive/IMG_20260315_154656_154.jpg', 'category' => 'rooms', 'sort_order' => 5],
            ['title' => 'Family Room', 'image_path' => 'room-types/family-107/ChatGPT Image May 1, 2026, 08_26_58 AM.png', 'category' => 'rooms', 'sort_order' => 6],
        ];

        foreach ($images as $image) {
            GalleryImage::create($image);
        }
    }
}
