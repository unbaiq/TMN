<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_expectations', function (Blueprint $table) {
            $table->id();

            // Member
            $table->unsignedBigInteger('member_id');

            // Current turnover of the member's business
            $table->decimal('current_turnover', 15, 2)->nullable();

            // What member expects from TMN
            $table->longText('expectation_with_tmn')->nullable();

            // Optional: future vision or goals
            $table->longText('future_goals')->nullable();

            // Optional: Areas where support is expected
            $table->string('support_area')->nullable(); 
            // Example: Networking, Branding, Funding, Collaborations

            // Admin can review
            $table->enum('status', ['pending', 'reviewed'])->default('pending');

            // Which admin reviewed
            $table->unsignedBigInteger('reviewed_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('reviewed_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_expectations');
    }
};
