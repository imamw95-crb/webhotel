<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $images = GalleryImage::ordered()->paginate(24);

        return view('admin.gallery.index', compact('images'));
    }

    public function create()
    {
        return view('admin.gallery.form', ['image' => null]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'category' => 'nullable|string|max:50',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $path = $request->file('image')->store('gallery', 'public');
        $validated['image_path'] = $path;
        unset($validated['image']);
        $validated['is_active'] = $request->boolean('is_active', true);

        GalleryImage::create($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Image uploaded successfully.');
    }

    public function edit(GalleryImage $gallery)
    {
        return view('admin.gallery.form', ['image' => $gallery]);
    }

    public function update(Request $request, GalleryImage $gallery)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'category' => 'nullable|string|max:50',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('gallery', 'public');
            $validated['image_path'] = $path;
        }

        $validated['is_active'] = $request->boolean('is_active', false);
        $gallery->update($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Image updated successfully.');
    }

    public function destroy(GalleryImage $gallery)
    {
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Image deleted successfully.');
    }
}
