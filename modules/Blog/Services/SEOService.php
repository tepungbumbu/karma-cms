<?php declare(strict_types=1);

namespace Karma\Blog\Services;

use Karma\Blog\Models\Post;

class SEOService
{
    /**
     * Generate Schema.org JSON-LD for an Article.
     */
    public function generateArticleSchema(Post $post): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => $post->schema_type ?: 'BlogPosting',
            'headline' => $post->meta_title ?: $post->title,
            'image' => [
                $post->getFirstMediaUrl('featured_image', 'large') ?: $post->og_image,
            ],
            'datePublished' => $post->published_at?->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $post->author->name,
                'url' => url('/'),  // Author profile link if exists
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('img/logo.png'),
                ]
            ],
            'description' => $post->meta_description ?: $post->summary,
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $post->url,
            ],
        ];
    }

    /**
     * Get meta tags for frontend.
     */
    public function getMetaTags(Post $post): array
    {
        return $post->getSeoMeta();
    }
}
