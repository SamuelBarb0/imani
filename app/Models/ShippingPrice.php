<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingPrice extends Model
{
    protected $fillable = [
        'code_name',
        'price',
        'courier_name',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    /**
     * Get all shipping zones that use this price code
     */
    public function shippingZones()
    {
        return $this->hasMany(ShippingZone::class, 'price_code', 'code_name');
    }
}
