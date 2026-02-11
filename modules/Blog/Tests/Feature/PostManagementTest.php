<?php declare(strict_types=1);

namespace Karma\Blog\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Karma\Blog\Models\Category;
use Karma\Blog\Models\Post;
use Tests\TestCase;

class PostManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create(['id' => 1]);
        Category::create(['id' => 1, 'name' => 'General', 'status' => 'active']);
    }

    public function test_admin_can_view_post_index(): void
    {
        $user = User::first();
        $response = $this->actingAs($user)->get(route('admin.blog.posts.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_post(): void
    {
        $user = User::first();
        $response = $this->actingAs($user)->post(route('admin.blog.posts.store'), [
            'title' => 'Test Post',
            'content' => 'Test Content',
            'category_id' => 1,
            'status' => 'published',
        ]);

        $this->assertDatabaseHas('blog_posts', ['title' => 'Test Post']);
        $response->assertRedirect(route('admin.blog.posts.index'));
    }
}
