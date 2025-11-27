<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_documents', function (Blueprint $table) {
            $table->id();

            // Member
            $table->unsignedBigInteger('member_id');

            // Document Types
            $table->enum('document_type', [
                'business_proof',
                'id_proof',
                'company_profile',
                'others'
            ]);

            // File path
            $table->string('file_path');

            // ------------------------------------------
            // PAYMENT SECTION
            // ------------------------------------------
            $table->enum('payment_type', ['free', 'paid'])->default('free');
            $table->decimal('amount', 10, 2)->default(0);
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->string('transaction_id')->nullable();

            // ------------------------------------------
            // ACTION & ASSIGNMENT SECTION
            // ------------------------------------------
            $table->enum('action', [
                'requested',     // member uploaded
                'assigned',      // admin assigned (admin + chapter)
                'verified',
                'rejected'
            ])->default('requested');

            // Admin assigned to work on the document
            $table->unsignedBigInteger('assigned_to')->nullable();

            // NEW → Chapter assignment
            $table->unsignedBigInteger('assigned_chapter_id')->nullable();

            $table->text('assignment_notes')->nullable();

            // ------------------------------------------
            // VERIFICATION SECTION
            // ------------------------------------------
            $table->enum('status', [
                'pending',
                'approved',
                'rejected'
            ])->default('pending');

            $table->unsignedBigInteger('verified_by')->nullable();
            $table->text('rejection_reason')->nullable();

            // Common fields
            $table->timestamps();
            $table->softDeletes();

            // ------------------------------------------
            // FOREIGN KEYS
            // ------------------------------------------
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('admins')->onDelete('set null');

            // NEW FK → chapter assigned to verify
            $table->foreign('assigned_chapter_id')->references('id')->on('chapters')->onDelete('set null');

            $table->foreign('verified_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_documents');
    }
};
