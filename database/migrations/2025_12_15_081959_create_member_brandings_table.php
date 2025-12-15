<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_brandings', function (Blueprint $table) {
            $table->id();

            // 🔗 Ownership
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->onDelete('set null');
            $table->foreignId('event_id')->nullable()->constrained('events')->onDelete('set null');

            // 🧭 Classification
            $table->enum('branding_type', [
                'article',          // Blog, news article, or write-up
                'story',            // Social media or newsletter feature
                'video_shoot',      // Recorded interview, promo, or documentary
                'podcast',          // Audio/video podcast feature
                'pr_activity',      // Public relations event or press interaction
                'media_release',    // Official press/media release
                'magazine_feature', // TMN or external publication
                'award_mention',    // Coverage of an award or recognition
                'social_campaign',  // Online awareness campaign
                'other'
            ])->default('article');

            // 📝 Core Info
            $table->string('title')->nullable();
            $table->string('headline')->nullable();
            $table->text('description')->nullable();
            $table->string('theme')->nullable()->comment('e.g. Entrepreneurship, Growth, Impact');

            // 🗓️ Timeline
            $table->date('activity_date')->nullable();
            $table->string('duration')->nullable()->comment('e.g. 2 days, 3 hours');

            // 📍 Context & Collaboration
            $table->string('location')->nullable();
            $table->string('collaborators')->nullable()->comment('Other members, brands, or organizations involved');
            $table->string('sponsor_name')->nullable();
            $table->string('agency_name')->nullable()->comment('PR/Media agency that executed it');

            // 📸 Media & Assets
            $table->string('media_platform')->nullable()->comment('e.g. YouTube, Instagram, Times of India');
            $table->string('media_link')->nullable()->comment('Direct link to published media or video');
            $table->string('media_type')->nullable()->comment('video, article, image, pdf, podcast');
            $table->string('proof_document')->nullable();
            $table->string('thumbnail_image')->nullable();

            // 🎯 Audience & Impact Metrics
            $table->integer('reach_count')->nullable()->comment('Estimated number of viewers/readers');
            $table->integer('engagement_count')->nullable()->comment('Likes, shares, comments, reactions');
            $table->integer('views_count')->nullable();
            $table->integer('downloads_count')->nullable();
            $table->decimal('estimated_value', 12, 2)->nullable()->comment('PR or Media value in INR');
            $table->integer('media_mentions')->nullable()->comment('Times TMN or Member was mentioned');
            $table->boolean('featured_by_tmn')->default(false)->comment('Featured by TMN on official channels');

            // 🗞️ Publication / Release Data (for PR/Media)
            $table->string('publication_name')->nullable();
            $table->string('journalist_name')->nullable();
            $table->string('press_contact_email')->nullable();
            $table->string('press_contact_phone')->nullable();

            // 🎥 Specific: Video / Podcast Data
            $table->string('video_length')->nullable()->comment('Duration e.g. 5 min 30 sec');
            $table->integer('episode_number')->nullable();
            $table->string('series_name')->nullable();

            // 🏆 Recognition/Outcome
            $table->text('key_highlights')->nullable();
            $table->text('member_quote')->nullable();
            $table->string('resulting_leads')->nullable()->comment('Business or referral leads generated');
            $table->text('followup_action')->nullable();

            // ⚙️ Workflow
            $table->enum('status', ['draft', 'submitted', 'under_review', 'approved', 'rejected'])->default('submitted');
            $table->text('review_notes')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            // 🧾 Metadata
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_brandings');
    }
};
