<?php declare(strict_types=1);

namespace App\Core\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class SEOManager
{
    /**
     * Generate meta tags for a given model or default.
     */
    public function getMetaTags(?Model $model = null): array
    {
        $defaults = [
            'title' => config('app.name'),
            'description' => 'The ultimate modular CMS for production apps.',
            'keywords' => 'cms, laravel, blog, seo',
            'canonical' => URL::current(),
            'og_title' => config('app.name'),
            'og_description' => 'The ultimate modular CMS.',
            'og_image' => asset('img/default-og.jpg'),
            'twitter_card' => 'summary_large_image',
            'robots' => 'index, follow',
        ];

        if ($model && method_exists($model, 'getSeoMeta')) {
            return array_merge($defaults, $model->getSeoMeta());
        }

        return $defaults;
    }

    /**
     * Generate BreadcrumbList Schema.
     */
    public function getBreadcrumbs(array $crumbs): array
    {
        $items = [];
        $pos = 1;
        foreach ($crumbs as $name => $url) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $pos++,
                'name' => $name,
                'item' => $url,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];
    }
}
