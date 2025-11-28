<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();

            // Basic enquiry details
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('contact_number', 20)->nullable();
            $table->string('profession')->nullable();

            // Where they came from
            $table->enum('source', ['website', 'referral', 'direct', 'social'])
                  ->default('website')
                  ->comment('How the enquiry entered: website form, member referral, direct walk-in, social media');

            // Referral system fields
            $table->string('referral_code')->nullable()
                  ->comment('Referral code entered by enquiry');

            $table->unsignedBigInteger('referred_by')->nullable()
                  ->comment('User ID of the member who referred this enquiry');

            // Foreign key (optional)
            $table->foreign('referred_by')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();

            // Status of enquiry
            $table->enum('status', ['new', 'in_progress', 'closed'])
                  ->default('new');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
