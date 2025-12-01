<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();

            // From which member (logged-in member)
            $table->foreignId('referrer_id')->constrained('users')->onDelete('cascade');

            // If the referred person becomes a TMN user later
            $table->foreignId('referred_member_id')->nullable()->constrained('users')->nullOnDelete();

            // Referral personal details
            $table->string('referral_name')->nullable();
            $table->string('referral_phone')->nullable();   // UPDATED
            $table->string('referral_email')->nullable();   // NEW FIELD

            // Notes (extra details)
            $table->text('notes')->nullable();

            // Status
            $table->enum('status', ['pending', 'converted', 'rejected'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
