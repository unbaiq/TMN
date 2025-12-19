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
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
        
            $table->string('chapter_code')->nullable();
            $table->string('name');
            $table->string('slug');
        
            $table->string('city')->nullable();
            $table->string('state')->nullable();     // ✅ no AFTER
            $table->string('country')->nullable();   // ✅ no AFTER
            $table->string('pincode', 20)->nullable();
        
            $table->integer('capacity_no')->default(0);
            $table->boolean('is_active')->default(true);
        
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};
