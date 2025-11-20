<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class WholesaleController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'celular' => 'required|string|max:20',
            'cantidad' => 'required|integer|min:1',
            'fecha' => 'required|date',
            'comentarios' => 'nullable|string|max:2000',
        ]);

        $fullName = $validated['nombre'].' '.$validated['apellido'];

        try {
            // Send confirmation email to customer
            Mail::send('emails.wholesale-form', [
                'name' => $fullName,
                'email' => $validated['correo'],
                'phone' => $validated['celular'],
                'quantity' => $validated['cantidad'],
                'deadline' => \Carbon\Carbon::parse($validated['fecha'])->format('d/m/Y'),
                'comment' => $validated['comentarios'] ?? '',
            ], function ($message) use ($validated, $fullName) {
                $message->to($validated['correo'], $fullName)
                    ->subject('Hemos recibido tu consulta por pedidos al por mayor – Imani Magnets ');
            });

            // Send notification to admin
            Mail::send('emails.wholesale-form', [
                'name' => 'Admin',
                'email' => $validated['correo'],
                'phone' => $validated['celular'],
                'quantity' => $validated['cantidad'],
                'deadline' => \Carbon\Carbon::parse($validated['fecha'])->format('d/m/Y'),
                'comment' => "Nueva solicitud de Por Mayor:\n\n".
                    "Nombre: {$fullName}\n".
                    "Email: {$validated['correo']}\n".
                    "Teléfono: {$validated['celular']}\n".
                    "Cantidad: {$validated['cantidad']}\n".
                    "Fecha necesaria: ".\Carbon\Carbon::parse($validated['fecha'])->format('d/m/Y')."\n".
                    ($validated['comentarios'] ? "Comentarios: {$validated['comentarios']}" : ''),
            ], function ($message) use ($fullName, $validated) {
                $message->to(config('mail.admin_email', 'mayorista@imanimagnets.com'))
                    ->replyTo($validated['correo'], $fullName)
                    ->subject('Nueva Solicitud de Por Mayor - '.$fullName);
            });

            return back()->with('success', '¡Gracias por tu interés! Pronto nos pondremos en contacto contigo.');
        } catch (\Exception $e) {
            Log::error('Error sending wholesale form email: '.$e->getMessage());

            return back()->with('error', 'Hubo un error al enviar tu solicitud. Por favor intenta nuevamente.');
        }
    }
}
