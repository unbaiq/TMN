<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();

            // Basic Story Details
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->string('subtitle')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            // Media
            $table->string('image')->nullable();        // Thumbnail / Cover Image
            $table->string('banner')->nullable();       // Full-width hero banner
            $table->string('video_url')->nullable();    // Optional YouTube or Vimeo video link
            $table->string('gallery')->nullable();      // JSON of multiple images (optional)

            // Story Metadata
            $table->string('category')->nullable();     // e.g., Success Story, Growth Story, Innovation
            $table->string('industry')->nullable();
            $table->string('tags')->nullable();         // Comma-separated keywords
            $table->date('publish_date')->nullable();

            // Author / Member Details
            $table->unsignedBigInteger('author_id')->nullable(); // references users.id
            $table->string('author_name')->nullable();
            $table->string('author_designation')->nullable();
            $table->string('author_company')->nullable();
            $table->string('chapter_name')->nullable();
            $table->string('chapter_city')->nullable();

            // Business Impact / Metrics
            $table->decimal('business_generated', 15, 2)->nullable()->comment('Value of business generated in INR');
            $table->integer('referrals_received')->nullable()->default(0);
            $table->integer('clients_gained')->nullable()->default(0);
            $table->integer('team_size_growth')->nullable()->default(0);

            // Engagement Metrics
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            $table->integer('shares')->default(0);
            $table->integer('comments_count')->default(0);

            // Status and Visibility
            $table->enum('status', ['draft', 'review', 'published', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);

            // SEO / Meta
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            // Audit
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();

            // Relations
            $table->foreign('author_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
