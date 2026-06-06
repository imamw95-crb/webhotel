<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class GalleryController extends Controller
{
    /**
     * Max width for uploaded images (larger will be scaled down).
     */
    private const MAX_IMAGE_WIDTH = 1920;

    /**
     * WebP quality (0-100).
     */
    private const WEBP_QUALITY = 80;

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

        $uploaded = $request->file('image');
        $path = $this->optimizeAndStore($uploaded, 'gallery');
        $validated['image_path'] = $path;
        unset($validated['image']);
        $validated['is_active'] = $request->boolean('is_active', true);

        GalleryImage::create($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Image uploaded and optimized successfully.');
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
            // Delete old image
            if ($gallery->image_path) {
                Storage::disk('public')->delete($gallery->image_path);
            }

            $uploaded = $request->file('image');
            $path = $this->optimizeAndStore($uploaded, 'gallery');
            $validated['image_path'] = $path;
        }

        $validated['is_active'] = $request->boolean('is_active', false);
        $gallery->update($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Image updated successfully.');
    }

    public function destroy(GalleryImage $gallery)
    {
        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Image deleted successfully.');
    }

    /**
     * Optimize an uploaded image: scale down, convert to WebP, and store.
     *
     * @return string The relative path of the stored image.
     */
    private function optimizeAndStore($uploaded, string $directory): string
    {
        // Read the uploaded image
        $image = Image::decode($uploaded->getRealPath());

        // Scale down if wider than max width (maintains aspect ratio)
        $image->scaleDown(width: self::MAX_IMAGE_WIDTH);

        // Generate a unique filename with .webp extension
        $filename = uniqid('img_', true).'.webp';
        $relativePath = $directory.'/'.$filename;
        $fullPath = Storage::disk('public')->path($relativePath);

        // Ensure directory exists
        $dir = dirname($fullPath);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Save as WebP with defined quality
        $image->save($fullPath);

        return $relativePath;
    }
}
