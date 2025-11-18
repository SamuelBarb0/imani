<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $fillable = [
        'provincia',
        'canton',
        'parroquia',
        'price_code',
    ];

    /**
     * Get the shipping price for this zone
     */
    public function shippingPrice()
    {
        return $this->belongsTo(ShippingPrice::class, 'price_code', 'code_name');
    }

    /**
     * Get shipping price value for this zone
     */
    public function getShippingCost(): ?float
    {
        if (!$this->price_code) {
            return null;
        }

        $price = $this->shippingPrice;
        return $price ? (float) $price->price : null;
    }

    /**
     * Scope to find zone by location
     */
    public function scopeByLocation($query, string $provincia, string $canton, string $parroquia)
    {
        return $query->where('provincia', $provincia)
                    ->where('canton', $canton)
                    ->where('parroquia', $parroquia);
    }

    /**
     * Get all provinces
     */
    public static function getProvincias(): array
    {
        return self::distinct()->pluck('provincia')->sort()->values()->toArray();
    }

    /**
     * Get cantones for a provincia
     */
    public static function getCantones(string $provincia): array
    {
        return self::where('provincia', $provincia)
                   ->distinct()
                   ->pluck('canton')
                   ->sort()
                   ->values()
                   ->toArray();
    }

    /**
     * Get parroquias for a canton
     */
    public static function getParroquias(string $provincia, string $canton): array
    {
        return self::where('provincia', $provincia)
                   ->where('canton', $canton)
                   ->distinct()
                   ->pluck('parroquia')
                   ->sort()
                   ->values()
                   ->toArray();
    }
}
