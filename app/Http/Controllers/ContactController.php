<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormEmail;
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
            Mail::to($validated['correo'])
                ->send(new ContactFormEmail(
                    name: $fullName,
                    email: $validated['correo'],
                    userMessage: $validated['comentarios']
                ));

            Log::info('Contact form email sent', [
                'name' => $fullName,
                'email' => $validated['correo']
            ]);

            return back()->with('success', '¡Gracias por tu mensaje! Te responderemos pronto.');
        } catch (\Exception $e) {
            Log::error('Error sending contact form email: '.$e->getMessage());

            return back()->with('error', 'Hubo un error al enviar tu mensaje. Por favor intenta nuevamente.');
        }
    }
}
