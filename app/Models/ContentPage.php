<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentPage extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'content',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    /**
     * Find a page by its slug
     */
    public static function findBySlug(string $slug): ?self
    {
        return self::where('slug', $slug)
            ->where('is_published', true)
            ->first();
    }
}
