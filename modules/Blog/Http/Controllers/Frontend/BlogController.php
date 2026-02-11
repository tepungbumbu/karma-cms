<?php declare(strict_types=1);

namespace Karma\Blog\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Karma\Blog\Models\Category;
use Karma\Blog\Models\Post;
use Karma\Blog\Models\Tag;
use Karma\Blog\Services\SEOService;

class BlogController extends Controller
{
    public function __construct(
        protected SEOService $seoService
    ) {}

    public function index(Request $request): View
    {
        $posts = Post::published()
            ->with(['category', 'author', 'tags'])
            ->latest()
            ->paginate(12);

        return view('blog::frontend.index', compact('posts'));
    }

    public function show(string $categorySlug, string $postSlug): View
    {
        $post = Post::published()
            ->where('slug', $postSlug)
            ->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            })
            ->firstOrFail();

        $post->increment('view_count');

        $seo = $this->seoService->getMetaTags($post);
        $schema = $this->seoService->generateArticleSchema($post);

        return view('blog::frontend.show', compact('post', 'seo', 'schema'));
    }

    public function category(Category $category): View
    {
        $posts = $category
            ->posts()
            ->published()
            ->latest()
            ->paginate(12);

        return view('blog::frontend.index', compact('posts', 'category'));
    }

    public function tag(Tag $tag): View
    {
        $posts = $tag
            ->posts()
            ->published()
            ->latest()
            ->paginate(12);

        return view('blog::frontend.index', compact('posts', 'tag'));
    }

    public function search(Request $request): View
    {
        $query = $request->get('q');

        $posts = Post::published()
            ->where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->paginate(12);

        return view('blog::frontend.index', compact('posts', 'query'));
    }
}
