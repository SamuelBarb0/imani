<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Show the content editor for a specific page
     */
    public function edit($page = 'home')
    {
        $contents = PageContent::getPageContent($page);

        return view('admin.content.edit', [
            'page' => $page,
            'contents' => $contents,
        ]);
    }

    /**
     * Update page content
     */
    public function update(Request $request, $page)
    {
        $validated = $request->validate([
            'contents' => 'required|array',
            'contents.*.section' => 'required|string',
            'contents.*.key' => 'required|string',
            'contents.*.value' => 'nullable|string',
            'contents.*.type' => 'required|in:text,textarea,image,html',
        ]);

        foreach ($validated['contents'] as $content) {
            PageContent::set(
                $page,
                $content['section'],
                $content['key'],
                $content['value'] ?? '',
                $content['type']
            );
        }

        PageContent::clearCache();

        return redirect()->back()->with('success', 'Contenido actualizado exitosamente');
    }

    /**
     * Upload image
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:25600', // 25MB max
            'page' => 'required|string',
            'section' => 'required|string',
            'key' => 'required|string',
        ]);

        $file = $request->file('image');

        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Move file to public/images directory
        $file->move(public_path('images'), $filename);

        // Path relative to public folder
        $path = 'images/' . $filename;

        // Update database
        PageContent::set(
            $request->page,
            $request->section,
            $request->key,
            $path,
            'image'
        );

        PageContent::clearCache();

        return response()->json([
            'success' => true,
            'path' => $path,
            'url' => asset($path),
        ]);
    }

    /**
     * Delete image
     */
    public function deleteImage(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
            'page' => 'required|string',
            'section' => 'required|string',
            'key' => 'required|string',
        ]);

        // Delete from public/images directory
        $fullPath = public_path($request->path);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        // Clear from database
        PageContent::set(
            $request->page,
            $request->section,
            $request->key,
            '',
            'image'
        );

        PageContent::clearCache();

        return response()->json(['success' => true]);
    }

    /**
     * Get all pages list
     */
    public function index()
    {
        $pages = PageContent::select('page')
            ->distinct()
            ->pluck('page');

        return view('admin.content.index', compact('pages'));
    }
}
