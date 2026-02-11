<?php declare(strict_types=1);

namespace Karma\Blog\Services;

use Illuminate\Support\Collection;
use Karma\Blog\Models\Comment;

class CommentService
{
    /**
     * Create a comment.
     */
    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

    /**
     * Approve a comment.
     */
    public function approve(int $id): bool
    {
        return Comment::findOrFail($id)->update(['status' => 'approved']);
    }

    /**
     * Mark a comment as spam.
     */
    public function markAsSpam(int $id): bool
    {
        return Comment::findOrFail($id)->update(['status' => 'spam']);
    }

    /**
     * Get recent comments for dashboard.
     */
    public function getRecent(int $limit = 5): Collection
    {
        return Comment::with(['post', 'user'])
            ->latest()
            ->limit($limit)
            ->get();
    }
}
