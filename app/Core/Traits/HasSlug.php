<?php declare(strict_types=1);

namespace App\Core\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Trait HasSlug
 *
 * Automatically generates a unique slug from a specified source field.
 */
trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $model) {
            $model->generateSlug();
        });

        static::updating(function (Model $model) {
            if ($model->isDirty($model->getSlugSource())) {
                $model->generateSlug();
            }
        });
    }

    /**
     * Generate a unique slug for the model.
     */
    public function generateSlug(): void
    {
        $source = $this->{$this->getSlugSource()};
        if (empty($source)) {
            return;
        }

        $slug = Str::slug($source);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $this->slug = $slug;
    }

    /**
     * Get the source field for slug generation.
     */
    protected function getSlugSource(): string
    {
        return property_exists($this, 'slugSource') ? $this->slugSource : 'title';
    }
}
