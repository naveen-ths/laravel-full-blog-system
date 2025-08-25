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
        Schema::table('blog_posts', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['blog_category_id']);
            
            // Rename the column
            $table->renameColumn('blog_category_id', 'category_id');
            
            // Add the status 'scheduled' to the enum
            $table->enum('status', ['draft', 'published', 'scheduled'])->default('draft')->change();
            
            // Rename views_count to views
            $table->renameColumn('views_count', 'views');
        });
        
        Schema::table('blog_posts', function (Blueprint $table) {
            // Add the foreign key constraint back
            $table->foreign('category_id')->references('id')->on('blog_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['category_id']);
            
            // Rename back
            $table->renameColumn('category_id', 'blog_category_id');
            $table->renameColumn('views', 'views_count');
            
            // Change status back
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->change();
        });
        
        Schema::table('blog_posts', function (Blueprint $table) {
            // Add the original foreign key constraint back
            $table->foreign('blog_category_id')->references('id')->on('blog_categories')->onDelete('cascade');
        });
    }
};
