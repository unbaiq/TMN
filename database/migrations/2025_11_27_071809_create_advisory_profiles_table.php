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
        Schema::create('advisory_profiles', function (Blueprint $table) {
            $table->id();

            // Basic public profile fields
            $table->string('name');
            $table->string('slug')->unique();         // url friendly

            $table->string('title')->nullable();      // e.g., Mentor, Advisor, Chairman
            $table->string('company')->nullable();

            // Media / display
            $table->string('image')->nullable();      // profile picture path

            // Contact / social (optional)
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('linkedin')->nullable();

            // Bio / expertise
            $table->text('short_bio')->nullable();    // short description shown in lists
            $table->string('expertise')->nullable()->comment('Comma separated keywords');

            // Admin controls / display ordering
            $table->boolean('is_active')->default(true)->index();
            $table->integer('order_no')->default(1)->index();

            

            $table->timestamps();
            $table->softDeletes(); // allows safe deletes and restoring
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisory_profiles');
    }
};
