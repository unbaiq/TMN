<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_connects', function (Blueprint $table) {
            $table->id();

            // 🔗 Member reference
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // 👤 Personal details
            $table->string('person_name');                // Contact person name
            $table->string('designation')->nullable();    // Founder / Director / Manager

            // 🏢 Business details
            $table->string('company_name');
            $table->string('industry');                   // IT, Finance, Interior
            $table->string('profession');                 // Interior Designer
            $table->text('services')->nullable();         // What they offer
            $table->string('website')->nullable();

            // 📞 Contact details
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('whatsapp_number')->nullable();

            // 📍 Location & chapter
            $table->string('location')->nullable();       // City / Area
          
                           // Who can view
            $table->boolean('is_verified')
                ->default(false);                         // Approved by admin
            $table->boolean('is_active')
                ->default(true);

            // ⭐ Engagement
            $table->unsignedInteger('recommendation_count')
                ->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_connects');
    }
};
