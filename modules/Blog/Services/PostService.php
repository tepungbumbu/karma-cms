<?php declare(strict_types=1);

namespace Karma\Blog\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Karma\Blog\Models\Post;

class PostService
{
    /**
     * Create a new post.
     */
    public function create(array $data): Post
    {
        return DB::transaction(function () use ($data) {
            $post = Post::create($data);

            if (isset($data['tags'])) {
                $post->tags()->sync($data['tags']);
            }

            $this->clearCache();

            return $post;
        });
    }

    /**
     * Update an existing post.
     */
    public function update(Post $post, array $data): Post
    {
        return DB::transaction(function () use ($post, $data) {
            $post->update($data);

            if (isset($data['tags'])) {
                $post->tags()->sync($data['tags']);
            }

            $this->clearCache();

            return $post;
        });
    }

    /**
     * Delete a post (soft delete).
     */
    public function delete(int $id): bool
    {
        $post = Post::findOrFail($id);
        $result = $post->delete();

        if ($result) {
            $this->clearCache();
        }

        return $result;
    }

    /**
     * Clear blog related caches.
     */
    public function clearCache(): void
    {
        Cache::tags(['blog', 'posts'])->flush();
    }

    /**
     * Get related posts.
     */
    public function getRelatedPosts(Post $post, int $limit = 4): Collection
    {
        return Cache::remember("blog_post_{$post->id}_related", 3600, function () use ($post, $limit) {
            return Post::published()
                ->where('id', '!=', $post->id)
                ->where(function ($query) use ($post) {
                    $query
                        ->where('category_id', $post->category_id)
                        ->orWhereHas('tags', function ($q) use ($post) {
                            $q->whereIn('blog_tags.id', $post->tags->pluck('id'));
                        });
                })
                ->limit($limit)
                ->get();
        });
    }
}
