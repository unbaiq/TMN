<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();

            // Professional identity
            $table->string('name');                 // professional full name
            $table->string('slug')->unique();       // url-friendly

            // Professional details (requested fields)
            $table->string('profession')->nullable()->comment('e.g. Business Coach, CA, HR Consultant');
            $table->integer('experience_years')->nullable()->comment('Years of experience');
            $table->integer('age')->nullable()->comment('Age of professional (optional)');
            $table->text('achievements')->nullable()->comment('Key achievements, awards, highlights');

            // Optional descriptive fields
            $table->text('short_bio')->nullable();
            $table->string('image')->nullable();    // profile picture path

            // Admin / UI controls
            $table->boolean('is_active')->default(true)->index();
            $table->integer('order_no')->default(1)->index();

            // Who added/profile owner (optional)
            $table->foreignId('added_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes(); // allow safe removal & restore
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
