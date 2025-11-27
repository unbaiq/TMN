<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_branding_services', function (Blueprint $table) {
            $table->id();

            // Member who is availing branding service
            $table->unsignedBigInteger('member_id');

            // Service Type: Article / Story / Video / Podcast / PR / Media Release
            $table->enum('service_type', [
                'article',
                'story',
                'video_shoot',
                'podcast',
                'pr',
                'media_release'
            ]);

            // Title of article/story/podcast etc.
            $table->string('title')->nullable();

            // Member input (brief)
            $table->longText('description')->nullable();

            // Member upload (brief/file/image)
            $table->string('attachment')->nullable();

            // Payment (only podcast, PR, media release)
            $table->enum('payment_type', ['free', 'paid'])->default('free');
            $table->decimal('amount', 12, 2)->default(0);
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->string('transaction_id')->nullable();

            // Admin processing workflow
            $table->enum('status', [
                'requested',      // member requested branding
                'assigned',       // admin assigned team
                'in_progress',    // work ongoing
                'completed',      // delivered to member
                'rejected'        // admin rejected
            ])->default('requested');

            // Admin assign to branding team
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->text('admin_notes')->nullable();

            // Final output file (example: article PDF, video link, PR link)
            $table->string('final_output')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('admins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_branding_services');
    }
};
