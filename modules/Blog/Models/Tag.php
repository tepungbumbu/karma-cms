<?php declare(strict_types=1);

namespace Karma\Blog\Models;

use App\Core\Models\BaseModel;
use App\Core\Traits\HasSlug;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends BaseModel
{
    use SoftDeletes, HasSlug;

    protected $table = 'blog_tags';

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'blog_post_tag', 'tag_id', 'post_id');
    }

    public function scopePopular($query, int $limit = 10)
    {
        return $query
            ->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit($limit);
    }
}
