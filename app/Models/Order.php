<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'session_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'document_type',
        'document_number',
        'billing_address',
        'billing_provincia',
        'billing_canton',
        'billing_parroquia',
        'billing_zip',
        'billing_country',
        'same_as_billing',
        'shipping_name',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_canton',
        'shipping_zip',
        'shipping_country',
        'subtotal',
        'shipping_cost',
        'tax',
        'total',
        'payment_method',
        'payment_status',
        'transaction_id',
        'payphone_transaction_id',
        'payment_proof',
        'tracking_number',
        'tracking_url',
        'courier',
        'shipped_at',
        'email_order_confirmed',
        'email_tracking_sent',
        'status',
        'notes',
        'admin_notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'shipped_at' => 'datetime',
        'email_order_confirmed' => 'boolean',
        'email_tracking_sent' => 'boolean',
        'same_as_billing' => 'boolean',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate a unique order number
     */
    public static function generateOrderNumber(): string
    {
        do {
            $number = 'IM-' . strtoupper(substr(uniqid(), -8));
        } while (self::where('order_number', $number)->exists());

        return $number;
    }

    /**
     * Get status name in Spanish
     */
    public function getStatusNameAttribute(): string
    {
        $statuses = [
            'pending' => 'Pendiente',
            'payment_received' => 'Pago Recibido',
            'processing' => 'En Proceso',
            'shipped' => 'Enviado',
            'completed' => 'Completado',
            'cancelled' => 'Cancelado',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Check if order requires payment proof (transfer)
     */
    public function requiresPaymentProof(): bool
    {
        return $this->payment_method === 'transfer' && !$this->payment_proof;
    }

    /**
     * Check if order can be shipped
     */
    public function canBeShipped(): bool
    {
        return $this->payment_status === 'completed' &&
               in_array($this->status, ['payment_received', 'processing']);
    }

    /**
     * Check if order needs tracking
     */
    public function needsTracking(): bool
    {
        return $this->status === 'processing' && !$this->tracking_number;
    }

    /**
     * Get available couriers
     */
    public static function getCouriers(): array
    {
        return [
            'servientrega' => 'Servientrega',
            'tramaco' => 'Tramaco',
            'laar' => 'Laar Courier',
            'urbano' => 'Urbano Express',
            'correos_ecuador' => 'Correos del Ecuador',
        ];
    }
}
