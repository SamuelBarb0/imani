<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourierPrice extends Model
{
    protected $fillable = [
        'courier_id',
        'city_id',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function courier(): BelongsTo
    {
        return $this->belongsTo(Courier::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
