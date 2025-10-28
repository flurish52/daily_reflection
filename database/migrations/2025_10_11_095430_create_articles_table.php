<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->string('title')->index();
            $table->foreignId('author')->nullable()->constrained('users')->index();
            $table->longText('content')->nullable();

            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('archive_id')->nullable()->constrained()->onDelete('set null');

            $table->string('excerpt')->nullable();
            $table->string('status')->default('draft')->index();
            $table->integer('reading_time')->nullable();
            $table->json('tags')->nullable();
            $table->string('slug')->unique();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('focus_keyword')->nullable()->index();
            $table->string('visibility')->default('public');
            $table->boolean('allow_comments')->default(true);
            $table->boolean('is_featured')->default(false)->index();
            $table->string('featured_image')->nullable();

            $table->timestamp('published_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
