<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    /**
     * Display the tracking form
     */
    public function index()
    {
        $seoPage = 'tracking';
        return view('tracking.index', compact('seoPage'));
    }

    /**
     * Search for an order by order number and optional email
     */
    public function track(Request $request)
    {
        $validated = $request->validate([
            'order_number' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
        ]);

        // Search for order by order number
        $query = Order::where('order_number', $validated['order_number']);

        // If email provided, add it to the query for security
        if (!empty($validated['email'])) {
            $query->where('customer_email', $validated['email']);
        }

        $order = $query->with(['items', 'user'])->first();

        if (!$order) {
            return back()
                ->withInput()
                ->with('error', 'No se encontró ningún pedido con ese número. Por favor verifica e intenta nuevamente.');
        }

        $seoPage = 'tracking';
        return view('tracking.show', compact('order', 'seoPage'));
    }
}
