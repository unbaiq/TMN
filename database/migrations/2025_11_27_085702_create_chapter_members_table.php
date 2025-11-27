<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chapter_members', function (Blueprint $table) {
            $table->id();

            // Links
            $table->foreignId('chapter_id')->constrained('chapters')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade');

            // Role within chapter (member, chapter_admin, coordinator, etc.)
            $table->string('role')->default('member')->index();

            // Approval & verification
            $table->enum('approval_status', ['pending','approved','rejected'])->default('pending')->index();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete()->comment('Admin who approved membership');
            $table->timestamp('approved_at')->nullable();

            // Verification of documents (per member per chapter)
            $table->enum('verification_status', ['unverified','verified','rejected'])->default('unverified')->index();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete()->comment('Admin who verified documents');
            $table->timestamp('verified_at')->nullable();

            // Optional notes
            $table->text('admin_notes')->nullable();

            $table->timestamps();

            $table->unique(['chapter_id','member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapter_members');
    }
};
