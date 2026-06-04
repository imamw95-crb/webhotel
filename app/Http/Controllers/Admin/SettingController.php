<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /** Whitelist of allowed setting keys with their group & type */
    private const ALLOWED_SETTINGS = [
        // General
        'hotel_name' => ['group' => 'general', 'type' => 'text'],
        'hotel_tagline' => ['group' => 'general', 'type' => 'text'],
        'hotel_description' => ['group' => 'general', 'type' => 'textarea'],
        'logo_path' => ['group' => 'general', 'type' => 'text'],
        'copyright_text' => ['group' => 'general', 'type' => 'text'],
        // Contact
        'phone' => ['group' => 'contact', 'type' => 'text'],
        'email' => ['group' => 'contact', 'type' => 'text'],
        'whatsapp' => ['group' => 'contact', 'type' => 'text'],
        'address' => ['group' => 'contact', 'type' => 'textarea'],
        // Payment / Bank
        'bank_name_1' => ['group' => 'payment', 'type' => 'text'],
        'bank_account_1' => ['group' => 'payment', 'type' => 'text'],
        'bank_holder_1' => ['group' => 'payment', 'type' => 'text'],
        'bank_name_2' => ['group' => 'payment', 'type' => 'text'],
        'bank_account_2' => ['group' => 'payment', 'type' => 'text'],
        'bank_holder_2' => ['group' => 'payment', 'type' => 'text'],
        'receptionist_phone' => ['group' => 'payment', 'type' => 'text'],
        // Social Media
        'instagram_url' => ['group' => 'social', 'type' => 'text'],
        'facebook_url' => ['group' => 'social', 'type' => 'text'],
        'twitter_url' => ['group' => 'social', 'type' => 'text'],
        'tiktok_url' => ['group' => 'social', 'type' => 'text'],
        // SEO
        'meta_title' => ['group' => 'seo', 'type' => 'text'],
        'meta_description' => ['group' => 'seo', 'type' => 'textarea'],
        'meta_keywords' => ['group' => 'seo', 'type' => 'text'],
    ];

    public function index()
    {
        $settings = WebsiteSetting::orderBy('group')->orderBy('key')->get();
        $grouped = $settings->groupBy('group');

        return view('admin.settings.index', compact('grouped'));
    }

    public function update(Request $request)
    {
        $settings = $request->input('settings', []);

        // Only process whitelisted keys
        $allowedKeys = array_keys(self::ALLOWED_SETTINGS);
        $invalidKeys = array_diff(array_keys($settings), $allowedKeys);

        if (! empty($invalidKeys)) {
            return redirect()->route('admin.settings.index')
                ->withErrors(['settings' => 'Invalid setting keys: '.implode(', ', $invalidKeys)])
                ->withInput();
        }

        foreach ($settings as $key => $value) {
            $config = self::ALLOWED_SETTINGS[$key];
            WebsiteSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'type' => $config['type'],
                    'group' => $config['group'],
                ]
            );
        }

        // Clear affected setting caches
        foreach ($settings as $key => $value) {
            Cache::forget("setting_{$key}");
        }

        // Clear all relevant group caches
        $affectedGroups = array_unique(array_column(array_intersect_key(self::ALLOWED_SETTINGS, $settings), 'group'));
        foreach ($affectedGroups as $group) {
            WebsiteSetting::clearGroupCache($group);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
