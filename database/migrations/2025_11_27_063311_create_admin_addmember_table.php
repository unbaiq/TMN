<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Basic info
            $table->string('name');
            $table->string('phone', 20)->nullable()->unique();
            $table->string('email')->unique();
            $table->date('date');

            // Security
            $table->string('password');

            // Role: admin or member
            $table->enum('role', ['admin', 'member'])->default('member');

            // Referral System
            $table->unsignedBigInteger('refer_id')->nullable()
                  ->comment('User ID of the referrer (who referred this member)');
            
            // Financial Tracking
            $table->decimal('total_amount', 10, 2)->default(0)
                  ->comment('Total amount paid or earned by the member');

            // Membership Dates
            $table->date('membership_start_date')->nullable()
                  ->comment('Membership start date');

            $table->date('membership_end_date')->nullable()
                  ->comment('Membership end date / expiry date');

            // Optional extras
            $table->boolean('is_active')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
