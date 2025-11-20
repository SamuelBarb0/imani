<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
        'custom_data',
    ];

    protected $casts = [
        'custom_data' => 'array',
        'price' => 'decimal:2',
    ];

    /**
     * Get the cart that owns the item.
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the subtotal for this item.
     */
    public function getSubtotal(): float
    {
        return $this->price * $this->quantity;
    }

    /**
     * Get the product name based on product_id.
     */
    public function getProductName(): string
    {
        // Check if it's a collection
        if (str_starts_with($this->product_id, 'collection-')) {
            $name = $this->custom_data['name'] ?? 'Colección';
            // Remove any HTML tags (like <br>, <span>, etc.)
            return strip_tags($name);
        }

        return match ($this->product_id) {
            'custom-magnets-9' => 'Set de 9 Imanes Personalizados 2x2"',
            default => 'Producto Desconocido',
        };
    }

    /**
     * Get the product image based on product_id.
     */
    public function getProductImage(): ?string
    {
        // Check if it's a collection
        if (str_starts_with($this->product_id, 'collection-')) {
            $collectionId = (int) str_replace('collection-', '', $this->product_id);
            $collection = \App\Models\Collection::find($collectionId);
            return $collection ? $collection->image : null;
        }

        // Custom magnets don't have a static image
        return null;
    }
}
