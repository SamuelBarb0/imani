<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingPrice;
use App\Models\ShippingZone;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    /**
     * Display shipping prices management
     */
    public function prices()
    {
        $prices = ShippingPrice::withCount('shippingZones')->get();
        return view('admin.shipping.prices', compact('prices'));
    }

    /**
     * Store new shipping price
     */
    public function storePrice(Request $request)
    {
        $validated = $request->validate([
            'code_name' => 'required|string|unique:shipping_prices,code_name|max:255',
            'price' => 'required|numeric|min:0',
            'courier_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        ShippingPrice::create($validated);

        return redirect()->route('admin.shipping.prices')
            ->with('success', 'Código de precio creado exitosamente');
    }

    /**
     * Update shipping price
     */
    public function updatePrice(Request $request, ShippingPrice $price)
    {
        $validated = $request->validate([
            'code_name' => 'required|string|max:255|unique:shipping_prices,code_name,' . $price->id,
            'price' => 'required|numeric|min:0',
            'courier_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $price->update($validated);

        return redirect()->route('admin.shipping.prices')
            ->with('success', 'Código de precio actualizado exitosamente');
    }

    /**
     * Delete shipping price
     */
    public function destroyPrice(ShippingPrice $price)
    {
        // Check if any zones are using this price code
        $zonesCount = $price->shippingZones()->count();

        if ($zonesCount > 0) {
            return redirect()->route('admin.shipping.prices')
                ->with('error', "No se puede eliminar. Este código está asignado a {$zonesCount} zonas.");
        }

        $price->delete();

        return redirect()->route('admin.shipping.prices')
            ->with('success', 'Código de precio eliminado exitosamente');
    }

    /**
     * Display shipping zones management
     */
    public function zones(Request $request)
    {
        $query = ShippingZone::with('shippingPrice');

        // Filter by provincia
        if ($request->filled('provincia')) {
            $query->where('provincia', $request->provincia);
        }

        // Filter by canton
        if ($request->filled('canton')) {
            $query->where('canton', $request->canton);
        }

        // Filter by price code
        if ($request->filled('price_code')) {
            if ($request->price_code === 'null') {
                $query->whereNull('price_code');
            } else {
                $query->where('price_code', $request->price_code);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('provincia', 'like', "%{$search}%")
                  ->orWhere('canton', 'like', "%{$search}%")
                  ->orWhere('parroquia', 'like', "%{$search}%");
            });
        }

        $zones = $query->paginate(50);

        $provincias = ShippingZone::getProvincias();
        $prices = ShippingPrice::all();

        // Get cantones for selected provincia
        $cantones = [];
        if ($request->filled('provincia')) {
            $cantones = ShippingZone::getCantones($request->provincia);
        }

        return view('admin.shipping.zones', compact('zones', 'provincias', 'cantones', 'prices'));
    }

    /**
     * Store new shipping zone
     */
    public function storeZone(Request $request)
    {
        $validated = $request->validate([
            'provincia' => 'required|string|max:255',
            'canton' => 'required|string|max:255',
            'parroquia' => 'required|string|max:255',
            'price_code' => 'nullable|exists:shipping_prices,code_name',
        ]);

        // Check if zone already exists
        $existingZone = ShippingZone::byLocation(
            $validated['provincia'],
            $validated['canton'],
            $validated['parroquia']
        )->first();

        if ($existingZone) {
            return redirect()->back()
                ->with('error', 'Esta zona ya existe en el sistema');
        }

        ShippingZone::create($validated);

        return redirect()->route('admin.shipping.zones')
            ->with('success', 'Zona de envío creada exitosamente');
    }

    /**
     * Update zone price code
     */
    public function updateZone(Request $request, ShippingZone $zone)
    {
        $validated = $request->validate([
            'price_code' => 'nullable|exists:shipping_prices,code_name',
        ]);

        $zone->update($validated);

        return redirect()->back()
            ->with('success', 'Zona actualizada exitosamente');
    }

    /**
     * Delete shipping zone
     */
    public function destroyZone(ShippingZone $zone)
    {
        $zone->delete();

        return redirect()->back()
            ->with('success', 'Zona eliminada exitosamente');
    }

    /**
     * Bulk update zones
     */
    public function bulkUpdateZones(Request $request)
    {
        $validated = $request->validate([
            'zone_ids' => 'required|array',
            'zone_ids.*' => 'exists:shipping_zones,id',
            'price_code' => 'nullable|exists:shipping_prices,code_name',
        ]);

        ShippingZone::whereIn('id', $validated['zone_ids'])
            ->update(['price_code' => $validated['price_code'] ?? null]);

        $count = count($validated['zone_ids']);

        return redirect()->back()
            ->with('success', "{$count} zonas actualizadas exitosamente");
    }

    /**
     * Get cantones for a provincia (AJAX)
     */
    public function getCantones(Request $request)
    {
        $provincia = $request->provincia;
        $cantones = ShippingZone::getCantones($provincia);

        return response()->json($cantones);
    }

    /**
     * Get parroquias for a canton (AJAX)
     */
    public function getParroquias(Request $request)
    {
        $provincia = $request->provincia;
        $canton = $request->canton;
        $parroquias = ShippingZone::getParroquias($provincia, $canton);

        return response()->json($parroquias);
    }
}
