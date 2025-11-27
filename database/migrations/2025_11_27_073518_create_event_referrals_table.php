<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_referrals', function (Blueprint $table) {
            $table->id();

            // Member who generates referral token
            $table->unsignedBigInteger('referrer_member_id');

            // Event for which referral is generated
            $table->unsignedBigInteger('event_id');

            // Unique Referral Token
            $table->string('referral_token')->unique();

            // Person who used the token (optional: can be member or non-member)
            $table->unsignedBigInteger('referred_member_id')->nullable();

            // In case referred person is not TMN member
            $table->string('referred_name')->nullable();
            $table->string('referred_email')->nullable();
            $table->string('referred_phone')->nullable();

            // Status
            $table->enum('status', [
                'generated',     // token created
                'used',          // token used for registration
                'expired',       // event expired
                'invalid'
            ])->default('generated');

            // Timestamp when token was used
            $table->timestamp('used_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('referrer_member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('referred_member_id')->references('id')->on('members')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_referrals');
    }
};
