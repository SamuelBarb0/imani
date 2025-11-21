<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckoutMessage extends Model
{
    protected $fillable = [
        'key',
        'content',
        'type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the active message for checkout page
     */
    public static function getActiveMessage(): ?self
    {
        return self::where('is_active', true)->first();
    }
}
