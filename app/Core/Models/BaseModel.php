<?php declare(strict_types=1);

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 *
 * Base model for all CMS and Module models.
 */
abstract class BaseModel extends Model
{
    use HasFactory;

    /**
     * Disable mass assignment protection by default for core models.
     * We depend on form requests for validation.
     */
    protected $guarded = [];
}
