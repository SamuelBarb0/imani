<?php

namespace App\Http\Controllers;

use App\Models\ContentPage;

class PolicyController extends Controller
{
    /**
     * Display the specified policy page
     */
    public function show($slug)
    {
        $page = ContentPage::findBySlug($slug);

        if (!$page) {
            abort(404);
        }

        return view('politicas.show', compact('page'));
    }
}
