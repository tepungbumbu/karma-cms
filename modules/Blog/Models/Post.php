<?php declare(strict_types=1);

namespace Karma\Blog\Models;

use App\Core\Models\BaseModel;
use App\Core\Traits\HasActivity;
use App\Core\Traits\HasMedia;
use App\Core\Traits\HasSEO;
use App\Core\Traits\HasSlug;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Post extends BaseModel
{
    use SoftDeletes, HasSlug, HasMedia, HasSEO, HasActivity, Searchable;

    protected $table = 'blog_posts';

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_indexable' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'blog_post_tag', 'post_id', 'tag_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    /**
     * Scopes
     */
    public function scopePublished($query)
    {
        return $query
            ->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Accessors
     */
    public function getUrlAttribute(): string
    {
        return route('blog.show', [$this->category->slug, $this->slug]);
    }

    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags($this->content));
        return (int) ceil($words / 200);
    }

    public function getSummaryAttribute(): string
    {
        return $this->excerpt ?: Str::limit(strip_tags($this->content), 160);
    }

    /**
     * Searchable configuration (Laravel Scout)
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => (int) $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'category' => $this->category->name,
            'tags' => $this->tags->pluck('name')->toArray(),
        ];
    }
}
