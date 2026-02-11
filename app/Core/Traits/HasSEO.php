<?php declare(strict_types=1);

namespace App\Core\Traits;

/**
 * Trait HasSEO
 *
 * Provides methods for handling SEO metadata, Open Graph, and Structured Data.
 */
trait HasSEO
{
    /**
     * Get SEO metadata for the model.
     */
    public function getSeoMeta(): array
    {
        return [
            'title' => $this->meta_title ?: $this->title ?: $this->name,
            'description' => $this->meta_description ?: (method_exists($this, 'getSummaryAttribute') ? $this->summary : ''),
            'keywords' => $this->meta_keywords,
            'canonical' => $this->canonical_url ?: url()->current(),
            'og_title' => $this->og_title ?: $this->meta_title ?: $this->title,
            'og_description' => $this->og_description ?: $this->meta_description,
            'og_image' => $this->og_image_url ?: $this->getFirstMediaUrl('featured_image'),
            'type' => $this->schema_type ?: 'Article',
        ];
    }
}
