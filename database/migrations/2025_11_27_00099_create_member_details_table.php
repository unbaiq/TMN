<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This table stores *additional* member information for users already present
     * in the `users` table (one-to-one relationship). It is NOT used to create users.
     */
    public function up(): void
    {
        // guard: do nothing if table already exists (prevents duplicate-create errors)
        if (Schema::hasTable('member_details')) {
            return;
        }

        Schema::create('member_details', function (Blueprint $table) {
            $table->id();

            // one-to-one link to users table (member profile)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->comment('References users.id - one-to-one');

            // basic profile / business info
            $table->string('business_name')->nullable();
            $table->text('address')->nullable();
            $table->string('city', 120)->nullable();
            $table->string('pincode', 20)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('referral_code', 100)->nullable();

            // optional additional contact / meta
            $table->string('secondary_phone', 30)->nullable();
            $table->string('website')->nullable();
            $table->json('extra')->nullable()->comment('JSON for extensible meta (optional)');

            // status + timestamps
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // indexes for common queries
            $table->index('city');
            $table->index('pincode');
            $table->index('phone');

            // enforce one profile per user
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_details');
    }
};
