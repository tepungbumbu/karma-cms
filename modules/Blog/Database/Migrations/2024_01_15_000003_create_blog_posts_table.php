<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $column) {
            $column->id();
            $column->string('title');
            $column->string('slug')->unique()->index();
            $column->text('excerpt')->nullable();
            $column->longText('content');

            $column->unsignedBigInteger('featured_image_id')->nullable();
            $column->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $column->foreignId('category_id')->constrained('blog_categories')->onDelete('cascade');

            $column->enum('status', ['draft', 'published', 'scheduled', 'archived'])->default('draft')->index();
            $column->dateTime('published_at')->nullable()->index();
            $column->boolean('is_featured')->default(false)->index();
            $column->bigInteger('view_count')->default(0);

            // SEO & Social
            $column->string('meta_title')->nullable();
            $column->text('meta_description')->nullable();
            $column->text('meta_keywords')->nullable();
            $column->string('schema_type')->default('Article');
            $column->string('og_title')->nullable();
            $column->text('og_description')->nullable();
            $column->string('og_image')->nullable();
            $column->string('canonical_url')->nullable();
            $column->boolean('is_indexable')->default(true);

            $column->timestamps();
            $column->softDeletes();

            $column->index('author_id');
            $column->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
