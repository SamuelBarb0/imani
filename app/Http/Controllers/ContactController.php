<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'comentarios' => 'required|string|max:2000',
        ]);

        $fullName = $validated['nombre'].' '.$validated['apellido'];

        try {
            // Send confirmation email to customer
            Mail::send('emails.contact-form', [
                'name' => $fullName,
                'userMessage' => $validated['comentarios'],
            ], function ($message) use ($validated, $fullName) {
                $message->to($validated['correo'], $fullName)
                    ->subject('Hemos recibido tu mensaje - Imani Magnets');
            });

            // Send notification to admin
            Mail::send('emails.contact-form', [
                'name' => 'Admin',
                'userMessage' => "Nueva consulta de contacto:\n\n".
                    "Nombre: {$fullName}\n".
                    "Email: {$validated['correo']}\n".
                    "Mensaje: {$validated['comentarios']}",
            ], function ($message) use ($fullName, $validated) {
                $message->to(config('mail.admin_email', 'contacto@imanimagnets.com'))
                    ->replyTo($validated['correo'], $fullName)
                    ->subject('Nueva Consulta de Contacto - '.$fullName);
            });

            return back()->with('success', '¡Gracias por tu mensaje! Te responderemos pronto.');
        } catch (\Exception $e) {
            Log::error('Error sending contact form email: '.$e->getMessage());

            return back()->with('error', 'Hubo un error al enviar tu mensaje. Por favor intenta nuevamente.');
        }
    }
}
