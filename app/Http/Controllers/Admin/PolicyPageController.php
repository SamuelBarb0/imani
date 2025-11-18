<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentPage;
use Illuminate\Http\Request;

class PolicyPageController extends Controller
{
    /**
     * Display a listing of all policy pages
     */
    public function index()
    {
        $pages = ContentPage::orderBy('title')->get();

        return view('admin.policies.index', compact('pages'));
    }

    /**
     * Show the form for editing the specified page
     */
    public function edit(ContentPage $page)
    {
        return view('admin.policies.edit', compact('page'));
    }

    /**
     * Update the specified page in storage
     */
    public function update(Request $request, ContentPage $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');

        $page->update($validated);

        return redirect()
            ->route('admin.policies.index')
            ->with('success', 'Página actualizada exitosamente');
    }
}
