<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CheckoutMessage;
use Illuminate\Http\Request;

class CheckoutMessageController extends Controller
{
    public function index()
    {
        $messages = CheckoutMessage::orderBy('created_at', 'desc')->get();
        return view('admin.checkout-messages.index', compact('messages'));
    }

    public function edit($id)
    {
        $message = CheckoutMessage::findOrFail($id);
        return view('admin.checkout-messages.edit', compact('message'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'type' => 'required|in:info,warning,vacation',
        ]);

        $message = CheckoutMessage::findOrFail($id);

        // Handle checkbox: if not present in request, it means it's unchecked
        $isActive = $request->has('is_active') && $request->is_active == '1';
        $validated['is_active'] = $isActive;

        // If activating this message, deactivate all others
        if ($isActive) {
            CheckoutMessage::where('id', '!=', $id)->update(['is_active' => false]);
        }

        $message->update($validated);

        return redirect()->route('admin.checkout-messages.index')
            ->with('success', 'Mensaje actualizado correctamente');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|unique:checkout_messages,key',
            'content' => 'required|string',
            'type' => 'required|in:info,warning,vacation',
            'is_active' => 'boolean',
        ]);

        // If activating this message, deactivate all others
        if ($request->has('is_active') && $request->is_active) {
            CheckoutMessage::query()->update(['is_active' => false]);
        }

        CheckoutMessage::create($validated);

        return redirect()->route('admin.checkout-messages.index')
            ->with('success', 'Mensaje creado correctamente');
    }

    public function destroy($id)
    {
        $message = CheckoutMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.checkout-messages.index')
            ->with('success', 'Mensaje eliminado correctamente');
    }
}
