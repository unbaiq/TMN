<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_csrs', function (Blueprint $table) {
            $table->id();

            // Member / Organization offering CSR (could be a member or partner)
            $table->unsignedBigInteger('member_id')->nullable();

            // Title of CSR project
            $table->string('title');

              // Short slug for URL (optional)
            $table->string('slug')->nullable()->unique();

            // Category / focus area (Health, Education, Skill Development, Environment, Others)
            $table->string('category')->nullable();

            // Detailed description of the CSR initiative
            $table->longText('description')->nullable();

            // Amount committed for CSR (in organization's currency)
            $table->decimal('amount', 15, 2)->default(0);

            // Currency code (optional)
            $table->string('currency', 10)->default('INR');

            // Partner / NGO details (if working with external partner)
            $table->string('partner_name')->nullable();
            $table->string('partner_contact')->nullable();
            $table->string('partner_email')->nullable();

            // Geographic / chapter focus (optional)
            $table->unsignedBigInteger('chapter_id')->nullable();

            // Project timeline
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // Project status / workflow
            $table->enum('status', [
                'planned',    // idea / planned
                'ongoing',    // in execution
                'completed',  // finished
                'on_hold',    // paused
                'cancelled'
            ])->default('planned');

            // Admin verification/approval
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->text('approval_notes')->nullable();

            // Documents / proof (proposal, MoU, photos)
            $table->string('document')->nullable();
            $table->string('report_file')->nullable(); // final report

            // Impact metrics (optional numeric summary)
            $table->integer('beneficiaries_count')->nullable()->default(0);
            $table->text('impact_summary')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('member_id')->references('id')->on('members')->onDelete('set null');
            $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('set null');
            $table->foreign('approved_by')->references('id')->on('admins')->onDelete('set null');

            // Indexes for common queries
            $table->index(['status', 'approval_status']);
            $table->index('category');
            $table->index('chapter_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_csrs');
    }
};
