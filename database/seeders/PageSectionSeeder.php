<?php

namespace Database\Seeders;

use App\Models\PageSection;
use Illuminate\Database\Seeder;

class PageSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'section_key' => 'hero',
                'title' => 'The Icon Hotel Kuningan',
                'subtitle' => 'Comfortable for Family',
                'content' => [
                    'description' => 'Experience luxury and comfort in the heart of Kuningan. A 4-star hotel offering an unforgettable stay for both business and leisure travelers.',
                    'cta_primary_text' => 'Booking Now',
                    'cta_primary_url' => '#booking',
                    'cta_secondary_text' => 'View Rooms',
                    'cta_secondary_url' => '#rooms',
                    'background_images' => [],
                ],
                'sort_order' => 1,
            ],
            [
                'section_key' => 'about',
                'title' => 'About The Icon Hotel',
                'subtitle' => 'Your Home Away From Home',
                'content' => [
                    'description' => 'The Icon Hotel is a 4-star hotel that offers an unforgettable stay experience for both business and leisure travelers. Located strategically in Kuningan, the hotel is adjacent to Kunan city center and only takes 15 minutes to reach. Close to several interesting places to visit in Kuningan. Just 5 minutes drive away from Gunung Ciremai National Park. Discover the minimalist and modern design, equipped with a range of services and facilities to ensure your comfort and convenience throughout your stay.',
                    'stats' => [
                        ['label' => 'Rooms', 'value' => '29'],
                        ['label' => 'Room Types', 'value' => '4'],
                        ['label' => 'Facilities', 'value' => '9+'],
                        ['label' => 'Service', 'value' => '24/7'],
                    ],
                ],
                'sort_order' => 2,
            ],
            [
                'section_key' => 'rooms_intro',
                'title' => 'Our Rooms',
                'subtitle' => '29 Rooms in 4 Different Types',
                'content' => [
                    'description' => 'Presidential Suite Room, Executive Garden View, Junior Suite Rooms, Deluxe Rooms. The hotel also has 2 meeting rooms. It is perfect for exploration by business & leisure travelers.',
                ],
                'sort_order' => 3,
            ],
            [
                'section_key' => 'facilities_intro',
                'title' => 'Hotel Facilities',
                'subtitle' => 'Everything You Need',
                'content' => [
                    'description' => 'We provide comprehensive facilities to make your stay comfortable and convenient.',
                ],
                'sort_order' => 4,
            ],
            [
                'section_key' => 'gallery_intro',
                'title' => 'Gallery',
                'subtitle' => 'Explore Our Hotel',
                'content' => [
                    'description' => 'Take a visual tour of our hotel and discover the beauty of The Icon Hotel Kuningan.',
                ],
                'sort_order' => 5,
            ],
            [
                'section_key' => 'location',
                'title' => 'Our Location',
                'subtitle' => 'Strategically Located in Kuningan',
                'content' => [
                    'address' => 'Kuningan, West Java, Indonesia',
                    'phone' => '0232-8951008',
                    'email' => 'info@theicon.id',
                    'whatsapp' => '6282116687862',
                    'instagram' => 'https://instagram.com/theiconhotelkuningan',
                    'map_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.8!2d108.4786!3d-6.9828!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTgnNTkuOSJTIDEwOMKwMjgnNDMuNiJF!5e0!3m2!1sen!2sid!4v1234567890',
                ],
                'sort_order' => 6,
            ],
            [
                'section_key' => 'contact',
                'title' => 'Get In Touch',
                'subtitle' => 'We\'d Love to Hear From You',
                'content' => [
                    'description' => 'Have questions or special requests? Send us a message and we\'ll get back to you as soon as possible.',
                ],
                'sort_order' => 7,
            ],
            [
                'section_key' => 'booking',
                'title' => 'Book Your Stay',
                'subtitle' => 'Reserve Your Room Today',
                'content' => [
                    'description' => 'Fill in the form below to book your stay at The Icon Hotel Kuningan. We\'ll confirm your reservation shortly.',
                ],
                'sort_order' => 8,
            ],
        ];

        foreach ($sections as $section) {
            PageSection::create($section);
        }
    }
}
