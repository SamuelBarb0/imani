<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;

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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'items' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
        ]);

        // Handle main image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $validated['image'] = 'images/' . $imageName;
        }

        // Handle gallery images upload
        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            $galleryDir = public_path('images/collections/gallery');

            // Create directory if it doesn't exist
            if (!file_exists($galleryDir)) {
                mkdir($galleryDir, 0755, true);
            }

            foreach ($request->file('gallery') as $index => $galleryImage) {
                // Limit to 6 images
                if ($index >= 6) {
                    break;
                }

                $galleryImageName = time() . '_' . $index . '_' . $galleryImage->getClientOriginalName();
                $galleryImage->move($galleryDir, $galleryImageName);
                $galleryPaths[] = 'images/collections/gallery/' . $galleryImageName;
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'deleted_gallery.*' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'items' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'required|integer|min:0',
        ]);

        // Handle main image upload if new image provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($collection->image && file_exists(public_path($collection->image))) {
                unlink(public_path($collection->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $validated['image'] = 'images/' . $imageName;
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

        // Add new gallery images
        if ($request->hasFile('gallery')) {
            $galleryDir = public_path('images/collections/gallery');

            // Create directory if it doesn't exist
            if (!file_exists($galleryDir)) {
                mkdir($galleryDir, 0755, true);
            }

            $totalImages = count($currentGallery);

            foreach ($request->file('gallery') as $index => $galleryImage) {
                // Limit total gallery to 6 images
                if ($totalImages >= 6) {
                    break;
                }

                $galleryImageName = time() . '_' . $index . '_' . $galleryImage->getClientOriginalName();
                $galleryImage->move($galleryDir, $galleryImageName);
                $currentGallery[] = 'images/collections/gallery/' . $galleryImageName;
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
}
