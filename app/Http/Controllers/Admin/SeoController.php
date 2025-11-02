<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeoController extends Controller
{
    /**
     * Display a listing of SEO settings
     */
    public function index()
    {
        $seoSettings = SeoSetting::orderBy('page')->paginate(15);

        return view('admin.seo.index', compact('seoSettings'));
    }

    /**
     * Show the form for creating new SEO settings
     */
    public function create()
    {
        $availablePages = $this->getAvailablePages();

        return view('admin.seo.create', compact('availablePages'));
    }

    /**
     * Store newly created SEO settings
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'page' => 'required|string|max:255|unique:seo_settings,page',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|max:2048',
            'og_type' => 'nullable|string|max:50',
            'twitter_card' => 'nullable|string|max:50',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
            'twitter_image' => 'nullable|image|max:2048',
            'canonical_url' => 'nullable|url',
            'index' => 'boolean',
            'follow' => 'boolean',
        ]);

        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $request->file('og_image')->store('seo/og-images', 'public');
        }

        // Handle Twitter image upload
        if ($request->hasFile('twitter_image')) {
            $validated['twitter_image'] = $request->file('twitter_image')->store('seo/twitter-images', 'public');
        }

        SeoSetting::create($validated);

        return redirect()->route('admin.seo.index')
            ->with('success', 'Configuración SEO creada exitosamente.');
    }

    /**
     * Show the form for editing SEO settings
     */
    public function edit(SeoSetting $seo)
    {
        return view('admin.seo.edit', compact('seo'));
    }

    /**
     * Update SEO settings
     */
    public function update(Request $request, SeoSetting $seo)
    {
        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|max:2048',
            'og_type' => 'nullable|string|max:50',
            'twitter_card' => 'nullable|string|max:50',
            'twitter_title' => 'nullable|string|max:255',
            'twitter_description' => 'nullable|string|max:500',
            'twitter_image' => 'nullable|image|max:2048',
            'canonical_url' => 'nullable|url',
            'index' => 'boolean',
            'follow' => 'boolean',
        ]);

        // Handle OG image upload
        if ($request->hasFile('og_image')) {
            // Delete old image
            if ($seo->og_image) {
                Storage::disk('public')->delete($seo->og_image);
            }
            $validated['og_image'] = $request->file('og_image')->store('seo/og-images', 'public');
        }

        // Handle Twitter image upload
        if ($request->hasFile('twitter_image')) {
            // Delete old image
            if ($seo->twitter_image) {
                Storage::disk('public')->delete($seo->twitter_image);
            }
            $validated['twitter_image'] = $request->file('twitter_image')->store('seo/twitter-images', 'public');
        }

        $seo->update($validated);

        return redirect()->route('admin.seo.index')
            ->with('success', 'Configuración SEO actualizada exitosamente.');
    }

    /**
     * Remove SEO settings
     */
    public function destroy(SeoSetting $seo)
    {
        // Delete associated images
        if ($seo->og_image) {
            Storage::disk('public')->delete($seo->og_image);
        }
        if ($seo->twitter_image) {
            Storage::disk('public')->delete($seo->twitter_image);
        }

        $seo->delete();

        return redirect()->route('admin.seo.index')
            ->with('success', 'Configuración SEO eliminada exitosamente.');
    }

    /**
     * Get available pages for SEO configuration
     */
    private function getAvailablePages(): array
    {
        return [
            'home' => 'Página Principal',
            'personalizados' => 'Personalizados',
            'colecciones' => 'Colecciones',
            'mayoristas' => 'Mayoristas',
            'gift-card' => 'Gift Card',
            'contacto' => 'Contacto',
            'tracking' => 'Rastrear Pedido',
        ];
    }
}
