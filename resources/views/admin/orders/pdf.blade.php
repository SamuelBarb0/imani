<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido {{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #333;
        }

        .header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #12463c;
        }

        .header h1 {
            color: #12463c;
            font-size: 24pt;
            margin-bottom: 5px;
        }

        .header .tagline {
            color: #5c533b;
            font-size: 10pt;
        }

        .order-info {
            background: #f8f8f8;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .order-info h2 {
            color: #12463c;
            font-size: 14pt;
            margin-bottom: 10px;
        }

        .info-grid {
            display: table;
            width: 100%;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            padding: 5px 10px 5px 0;
            font-weight: bold;
            width: 35%;
            color: #5c533b;
        }

        .info-value {
            display: table-cell;
            padding: 5px 0;
        }

        .section {
            margin-bottom: 25px;
        }

        .section h3 {
            color: #12463c;
            font-size: 12pt;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #c2b59b;
        }

        .address-box {
            background: #f8f8f8;
            padding: 12px;
            border-left: 4px solid #12463c;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table thead {
            background: #12463c;
            color: white;
        }

        table th {
            padding: 10px;
            text-align: left;
            font-size: 10pt;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        table tbody tr:nth-child(even) {
            background: #f8f8f8;
        }

        .totals {
            margin-top: 20px;
            float: right;
            width: 250px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }

        .totals-row.total {
            font-weight: bold;
            font-size: 13pt;
            color: #12463c;
            border-top: 2px solid #12463c;
            margin-top: 5px;
            padding-top: 10px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 9pt;
            font-weight: bold;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-payment_received { background: #d4edda; color: #155724; }
        .status-processing { background: #cce5ff; color: #004085; }
        .status-shipped { background: #d1ecf1; color: #0c5460; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }

        .payment-completed { background: #d4edda; color: #155724; }
        .payment-pending { background: #fff3cd; color: #856404; }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 9pt;
            color: #666;
        }

        .notes {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 12px;
            margin-top: 10px;
        }

        .notes strong {
            color: #856404;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>IMANI MAGNETS</h1>
        <div class="tagline">Pedido #{{ $order->order_number }}</div>
    </div>

    <!-- Order Information -->
    <div class="order-info">
        <h2>Información del Pedido</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Fecha:</div>
                <div class="info-value">{{ $order->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Estado:</div>
                <div class="info-value">
                    <span class="status-badge status-{{ $order->status }}">{{ $order->status_name }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Estado de Pago:</div>
                <div class="info-value">
                    <span class="status-badge payment-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Método de Pago:</div>
                <div class="info-value">{{ ucfirst($order->payment_method) }}</div>
            </div>
            @if($order->transaction_id)
            <div class="info-row">
                <div class="info-label">ID de Transacción:</div>
                <div class="info-value">{{ $order->transaction_id }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Customer Information -->
    <div class="section">
        <h3>Información del Cliente</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nombre:</div>
                <div class="info-value">{{ $order->customer_name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $order->customer_email }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Teléfono:</div>
                <div class="info-value">{{ $order->customer_phone ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <!-- Shipping Address -->
    <div class="section">
        <h3>Dirección de Envío</h3>
        <div class="address-box">
            {{ $order->shipping_address }}<br>
            {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}<br>
            {{ $order->shipping_country }}
        </div>
    </div>

    <!-- Tracking Information -->
    @if($order->tracking_number)
    <div class="section">
        <h3>Información de Envío</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Courier:</div>
                <div class="info-value">{{ \App\Models\Order::getCouriers()[$order->courier] ?? $order->courier }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Número de Tracking:</div>
                <div class="info-value"><strong>{{ $order->tracking_number }}</strong></div>
            </div>
            <div class="info-row">
                <div class="info-label">Fecha de Envío:</div>
                <div class="info-value">{{ $order->shipped_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>
    @endif

    <!-- Order Items -->
    <div class="section">
        <h3>Productos</h3>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th style="text-align: center;">Cantidad</th>
                    <th style="text-align: right;">Precio Unit.</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">${{ number_format($item->price, 2) }}</td>
                    <td style="text-align: right;">${{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Totals -->
    <div class="clearfix">
        <div class="totals">
            <div class="totals-row">
                <span>Subtotal:</span>
                <span>${{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div class="totals-row">
                <span>Envío:</span>
                <span>${{ number_format($order->shipping_cost, 2) }}</span>
            </div>
            <div class="totals-row total">
                <span>TOTAL:</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Notes -->
    @if($order->notes)
    <div class="section" style="clear: both; padding-top: 20px;">
        <h3>Notas del Cliente</h3>
        <div class="notes">
            <strong>Nota:</strong> {{ $order->notes }}
        </div>
    </div>
    @endif

    @if($order->admin_notes)
    <div class="section">
        <h3>Notas Internas (Admin)</h3>
        <div class="notes" style="background: #f8d7da; border-color: #dc3545;">
            <strong>Nota Interna:</strong> {{ $order->admin_notes }}
        </div>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p><strong>Imani Magnets</strong></p>
        <p>Email: hola@imanimagnets.com</p>
        <p>Este es un documento generado automáticamente.</p>
    </div>
</body>
</html>
