<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_profiles', function (Blueprint $table) {
            $table->id();

            // Link to users table
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Personal Details
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable()->default('India');
            $table->string('pincode', 10)->nullable();

            // Business Details
            $table->string('business_name')->nullable();
            $table->string('business_type')->nullable()->comment('Industry / Category');
            $table->string('designation')->nullable()->comment('Position in company');
            $table->text('business_description')->nullable();

            // Additional optional fields
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_profiles');
    }
};
