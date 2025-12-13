<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // This migration ONLY MODIFIES an existing table
        // It NEVER creates member_details

        Schema::table('member_details', function (Blueprint $table) {

            if (! Schema::hasColumn('member_details', 'user_id')) {
                $table->foreignId('user_id')
                      ->nullable()
                      ->unique()
                      ->after('id')
                      ->constrained('users')
                      ->cascadeOnDelete();
            }

            if (! Schema::hasColumn('member_details', 'phone')) {
                $table->string('phone', 20)->nullable()->after('user_id');
            }

            if (! Schema::hasColumn('member_details', 'business_name')) {
                $table->string('business_name')->nullable()->after('phone');
            }

            if (! Schema::hasColumn('member_details', 'address')) {
                $table->text('address')->nullable()->after('business_name');
            }

            if (! Schema::hasColumn('member_details', 'city')) {
                $table->string('city')->nullable()->after('address');
            }

            if (! Schema::hasColumn('member_details', 'pincode')) {
                $table->string('pincode', 20)->nullable()->after('city');
            }

            if (! Schema::hasColumn('member_details', 'referral_code')) {
                $table->string('referral_code')->nullable()->after('pincode');
                $table->index('referral_code');
            }

            if (! Schema::hasColumn('member_details', 'meta')) {
                $table->json('meta')->nullable()->after('referral_code');
            }
        });
    }

    public function down(): void
    {
        // intentionally left empty to prevent data loss
    }
};
