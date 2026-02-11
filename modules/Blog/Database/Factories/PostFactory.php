<?php declare(strict_types=1);

namespace Karma\Blog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Karma\Blog\Models\Post;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->sentence;
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => $this->faker->paragraph,
            'content' => $this->faker->paragraphs(5, true),
            'status' => 'published',
            'published_at' => now(),
            'is_featured' => $this->faker->boolean(20),
            'view_count' => $this->faker->numberBetween(0, 1000),
            'category_id' => 1,
            'author_id' => 1,
        ];
    }
}
