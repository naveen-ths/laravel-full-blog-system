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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            
            // Basic required fields
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->text('excerpt')->nullable();
            $table->enum('status', ['draft', 'published', 'private'])->default('draft');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();
            
            // SEO fields
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('meta_robots')->nullable()->default('index,follow');
            $table->string('canonical_url')->nullable();
            $table->json('og_data')->nullable(); // Open Graph data (title, description, image, etc.)
            $table->json('twitter_data')->nullable(); // Twitter Card data
            $table->text('schema_markup')->nullable(); // JSON-LD structured data
            
            // Featured image fields
            $table->string('featured_image')->nullable();
            $table->string('featured_image_alt')->nullable();
            $table->string('featured_image_caption')->nullable();
            $table->json('featured_image_meta')->nullable(); // Store width, height, file size, etc.
            
            // Additional media fields
            $table->json('gallery_images')->nullable(); // Array of image data
            $table->string('banner_image')->nullable();
            $table->string('banner_image_alt')->nullable();
            
            // User relationship
            $table->foreignId('author_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['status', 'published_at']);
            $table->index(['slug']);
            $table->index(['is_featured']);
            $table->index(['sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
