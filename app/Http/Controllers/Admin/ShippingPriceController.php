<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Courier;
use App\Models\CourierPrice;
use Illuminate\Http\Request;

class ShippingPriceController extends Controller
{
    /**
     * Display shipping price matrix
     */
    public function index()
    {
        // Get all active couriers
        $couriers = Courier::where('is_active', true)->orderBy('name')->get();

        // Get all active cities with their provinces and existing courier prices
        $cities = City::where('is_active', true)
            ->with(['province', 'courierPrices.courier'])
            ->orderBy('name')
            ->get();

        return view('admin.shipping-prices.index', compact('couriers', 'cities'));
    }

    /**
     * Update shipping prices
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'prices' => 'required|array',
            'prices.*.*' => 'nullable|numeric|min:0|max:9999.99',
        ]);

        foreach ($validated['prices'] as $cityId => $couriers) {
            foreach ($couriers as $courierId => $price) {
                if ($price !== null && $price !== '') {
                    // Update or create courier price
                    CourierPrice::updateOrCreate(
                        [
                            'city_id' => $cityId,
                            'courier_id' => $courierId,
                        ],
                        [
                            'price' => $price,
                        ]
                    );
                } else {
                    // Delete if price is empty
                    CourierPrice::where('city_id', $cityId)
                        ->where('courier_id', $courierId)
                        ->delete();
                }
            }
        }

        return redirect()->route('admin.shipping-prices.index')
            ->with('success', 'Precios de envío actualizados exitosamente.');
    }
}
