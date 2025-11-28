<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_branding_posts', function (Blueprint $table) {
            $table->id();

            // Member who owns this publication
            $table->unsignedBigInteger('member_id');

            // Type of branding content
            $table->enum('post_type', [
                'article',
                'story',
                'video'
            ]);

            // Title for the post
            $table->string('title');

            // Slug for SEO-friendly URL
            $table->string('slug')->unique();

            // Main content (article/story text)
            $table->longText('content')->nullable();

            // Media links
            $table->string('featured_image')->nullable();  // article image or story image
            $table->string('video_url')->nullable();       // YouTube or hosted video link

            // Description or summary
            $table->text('short_description')->nullable();

            // SEO fields
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            // Status workflow
            $table->enum('status', [
                'draft',
                'submitted',     // member submitted
                'approved',      // admin approved & published
                'rejected'
            ])->default('draft');

            // Admin actions
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_branding_posts');
    }
};
