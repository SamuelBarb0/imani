<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmedEmail;
use App\Mail\TrackingAddedEmail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Services\TemplateGeneratorService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'total_revenue' => Order::where('payment_status', 'completed')->sum('total'),
            'total_users' => User::count(),
        ];

        $recentOrders = Order::with('items')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    /**
     * List all orders
     */
    public function orders(Request $request)
    {
        $query = Order::with('items');

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status !== '') {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order number or email
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show order details
     */
    public function showOrder($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show edit order form
     */
    public function editOrder($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update order
     */
    public function updateOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,payment_received,processing,shipped,completed,cancelled',
            'payment_status' => 'required|in:pending,completed,failed,refunded',
            'admin_notes' => 'nullable|string',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.show', $id)
            ->with('success', 'Pedido actualizado exitosamente.');
    }

    /**
     * Delete order
     */
    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);

        DB::beginTransaction();
        try {
            // Delete order items first
            $order->items()->delete();

            // Delete order
            $order->delete();

            DB::commit();

            return redirect()->route('admin.orders.index')
                ->with('success', 'Pedido eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Error al eliminar el pedido: ' . $e->getMessage());
        }
    }

    /**
     * List all users
     */
    public function users(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show edit user form
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update basic fields
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->role = $validated['role'];

        // Update preferences
        $user->newsletter_subscription = $request->has('newsletter_subscription');
        $user->social_media_consent = $request->has('social_media_consent');

        // Update password only if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Delete user
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Usuario '{$userName}' eliminado exitosamente.");
    }

    /**
     * Upload payment proof
     */
    public function uploadPaymentProof(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'payment_proof' => 'required|image|max:25600', // 25MB max
        ]);

        // Store file
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $filename = 'proof_' . $order->order_number . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('payment_proofs', $filename, 'public');

            $order->update([
                'payment_proof' => $path,
                'payment_status' => 'completed',
                'status' => 'payment_received',
            ]);

            // Send confirmation email to customer
            try {
                Mail::to($order->customer_email)->send(new OrderConfirmedEmail($order));
                $order->update(['email_order_confirmed' => true]);
                Log::info('Order confirmation email sent', ['order_id' => $order->id, 'email' => $order->customer_email]);
            } catch (\Exception $e) {
                Log::error('Failed to send order confirmation email', [
                    'order_id' => $order->id,
                    'email' => $order->customer_email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return redirect()->route('admin.orders.show', $id)
            ->with('success', 'Comprobante de pago cargado exitosamente y email enviado al cliente.');
    }

    /**
     * Add tracking number
     */
    public function addTracking(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'tracking_number' => 'required|string|max:255',
            'courier' => 'required|string',
        ]);

        // Find the courier and get its tracking URL
        $courier = \App\Models\Courier::where('name', $validated['courier'])->first();
        $trackingUrl = $courier?->tracking_url;

        $order->update([
            'tracking_number' => $validated['tracking_number'],
            'tracking_url' => $trackingUrl,
            'courier' => $validated['courier'],
            'status' => 'shipped',
            'shipped_at' => now(),
        ]);

        // Send tracking email to customer
        try {
            Mail::to($order->customer_email)->send(new TrackingAddedEmail($order));
            $order->update(['email_tracking_sent' => true]);
            Log::info('Tracking email sent', ['order_id' => $order->id, 'email' => $order->customer_email]);
        } catch (\Exception $e) {
            Log::error('Failed to send tracking email', [
                'order_id' => $order->id,
                'email' => $order->customer_email,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->route('admin.orders.show', $id)
            ->with('success', 'Número de tracking agregado, estado cambiado a Enviado y email enviado al cliente.');
    }

    /**
     * Confirm payment received
     */
    public function confirmPayment($id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'payment_status' => 'completed',
            'status' => 'payment_received',
        ]);

        // Send confirmation email to customer
        try {
            Mail::to($order->customer_email)->send(new OrderConfirmedEmail($order));
            $order->update(['email_order_confirmed' => true]);
            Log::info('Payment confirmation email sent', ['order_id' => $order->id, 'email' => $order->customer_email]);
        } catch (\Exception $e) {
            Log::error('Failed to send payment confirmation email', [
                'order_id' => $order->id,
                'email' => $order->customer_email,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->route('admin.orders.show', $id)
            ->with('success', 'Pago confirmado. Email enviado al cliente.');
    }

    /**
     * Download order as PDF
     */
    public function downloadOrderPDF($id)
    {
        $order = Order::with('items')->findOrFail($id);

        // Generate PDF in A4 format
        $pdf = Pdf::loadView('admin.orders.pdf', compact('order'))
            ->setPaper('a4', 'portrait')
            ->setOption('margin-top', 10)
            ->setOption('margin-right', 15)
            ->setOption('margin-bottom', 10)
            ->setOption('margin-left', 15);

        // Download with filename
        return $pdf->download('pedido-' . $order->order_number . '.pdf');
    }

    /**
     * Download order template with 9 images positioned
     */
    public function downloadOrderTemplate($id)
    {
        $order = Order::with('items')->findOrFail($id);

        // Find the order item with custom images (usually the personalized product)
        $customItem = $order->items->first(function ($item) {
            return !empty($item->custom_data) && isset($item->custom_data['images']);
        });

        if (!$customItem || empty($customItem->custom_data['images'])) {
            return back()->with('error', 'Este pedido no tiene imágenes personalizadas para generar el template.');
        }

        try {
            // If template already exists, return it
            if ($customItem->template_path && Storage::disk('public')->exists($customItem->template_path)) {
                $fullPath = Storage::disk('public')->path($customItem->template_path);
                return response()->download($fullPath, 'template-' . $order->order_number . '.png');
            }

            // Generate new template
            $templateService = new TemplateGeneratorService();
            $imagesData = $customItem->custom_data['images'];

            // Extract just the paths from the image data
            // Images are stored as ['index' => X, 'path' => Y] or just as strings
            $imagePaths = array_map(function ($imageData) {
                return is_array($imageData) ? $imageData['path'] : $imageData;
            }, $imagesData);

            // Validate we have exactly 9 images
            if (count($imagePaths) !== 9) {
                return back()->with('error', 'Se requieren exactamente 9 imágenes para generar el template.');
            }

            // Generate template
            $templatePath = $templateService->generateTemplate($order->order_number, $imagePaths);

            // Save template path to order item
            $customItem->update(['template_path' => $templatePath]);

            Log::info('Template generated successfully', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'template_path' => $templatePath,
            ]);

            // Download the generated template
            $fullPath = Storage::disk('public')->path($templatePath);
            return response()->download($fullPath, 'template-' . $order->order_number . '.png');
        } catch (\Exception $e) {
            Log::error('Failed to generate template', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Error al generar el template: ' . $e->getMessage());
        }
    }

    /**
     * Download template for a specific order item
     */
    public function downloadItemTemplate($orderId, $itemId)
    {
        $order = Order::findOrFail($orderId);
        $item = OrderItem::where('id', $itemId)
            ->where('order_id', $order->id)
            ->firstOrFail();

        // Verificar que el item tiene imágenes personalizadas
        if (empty($item->custom_data) || !isset($item->custom_data['images'])) {
            return back()->with('error', 'Este producto no tiene imágenes personalizadas.');
        }

        try {
            // If template already exists, return it
            if ($item->template_path && Storage::disk('public')->exists($item->template_path)) {
                $fullPath = Storage::disk('public')->path($item->template_path);
                return response()->download($fullPath, "template-{$order->order_number}-item-{$itemId}.png");
            }

            // Generate new template
            $templateService = new TemplateGeneratorService();
            $imagesData = $item->custom_data['images'];

            // Extract just the paths from the image data
            $imagePaths = array_map(function ($imageData) {
                return is_array($imageData) ? $imageData['path'] : $imageData;
            }, $imagesData);

            // Validate we have exactly 9 images
            if (count($imagePaths) !== 9) {
                return back()->with('error', 'Se requieren exactamente 9 imágenes para generar el template.');
            }

            // Generate template
            $templatePath = $templateService->generateTemplate($order->order_number, $imagePaths);

            // Save template path to order item
            $item->update(['template_path' => $templatePath]);

            Log::info('Template generated successfully for specific item', [
                'order_id' => $order->id,
                'item_id' => $itemId,
                'order_number' => $order->order_number,
                'template_path' => $templatePath,
            ]);

            // Download the generated template
            $fullPath = Storage::disk('public')->path($templatePath);
            return response()->download($fullPath, "template-{$order->order_number}-item-{$itemId}.png");
        } catch (\Exception $e) {
            Log::error('Failed to generate template for item', [
                'order_id' => $order->id,
                'item_id' => $itemId,
                'order_number' => $order->order_number,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Error al generar el template: ' . $e->getMessage());
        }
    }
}
