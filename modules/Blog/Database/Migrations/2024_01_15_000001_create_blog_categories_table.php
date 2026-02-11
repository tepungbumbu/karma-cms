<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blog_categories', function (Blueprint $column) {
            $column->id();
            $column->string('name');
            $column->string('slug')->unique()->index();
            $column->text('description')->nullable();
            $column->foreignId('parent_id')->nullable()->constrained('blog_categories')->onDelete('set null');
            $column->string('image')->nullable();

            // SEO Fields
            $column->string('meta_title')->nullable();
            $column->text('meta_description')->nullable();
            $column->text('meta_keywords')->nullable();

            $column->enum('status', ['active', 'inactive'])->default('active')->index();
            $column->integer('sort_order')->default(0);
            $column->timestamps();
            $column->softDeletes();

            $column->index('parent_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_categories');
    }
};
