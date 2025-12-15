<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            // BASIC INFORMATION
            $table->string('title');                                   // Main headline
            $table->string('slug')->unique()->nullable();              // SEO-friendly slug
            $table->string('subtitle')->nullable();                    // Optional subheading
            $table->text('short_description')->nullable();             // Summary (for cards or previews)
            $table->longText('content')->nullable();                   // Full article content (HTML or Markdown)

            // MEDIA
            $table->string('thumbnail')->nullable();                   // Small image (for listings)
            $table->string('banner')->nullable();                      // Large hero banner
            $table->string('video_url')->nullable();                   // Optional embedded video (YouTube, Vimeo, etc.)
            $table->json('gallery')->nullable();                       // Optional multiple images (carousel/gallery)

            // CATEGORY & TAGGING
            $table->string('category')->nullable();                    // e.g. Leadership, Growth, Marketing
            $table->string('subcategory')->nullable();                 // e.g. Digital Marketing under Marketing
            $table->string('tags')->nullable();                        // Comma-separated tags
            $table->string('industry')->nullable();                    // Optional business industry context

            // AUTHOR INFORMATION
            $table->unsignedBigInteger('author_id')->nullable();       // References users.id
            $table->string('author_name')->nullable();                 // Name if entered manually
            $table->string('author_designation')->nullable();          // e.g., CEO, Founder
            $table->string('author_company')->nullable();
            $table->string('author_profile_image')->nullable();        // Optional author avatar
            $table->text('author_bio')->nullable();                    // Short author bio paragraph

            // ARTICLE DETAILS
            $table->date('publish_date')->nullable();
            $table->time('publish_time')->nullable();
            $table->integer('read_time')->nullable()->comment('Estimated reading time in minutes');
            $table->enum('status', ['draft', 'review', 'published', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_trending')->default(false);
            $table->boolean('is_active')->default(true);

            // ENGAGEMENT & ANALYTICS
            $table->integer('views')->default(0);
            $table->integer('unique_views')->default(0);
            $table->integer('likes')->default(0);
            $table->integer('shares')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('bookmarks')->default(0);
            $table->float('average_rating', 3, 2)->nullable()->default(null);
            $table->integer('ratings_count')->default(0);

            // SEO OPTIMIZATION
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_title')->nullable();                    // Open Graph (for social)
            $table->string('og_image')->nullable();
            $table->string('twitter_card')->nullable();                // Twitter share image/text

            // LOCATION (if relevant to article type)
            $table->string('region')->nullable();
            $table->string('language', 10)->default('en');

            // AUDIT TRAIL
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            // FOREIGN KEYS
            $table->foreign('author_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
