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
        Schema::create('homes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();

            $table->enum('background_type', ['color', 'image', 'none'])->default('none');
            $table->string('background_value')->nullable();
            $table->string('text_color')->nullable();

            $table->enum('layout_type', [
                'text_left_image_right',   // flex row
                'image_left_text_right',   // flex row-reverse
                'image_top',               // column, image above text
                'image_bottom',            // column, image below text
                'centered',                // single centered block
                'full_width',              // wide single section, maybe banner
            ])->default('text_left_image_right');


            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();

            $table->integer('order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homes');
    }
};
