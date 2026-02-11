<?php declare(strict_types=1);

namespace Karma\Blog\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Karma\Blog\Models\Category;
use Karma\Blog\Models\Post;
use Karma\Blog\Models\Tag;
use Karma\Blog\Services\PostService;

class PostController extends Controller
{
    public function __construct(
        protected PostService $postService
    ) {}

    public function index(Request $request): View
    {
        $posts = Post::with(['category', 'author'])
            ->latest()
            ->paginate(20);

        return view('blog::admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        $categories = Category::active()->ordered()->get();
        $tags = Tag::all();

        return view('blog::admin.posts.form', [
            'post' => new Post(),
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:blog_categories,id',
            'status' => 'required|in:draft,published,scheduled,archived',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
        ]);

        $validated['author_id'] = auth()->id() ?: 1;  // Default to ID 1 for now

        $post = $this->postService->create($validated);

        return redirect()
            ->route('admin.blog.posts.index')
            ->with('success', 'Post created successfully.');
    }

    public function edit(Post $post): View
    {
        $categories = Category::active()->ordered()->get();
        $tags = Tag::all();

        return view('blog::admin.posts.form', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:blog_categories,id',
            'status' => 'required|in:draft,published,scheduled,archived',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
        ]);

        $this->postService->update($post, $validated);

        return redirect()
            ->route('admin.blog.posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->postService->delete((int) $post->id);

        return redirect()
            ->route('admin.blog.posts.index')
            ->with('success', 'Post deleted successfully.');
    }
}
