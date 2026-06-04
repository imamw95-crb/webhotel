<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = WebsiteSetting::orderBy('group')->orderBy('key')->get();
        $grouped = $settings->groupBy('group');

        return view('admin.settings.index', compact('grouped'));
    }

    public function update(Request $request)
    {
        $settings = $request->input('settings', []);

        foreach ($settings as $key => $value) {
            $existing = WebsiteSetting::where('key', $key)->first();
            if ($existing) {
                $existing->update(['value' => $value]);
            } else {
                WebsiteSetting::create([
                    'key' => $key,
                    'value' => $value,
                    'type' => 'text',
                    'group' => 'general',
                ]);
            }
        }

        // Clear all setting caches
        foreach ($settings as $key => $value) {
            Cache::forget("setting_{$key}");
        }
        WebsiteSetting::clearGroupCache('general');
        WebsiteSetting::clearGroupCache('contact');
        WebsiteSetting::clearGroupCache('social');
        WebsiteSetting::clearGroupCache('seo');

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
