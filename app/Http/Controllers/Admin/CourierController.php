<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $couriers = Courier::latest()->paginate(15);
        return view('admin.couriers.index', compact('couriers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.couriers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tracking_url' => 'nullable|url|max:500',
            'is_active' => 'boolean',
        ]);

        Courier::create($validated);

        return redirect()->route('admin.couriers.index')
            ->with('success', 'Courier creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Courier $courier)
    {
        return view('admin.couriers.show', compact('courier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Courier $courier)
    {
        return view('admin.couriers.edit', compact('courier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Courier $courier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tracking_url' => 'nullable|url|max:500',
            'is_active' => 'boolean',
        ]);

        $courier->update($validated);

        return redirect()->route('admin.couriers.index')
            ->with('success', 'Courier actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Courier $courier)
    {
        $courier->delete();

        return redirect()->route('admin.couriers.index')
            ->with('success', 'Courier eliminado exitosamente.');
    }
}
