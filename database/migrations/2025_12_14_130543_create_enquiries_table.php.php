<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');                        // Enquirer's name
            $table->string('email')->nullable();           // Enquirer's email
            $table->string('contact_number', 20)->nullable(); // Contact number
            $table->string('profession')->nullable();      // Profession or business type
            $table->boolean('is_agreed')->default(false);  // Privacy & terms agreement
            $table->string('source')->nullable();          // Optional - track where enquiry came from
            $table->string('status')->default('new');
            $table->uuid('membership_token')->nullable();  // Unique token for member registration
            $table->boolean('converted_to_member')->default(false); // Converted to member flag
            $table->timestamps();                          // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
