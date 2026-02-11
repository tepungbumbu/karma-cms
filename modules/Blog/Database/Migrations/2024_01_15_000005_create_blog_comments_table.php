<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blog_comments', function (Blueprint $column) {
            $column->id();
            $column->foreignId('post_id')->constrained('blog_posts')->onDelete('cascade');
            $column->foreignId('parent_id')->nullable()->constrained('blog_comments')->onDelete('cascade');
            $column->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $column->string('author_name')->nullable();
            $column->string('author_email')->nullable();
            $column->string('author_website')->nullable();

            $column->text('content');
            $column->enum('status', ['pending', 'approved', 'spam', 'trash'])->default('pending')->index();
            $column->string('ip_address')->nullable();

            $column->timestamps();
            $column->softDeletes();

            $column->index('post_id');
            $column->index('parent_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_comments');
    }
};
