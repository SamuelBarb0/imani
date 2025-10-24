<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_email',
        'customer_name',
        'status',
        'images_data',
        'final_template_path',
        'png_template_path',
        'total_price',
    ];

    protected $casts = [
        'images_data' => 'array',
        'total_price' => 'decimal:2',
    ];

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
}
