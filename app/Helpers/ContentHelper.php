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

    /**
     * Get WhatsApp link with message
     *
     * @param string|null $customMessage
     * @return string
     */
    public static function getWhatsAppLink(?string $customMessage = null): string
    {
        $number = config('site.whatsapp.number');
        $message = $customMessage ?? config('site.whatsapp.message');

        // Remove spaces, dashes, and format number
        $cleanNumber = preg_replace('/[^0-9+]/', '', $number);

        // URL encode the message
        $encodedMessage = urlencode($message);

        return "https://wa.me/{$cleanNumber}?text={$encodedMessage}";
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

if (!function_exists('whatsapp_link')) {
    /**
     * Get WhatsApp link with optional custom message
     *
     * @param string|null $customMessage
     * @return string
     */
    function whatsapp_link(?string $customMessage = null): string
    {
        return \App\Helpers\ContentHelper::getWhatsAppLink($customMessage);
    }
}
