<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        $roomTypes = [
            [
                'code' => 'DELUXE',
                'name' => 'Deluxe Room',
                'description' => 'A comfortable Deluxe room with modern amenities, perfect for couples or solo travelers. Features a cozy bed, work desk, and en-suite bathroom with complimentary toiletries.',
                'base_price' => 350000,
                'max_occupancy' => 2,
                'max_adults' => 2,
                'max_children' => 0,
                'room_size' => '24 m²',
                'bed_configuration' => '1 Queen Bed',
                'image_path' => 'room-types/deluxe/deluxe_01.jpg',
                'gallery' => [
                    'room-types/deluxe/deluxe_01.jpg',
                    'room-types/deluxe/deluxe_02.jpg',
                    'room-types/deluxe/deluxe_03.jpg',
                    'room-types/deluxe/deluxe_04.jpg',
                    'room-types/deluxe/deluxe_05.jpg',
                ],
                'facilities' => ['Air Conditioning', 'TV', 'WiFi', 'Shower', 'Work Desk'],
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'code' => 'EXECUTIVE',
                'name' => 'Executive Garden View',
                'description' => 'Spacious executive room with stunning garden views. Features a separate seating area, premium amenities, and a luxurious bathroom. Ideal for business travelers.',
                'base_price' => 550000,
                'max_occupancy' => 3,
                'max_adults' => 2,
                'max_children' => 1,
                'room_size' => '32 m²',
                'bed_configuration' => '1 King Bed',
                'image_path' => 'room-types/executive/IMG_20260315_154622_380.jpg',
                'gallery' => [
                    'room-types/executive/IMG_20260315_154622_380.jpg',
                    'room-types/executive/IMG_20260315_154645_649.jpg',
                    'room-types/executive/IMG_20260315_154656_154.jpg',
                    'room-types/executive/IMG_20260315_154701_711.jpg',
                    'room-types/executive/IMG_20260315_154713_515.jpg',
                    'room-types/executive/IMG_20260315_154717_012.jpg',
                    'room-types/executive/IMG_20260315_154721_502.jpg',
                    'room-types/executive/IMG_20260315_154759_691.jpg',
                ],
                'facilities' => ['Air Conditioning', 'TV', 'WiFi', 'Bathtub', 'Mini Bar', 'Garden View', 'Sitting Area'],
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'code' => 'FAMILY',
                'name' => 'Family 107',
                'description' => 'Perfect for families, this room offers ample space with multiple beds and family-friendly amenities. Enjoy quality time together in a comfortable setting.',
                'base_price' => 750000,
                'max_occupancy' => 5,
                'max_adults' => 4,
                'max_children' => 2,
                'room_size' => '40 m²',
                'bed_configuration' => '2 Queen Beds',
                'image_path' => 'room-types/family-107/ChatGPT Image May 1, 2026, 08_26_58 AM.png',
                'gallery' => [
                    'room-types/family-107/ChatGPT Image May 1, 2026, 08_26_58 AM.png',
                    'room-types/family-107/ChatGPT Image May 10, 2026, 01_09_44 PM.png',
                ],
                'facilities' => ['Air Conditioning', 'TV', 'WiFi', 'Refrigerator', 'Family Room'],
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'code' => 'SUPERIOR',
                'name' => 'Superior 109',
                'description' => 'A well-appointed superior room offering excellent value. Features modern furnishings, a comfortable bed, and all essential amenities for a pleasant stay.',
                'base_price' => 450000,
                'max_occupancy' => 3,
                'max_adults' => 2,
                'max_children' => 1,
                'room_size' => '28 m²',
                'bed_configuration' => '1 Queen Bed + 1 Single Bed',
                'image_path' => null,
                'gallery' => null,
                'facilities' => ['Air Conditioning', 'TV', 'WiFi', 'Shower', 'Work Desk'],
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'code' => 'JUNIOR',
                'name' => 'Junior Suite',
                'description' => 'Our Junior Suite offers a blend of comfort and style with a separate living area. Enjoy upgraded amenities and extra space for a truly relaxing stay.',
                'base_price' => 650000,
                'max_occupancy' => 4,
                'max_adults' => 3,
                'max_children' => 1,
                'room_size' => '36 m²',
                'bed_configuration' => '1 King Bed + Sofa Bed',
                'image_path' => null,
                'gallery' => null,
                'facilities' => ['Air Conditioning', 'TV', 'WiFi', 'Bathtub', 'Living Area', 'Mini Bar'],
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'code' => 'ICON5',
                'name' => 'ICON 5',
                'description' => 'The premium ICON 5 room features luxurious furnishings, panoramic views, and exclusive amenities. Our most prestigious accommodation for discerning guests.',
                'base_price' => 950000,
                'max_occupancy' => 4,
                'max_adults' => 3,
                'max_children' => 1,
                'room_size' => '45 m²',
                'bed_configuration' => '1 King Bed + 1 Single Bed',
                'image_path' => null,
                'gallery' => null,
                'facilities' => ['Air Conditioning', 'TV', 'WiFi', 'Bathtub', 'Living Room', 'Panoramic View', 'Mini Bar'],
                'sort_order' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($roomTypes as $roomType) {
            RoomType::create($roomType);
        }
    }
}
