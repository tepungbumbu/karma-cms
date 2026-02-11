<?php declare(strict_types=1);

namespace Karma\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Karma\Blog\Models\Category;
use Karma\Blog\Models\Post;
use Karma\Blog\Models\Tag;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Create Categories
        $categories = ['Laravel', 'PHP', 'Web Design', 'SEO', 'Security'];
        foreach ($categories as $cat) {
            Category::create(['name' => $cat, 'status' => 'active']);
        }

        // Create Tags
        $tags = ['Tips', 'Tutorial', 'News', 'Design', 'Code'];
        foreach ($tags as $tagName) {
            Tag::create(['name' => $tagName]);
        }

        // Create Posts
        Post::factory()->count(20)->create([
            'category_id' => fn() => Category::inRandomOrder()->first()->id,
            'author_id' => 1,
        ])->each(function ($post) {
            $post->tags()->attach(Tag::inRandomOrder()->limit(3)->pluck('id'));
        });
    }
}
