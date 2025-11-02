<?php

namespace App\Helpers;

use App\Models\SeoSetting;

class SeoHelper
{
    /**
     * Get SEO meta tags for a specific page
     */
    public static function getMetaTags(string $page, array $defaults = []): array
    {
        $seo = SeoSetting::getForPage($page);

        if (!$seo) {
            return self::getDefaultMetaTags($page, $defaults);
        }

        return [
            'title' => $seo->meta_title ?? $defaults['title'] ?? config('app.name'),
            'description' => $seo->meta_description ?? $defaults['description'] ?? '',
            'keywords' => $seo->meta_keywords ?? $defaults['keywords'] ?? '',
            'og_title' => $seo->og_title ?? $seo->meta_title ?? $defaults['title'] ?? config('app.name'),
            'og_description' => $seo->og_description ?? $seo->meta_description ?? $defaults['description'] ?? '',
            'og_image' => $seo->og_image ? asset('storage/' . $seo->og_image) : ($defaults['og_image'] ?? asset('images/og-default.jpg')),
            'og_type' => $seo->og_type ?? 'website',
            'twitter_card' => $seo->twitter_card ?? 'summary_large_image',
            'twitter_title' => $seo->twitter_title ?? $seo->meta_title ?? $defaults['title'] ?? config('app.name'),
            'twitter_description' => $seo->twitter_description ?? $seo->meta_description ?? $defaults['description'] ?? '',
            'twitter_image' => $seo->twitter_image ? asset('storage/' . $seo->twitter_image) : ($defaults['og_image'] ?? asset('images/og-default.jpg')),
            'canonical' => $seo->canonical_url ?? url()->current(),
            'robots' => self::getRobotsTag($seo->index, $seo->follow),
        ];
    }

    /**
     * Get default meta tags when no SEO settings exist
     */
    private static function getDefaultMetaTags(string $page, array $defaults = []): array
    {
        $siteName = config('app.name');

        $pageDefaults = [
            'home' => [
                'title' => 'Imani Magnets - Imanes Personalizados | Ecuador',
                'description' => 'Crea tus propios imanes personalizados con tus fotos favoritas. Envíos a todo Ecuador. Calidad premium y diseños únicos.',
                'keywords' => 'imanes personalizados, magnets, fotos, ecuador, regalos personalizados',
            ],
            'personalizados' => [
                'title' => 'Imanes Personalizados con tus Fotos | Imani Magnets',
                'description' => 'Diseña y crea imanes únicos con tus fotografías. Proceso fácil y rápido. Calidad garantizada.',
                'keywords' => 'imanes personalizados, crear imanes, fotos en imanes, diseño personalizado',
            ],
            'colecciones' => [
                'title' => 'Colecciones de Imanes | Imani Magnets',
                'description' => 'Explora nuestras colecciones de imanes decorativos. Diseños exclusivos para cada ocasión.',
                'keywords' => 'colecciones imanes, imanes decorativos, diseños exclusivos',
            ],
        ];

        $pageData = $pageDefaults[$page] ?? [
            'title' => $siteName,
            'description' => '',
            'keywords' => '',
        ];

        // Merge with provided defaults
        $merged = array_merge($pageData, $defaults);

        return [
            'title' => $merged['title'],
            'description' => $merged['description'],
            'keywords' => $merged['keywords'],
            'og_title' => $merged['title'],
            'og_description' => $merged['description'],
            'og_image' => $defaults['og_image'] ?? asset('images/og-default.jpg'),
            'og_type' => 'website',
            'twitter_card' => 'summary_large_image',
            'twitter_title' => $merged['title'],
            'twitter_description' => $merged['description'],
            'twitter_image' => $defaults['og_image'] ?? asset('images/og-default.jpg'),
            'canonical' => url()->current(),
            'robots' => 'index, follow',
        ];
    }

    /**
     * Generate robots meta tag value
     */
    private static function getRobotsTag(bool $index, bool $follow): string
    {
        $indexValue = $index ? 'index' : 'noindex';
        $followValue = $follow ? 'follow' : 'nofollow';

        return "{$indexValue}, {$followValue}";
    }

    /**
     * Render SEO meta tags for blade template
     */
    public static function renderMetaTags(string $page, array $defaults = []): string
    {
        $tags = self::getMetaTags($page, $defaults);

        $html = '';

        // Basic meta tags
        $html .= '<title>' . e($tags['title']) . '</title>' . PHP_EOL;
        $html .= '<meta name="description" content="' . e($tags['description']) . '">' . PHP_EOL;

        if (!empty($tags['keywords'])) {
            $html .= '<meta name="keywords" content="' . e($tags['keywords']) . '">' . PHP_EOL;
        }

        $html .= '<meta name="robots" content="' . e($tags['robots']) . '">' . PHP_EOL;
        $html .= '<link rel="canonical" href="' . e($tags['canonical']) . '">' . PHP_EOL;

        // Open Graph tags
        $html .= '<meta property="og:title" content="' . e($tags['og_title']) . '">' . PHP_EOL;
        $html .= '<meta property="og:description" content="' . e($tags['og_description']) . '">' . PHP_EOL;
        $html .= '<meta property="og:image" content="' . e($tags['og_image']) . '">' . PHP_EOL;
        $html .= '<meta property="og:type" content="' . e($tags['og_type']) . '">' . PHP_EOL;
        $html .= '<meta property="og:url" content="' . e($tags['canonical']) . '">' . PHP_EOL;

        // Twitter Card tags
        $html .= '<meta name="twitter:card" content="' . e($tags['twitter_card']) . '">' . PHP_EOL;
        $html .= '<meta name="twitter:title" content="' . e($tags['twitter_title']) . '">' . PHP_EOL;
        $html .= '<meta name="twitter:description" content="' . e($tags['twitter_description']) . '">' . PHP_EOL;
        $html .= '<meta name="twitter:image" content="' . e($tags['twitter_image']) . '">' . PHP_EOL;

        return $html;
    }
}
