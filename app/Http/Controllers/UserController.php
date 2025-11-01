<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Show user profile
     */
    public function profile()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->with('items')
            ->paginate(10);

        return view('user.profile', compact('user', 'orders'));
    }

    /**
     * Show edit profile form
     */
    public function edit()
    {
        return view('user.edit', ['user' => Auth::user()]);
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return redirect()->route('user.profile')
            ->with('success', 'Perfil actualizado exitosamente.');
    }

    /**
     * Show change password form
     */
    public function showChangePasswordForm()
    {
        return view('user.change-password');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'La contraseña actual no es correcta.'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('user.profile')
            ->with('success', 'Contraseña actualizada exitosamente.');
    }

    /**
     * Show user orders
     */
    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->with('items')
            ->paginate(15);

        return view('user.orders', compact('orders'));
    }

    /**
     * Show single order details
     */
    public function showOrder($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with('items')
            ->firstOrFail();

        return view('user.order-detail', compact('order'));
    }

    /**
     * Download template for a specific order item
     */
    public function downloadTemplate($orderNumber, $itemId)
    {
        // Verificar que la orden pertenece al usuario
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Buscar el item específico
        $item = \App\Models\OrderItem::where('id', $itemId)
            ->where('order_id', $order->id)
            ->firstOrFail();

        // Verificar que el item tiene un template
        if (!$item->template_path) {
            abort(404, 'Template no disponible para este producto');
        }

        // Verificar que el archivo existe
        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($item->template_path)) {
            abort(404, 'Template no encontrado');
        }

        $filePath = \Illuminate\Support\Facades\Storage::disk('public')->path($item->template_path);

        return response()->download($filePath, "imani_magnets_{$orderNumber}_{$itemId}.png");
    }
}
