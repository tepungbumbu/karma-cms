<?php declare(strict_types=1);

namespace App\Core\Models;

/**
 * Class Theme
 *
 * Represents a CMS frontend theme.
 */
class Theme extends BaseModel
{
    protected $table = 'themes';

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'settings' => 'array',
    ];

    /**
     * Scope to get only active theme.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
