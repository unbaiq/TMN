<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();

            // Basic details
            $table->string('name');
            $table->string('slug')->unique();

            // UI fields
            $table->string('logo')->nullable();
          
            $table->boolean('is_active')->default(true)->index();

            // Duration
            $table->date('start_date')->nullable();
           
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
