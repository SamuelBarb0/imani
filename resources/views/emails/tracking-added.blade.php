<x-mail::message>
# ¡Tu pedido está en camino!

Hola **{{ $order->customer_name }}**,

¡Excelentes noticias! Tu pedido ha sido enviado y está en camino a tu dirección.

## Información de Envío

**Número de Pedido:** {{ $order->order_number }}
**Fecha de Envío:** {{ $order->shipped_at->format('d/m/Y H:i') }}
**Courier:** {{ \App\Models\Order::getCouriers()[$order->courier] ?? $order->courier }}
**Número de Tracking:** `{{ $order->tracking_number }}`

## Detalles del Pedido

### Productos

@foreach($order->items as $item)
- **{{ $item->product_name }}** - Cantidad: {{ $item->quantity }}
@endforeach

---

**Total:** ${{ number_format($order->total, 2) }}

## Dirección de Entrega

{{ $order->shipping_address }}
{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}
{{ $order->shipping_country }}

## Seguimiento de tu Pedido

Puedes usar el número de tracking para seguir tu pedido en el sitio web del courier. Los tiempos de entrega pueden variar según tu ubicación.

<x-mail::button :url="route('user.order.show', $order->order_number)">
Ver detalles del pedido
</x-mail::button>

Si tienes alguna pregunta sobre tu envío, no dudes en contactarnos.

¡Gracias por tu compra!<br>
{{ config('app.name') }}

---

**Nota:** Por favor, asegúrate de que alguien esté disponible para recibir el paquete en la dirección de entrega.
</x-mail::message>
