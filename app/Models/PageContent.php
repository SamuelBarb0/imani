<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PageContent extends Model
{
    protected $fillable = [
        'page',
        'section',
        'key',
        'type',
        'value',
        'order',
    ];

    /**
     * Get content value by page, section, and key
     * Uses caching for better performance
     */
    public static function get(string $page, string $section, string $key, $default = '')
    {
        $cacheKey = "page_content_{$page}_{$section}_{$key}";

        return Cache::remember($cacheKey, 3600, function () use ($page, $section, $key, $default) {
            $content = self::where('page', $page)
                ->where('section', $section)
                ->where('key', $key)
                ->first();

            return $content ? $content->value : $default;
        });
    }

    /**
     * Set content value (create or update)
     */
    public static function set(string $page, string $section, string $key, $value, string $type = 'text')
    {
        $content = self::updateOrCreate(
            [
                'page' => $page,
                'section' => $section,
                'key' => $key,
            ],
            [
                'value' => $value,
                'type' => $type,
            ]
        );

        // Clear cache
        Cache::forget("page_content_{$page}_{$section}_{$key}");

        return $content;
    }

    /**
     * Get all content for a specific page (for editor - grouped by section)
     */
    public static function getPageContent(string $page)
    {
        return self::where('page', $page)
            ->orderBy('order')
            ->get()
            ->groupBy('section');
    }

    /**
     * Get all content for a specific page (for frontend views - flat with dot notation)
     */
    public static function getPageContentFlat(string $page)
    {
        $contents = self::where('page', $page)
            ->orderBy('order')
            ->get()
            ->groupBy('section');

        // Return a collection with a get method for easy access using dot notation
        return collect($contents)->flatMap(function ($items, $section) {
            return collect($items)->mapWithKeys(function ($item) use ($section) {
                return [$section . '.' . $item->key => $item->value];
            });
        });
    }

    /**
     * Clear all page content cache
     */
    public static function clearCache()
    {
        Cache::flush();
    }
}
