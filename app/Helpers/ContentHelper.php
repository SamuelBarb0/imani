<?php

namespace App\Helpers;

use App\Models\PageContent;
use Illuminate\Support\Collection;

class ContentHelper
{
    /**
     * Get all content for a page (flat structure for views)
     *
     * @param string $page
     * @return Collection
     */
    public static function getPageContent(string $page): Collection
    {
        return PageContent::getPageContentFlat($page);
    }
}

if (!function_exists('content')) {
    /**
     * Get editable content by page, section, and key
     *
     * @param string $page
     * @param string $section
     * @param string $key
     * @param string $default
     * @return string
     */
    function content(string $page, string $section, string $key, string $default = '')
    {
        return PageContent::get($page, $section, $key, $default);
    }
}
