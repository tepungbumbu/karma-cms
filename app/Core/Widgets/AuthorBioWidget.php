<?php declare(strict_types=1);

namespace App\Core\Widgets;

use Illuminate\View\View;
use Karma\Blog\Models\Post;

class AuthorBioWidget extends BaseWidget
{
    public function getTitle(): string
    {
        return 'Author Bio';
    }

    public function render(array $settings = []): View
    {
        // Try to get post from context (simplified)
        $post = request()->route('post');
        if (is_string($post)) {
            $post = Post::where('slug', $post)->first();
        }

        return view('widgets.author_bio', compact('post', 'settings'));
    }
}
