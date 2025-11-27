<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_investors', function (Blueprint $table) {
            $table->id();

            // Member who is the investor
            $table->unsignedBigInteger('member_id');

            // Amount member wishes to invest
            $table->decimal('investment_amount', 15, 2)->default(0);

            // Interested categories (Example: Tech, Health, EdTech, FMCG)
            $table->string('interested_categories')->nullable(); 
            // comma-separated or JSON depending on your design

            // Interested startup type (Early-stage, Seed, Series-A, etc.)
            $table->string('startup_interest')->nullable();

            // Additional notes from member
            $table->text('member_notes')->nullable();

            // Admin verification status
            $table->enum('status', [
                'pending',      // member added investor info
                'verified',     // admin verified
                'rejected',     // admin rejected
            ])->default('pending');

            $table->unsignedBigInteger('verified_by')->nullable();
            $table->text('rejection_reason')->nullable();

            // Admin internal notes
            $table->text('admin_notes')->nullable();

            // Investment documents (optional)
            $table->string('investment_proof')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('verified_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_investors');
    }
};
