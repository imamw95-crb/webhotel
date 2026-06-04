<?php

namespace Database\Seeders;

use App\Models\WebsiteSetting;
use Illuminate\Database\Seeder;

class WebsiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'hotel_name', 'value' => 'The Icon Hotel', 'type' => 'text', 'group' => 'general'],
            ['key' => 'hotel_tagline', 'value' => 'Comfortable for Family', 'type' => 'text', 'group' => 'general'],
            ['key' => 'hotel_description', 'value' => 'A 4-star hotel in Kuningan offering an unforgettable stay experience.', 'type' => 'textarea', 'group' => 'general'],
            ['key' => 'copyright_text', 'value' => 'Copyright 2026 © The Icon Hotel Kuningan', 'type' => 'text', 'group' => 'general'],

            // Contact
            ['key' => 'address', 'value' => 'Kuningan, West Java, Indonesia', 'type' => 'textarea', 'group' => 'contact'],
            ['key' => 'phone', 'value' => '0232-8951008', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'email', 'value' => 'info@theicon.id', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'whatsapp', 'value' => '6282116687862', 'type' => 'text', 'group' => 'contact'],

            // Social
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/theiconhotelkuningan', 'type' => 'text', 'group' => 'social'],
            ['key' => 'facebook_url', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'twitter_url', 'value' => '', 'type' => 'text', 'group' => 'social'],
            ['key' => 'tiktok_url', 'value' => '', 'type' => 'text', 'group' => 'social'],

            // SEO
            ['key' => 'meta_title', 'value' => 'The Icon Hotel Kuningan - 4-Star Hotel in West Java', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Experience luxury and comfort at The Icon Hotel Kuningan. 29 rooms, 4 types, premium facilities. Book now!', 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'hotel kuningan, the icon hotel, hotel murah kuningan, hotel bintang 4', 'type' => 'text', 'group' => 'seo'],

            // Payment - Bank Accounts
            ['key' => 'bank_name_1', 'value' => 'Bank BCA', 'type' => 'text', 'group' => 'payment'],
            ['key' => 'bank_account_1', 'value' => '1234567890', 'type' => 'text', 'group' => 'payment'],
            ['key' => 'bank_holder_1', 'value' => 'PT The Icon Hotel', 'type' => 'text', 'group' => 'payment'],
            ['key' => 'bank_name_2', 'value' => 'Bank Mandiri', 'type' => 'text', 'group' => 'payment'],
            ['key' => 'bank_account_2', 'value' => '0987654321', 'type' => 'text', 'group' => 'payment'],
            ['key' => 'bank_holder_2', 'value' => 'PT The Icon Hotel', 'type' => 'text', 'group' => 'payment'],
            ['key' => 'receptionist_phone', 'value' => '6282116687862', 'type' => 'text', 'group' => 'payment'],
        ];

        foreach ($settings as $setting) {
            WebsiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
