<?php

declare(strict_types=1);

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Module
 * 
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string $version
 * @property string|null $description
 * @property bool $is_enabled
 * @property bool $is_core
 * @property string|null $installed_at
 * @property string|null $last_updated
 * @property array|null $settings_schema
 * @property array|null $permissions
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 */
class Module extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'name',
        'version',
        'description',
        'is_enabled',
        'is_core',
        'installed_at',
        'last_updated',
        'settings_schema',
        'permissions',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_enabled' => 'boolean',
        'is_core' => 'boolean',
        'installed_at' => 'datetime',
        'last_updated' => 'datetime',
        'settings_schema' => 'array',
        'permissions' => 'array',
    ];

    /**
     * Scope a query to only include enabled modules.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }

    /**
     * Scope a query to only include core modules.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCore($query)
    {
        return $query->where('is_core', true);
    }
}
