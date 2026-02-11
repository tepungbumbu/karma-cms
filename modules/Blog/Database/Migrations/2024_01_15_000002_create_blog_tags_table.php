<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blog_tags', function (Blueprint $column) {
            $column->id();
            $column->string('name');
            $column->string('slug')->unique()->index();
            $column->text('description')->nullable();

            // SEO
            $column->string('meta_title')->nullable();
            $column->text('meta_description')->nullable();

            $column->timestamps();
            $column->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_tags');
    }
};
