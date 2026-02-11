<?php declare(strict_types=1);

namespace App\Core\Traits;

use Spatie\MediaLibrary\HasMedia as SpatieHasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Trait HasMedia
 *
 * Bridge for Spatie Media Library implementation.
 */
trait HasMedia
{
    use InteractsWithMedia;

    /**
     * Register common media conversions.
     */
    public function registerMediaConversions($media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);

        $this
            ->addMediaConversion('large')
            ->width(1200)
            ->height(630)
            ->sharpen(10);
    }
}
