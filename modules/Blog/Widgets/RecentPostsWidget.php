<?php declare(strict_types=1);

namespace Karma\Blog\Widgets;

use App\Core\Widgets\BaseWidget;
use Illuminate\View\View;
use Karma\Blog\Models\Post;

class RecentPostsWidget extends BaseWidget
{
    public function getTitle(): string
    {
        return 'Recent Posts';
    }

    public function getDescription(): string
    {
        return 'Displays the latest blog posts with thumbnails.';
    }

    public function render(array $settings = []): View
    {
        $limit = $settings['limit'] ?? 5;
        $posts = Post::published()->latest()->limit($limit)->get();

        return view('blog::widgets.recent_posts', compact('posts', 'settings'));
    }
}
