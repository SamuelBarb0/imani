<x-mail::message>
# ¡Tu pago ha sido confirmado!

Hola **{{ $order->customer_name }}**,

¡Excelentes noticias! Hemos confirmado el pago de tu pedido y estamos procesando tu orden.

## Detalles del Pedido

**Número de Pedido:** {{ $order->order_number }}
**Fecha:** {{ $order->created_at->format('d/m/Y H:i') }}
**Total:** ${{ number_format($order->total, 2) }}

### Productos

@foreach($order->items as $item)
- **{{ $item->product_name }}** - Cantidad: {{ $item->quantity }} × ${{ number_format($item->price, 2) }} = ${{ number_format($item->subtotal, 2) }}
@endforeach

---

**Subtotal:** ${{ number_format($order->subtotal, 2) }}
**Envío:** ${{ number_format($order->shipping_cost, 2) }}
**Total:** ${{ number_format($order->total, 2) }}

## ¿Qué sigue?

Estamos preparando tu pedido con mucho cariño. Te enviaremos otro correo cuando tu pedido sea enviado, incluyendo el número de tracking para que puedas seguir tu paquete.

<x-mail::button :url="route('user.order.show', $order->order_number)">
Ver mi pedido
</x-mail::button>

Si tienes alguna pregunta, no dudes en contactarnos.

Gracias por tu compra,<br>
{{ config('app.name') }}

---

**Dirección de Envío:**
{{ $order->shipping_address }}
{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}
{{ $order->shipping_country }}
</x-mail::message>
