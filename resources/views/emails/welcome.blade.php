<x-mail::message>
# ¡Bienvenido a Imani Magnets! 🎉

Hola **{{ $user->name }}**,

¡Gracias por tu compra! Hemos creado automáticamente una cuenta para que puedas hacer seguimiento a tus pedidos.

@if($orderNumber)
## Tu Pedido

**Número de pedido:** {{ $orderNumber }}

Puedes ver el estado de tu pedido en cualquier momento ingresando a tu cuenta.
@endif

## Tus Credenciales de Acceso

**Email:** {{ $user->email }}
**Contraseña temporal:** `{{ $password }}`

<x-mail::button :url="url('/cuenta')">
Acceder a Mi Cuenta
</x-mail::button>

## Importante

Por seguridad, te recomendamos cambiar tu contraseña después de iniciar sesión por primera vez.

---

Si tienes alguna pregunta sobre tu pedido, no dudes en contactarnos.

Gracias por confiar en Imani Magnets,<br>
{{ config('app.name') }}
</x-mail::message>
