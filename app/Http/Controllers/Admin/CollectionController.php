<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class CollectionController extends Controller
{
    /**
     * Display a listing of collections.
     */
    public function index()
    {
        $collections = Collection::orderBy('order')->get();
        return view('admin.collections.index', compact('collections'));
    }

    /**
     * Show the form for creating a new collection.
     */
    public function create()
    {
        return view('admin.collections.create');
    }

    /**
     * Store a newly created collection in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,heic,heif|max:51200',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,heic,heif|max:51200',
            'price' => 'required|numeric|min:0',
            'items' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
        ]);

        // Handle main image upload - convert to WebP
        if ($request->hasFile('image')) {
            $validated['image'] = $this->convertToWebP(
                $request->file('image'),
                'images',
                'collection_'
            );
        }

        // Handle gallery images upload - convert to WebP
        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $galleryImage) {
                // Limit to 7 images
                if ($index >= 7) {
                    break;
                }

                $galleryPaths[] = $this->convertToWebP(
                    $galleryImage,
                    'images/collections/gallery',
                    'gallery_' . $index . '_'
                );
            }
        }
        $validated['gallery'] = $galleryPaths;

        // Convert items string to array
        if ($request->filled('items')) {
            $items = array_map('trim', explode("\n", $request->items));
            $validated['items'] = array_filter($items); // Remove empty lines
        }

        $validated['is_active'] = $request->has('is_active');

        Collection::create($validated);

        return redirect()->route('admin.collections.index')
            ->with('success', 'Colección creada exitosamente.');
    }

    /**
     * Show the form for editing the specified collection.
     */
    public function edit(Collection $collection)
    {
        return view('admin.collections.edit', compact('collection'));
    }

    /**
     * Update the specified collection in storage.
     */
    public function update(Request $request, Collection $collection)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,heic,heif|max:51200',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,heic,heif|max:51200',
            'deleted_gallery.*' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'items' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
        ]);

        // Handle main image upload if new image provided - convert to WebP
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($collection->image && file_exists(public_path($collection->image))) {
                unlink(public_path($collection->image));
            }

            $validated['image'] = $this->convertToWebP(
                $request->file('image'),
                'images',
                'collection_'
            );
        }

        // Handle gallery images
        $currentGallery = $collection->gallery ?? [];

        // Remove deleted gallery images
        if ($request->has('deleted_gallery')) {
            foreach ($request->deleted_gallery as $deletedPath) {
                // Delete file from disk
                if (file_exists(public_path($deletedPath))) {
                    unlink(public_path($deletedPath));
                }

                // Remove from array
                $currentGallery = array_filter($currentGallery, function ($path) use ($deletedPath) {
                    return $path !== $deletedPath;
                });
            }
        }

        // Add new gallery images - convert to WebP
        if ($request->hasFile('gallery')) {
            $totalImages = count($currentGallery);

            foreach ($request->file('gallery') as $index => $galleryImage) {
                // Limit total gallery to 7 images
                if ($totalImages >= 7) {
                    break;
                }

                $currentGallery[] = $this->convertToWebP(
                    $galleryImage,
                    'images/collections/gallery',
                    'gallery_' . $index . '_'
                );
                $totalImages++;
            }
        }

        // Re-index array to avoid gaps
        $validated['gallery'] = array_values($currentGallery);

        // Convert items string to array
        if ($request->filled('items')) {
            $items = array_map('trim', explode("\n", $request->items));
            $validated['items'] = array_filter($items); // Remove empty lines
        } else {
            $validated['items'] = null;
        }

        $validated['is_active'] = $request->has('is_active');

        $collection->update($validated);

        return redirect()->route('admin.collections.index')
            ->with('success', 'Colección actualizada exitosamente.');
    }

    /**
     * Remove the specified collection from storage.
     */
    public function destroy(Collection $collection)
    {
        // Delete main image if exists
        if ($collection->image && file_exists(public_path($collection->image))) {
            unlink(public_path($collection->image));
        }

        // Delete gallery images if exist
        if ($collection->gallery && is_array($collection->gallery)) {
            foreach ($collection->gallery as $imagePath) {
                if (file_exists(public_path($imagePath))) {
                    unlink(public_path($imagePath));
                }
            }
        }

        $collection->delete();

        return redirect()->route('admin.collections.index')
            ->with('success', 'Colección eliminada exitosamente.');
    }

    /**
     * Convert and optimize image to WebP format
     */
    private function convertToWebP($uploadedFile, $directory, $prefix = '')
    {
        // Generate unique filename
        $filename = $prefix . time() . '_' . uniqid() . '.webp';
        $fullPath = public_path($directory);

        // Create directory if it doesn't exist
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }

        // Load and convert image to WebP
        $image = Image::read($uploadedFile->getPathname());

        // Resize if image is too large (max 1920px on longest side)
        $image->scaleDown(width: 1920, height: 1920);

        // Save as WebP with 85% quality for good balance between size and quality
        $image->toWebp(85)->save($fullPath . '/' . $filename);

        return $directory . '/' . $filename;
    }
}
