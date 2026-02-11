<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blog_post_tag', function (Blueprint $column) {
            $column->foreignId('post_id')->constrained('blog_posts')->onDelete('cascade');
            $column->foreignId('tag_id')->constrained('blog_tags')->onDelete('cascade');
            $column->primary(['post_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_post_tag');
    }
};
