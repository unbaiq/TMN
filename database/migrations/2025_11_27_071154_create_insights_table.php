<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insights', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            $table->foreignId('category_id')->nullable()->constrained('insight_categories')->nullOnDelete();

            // UI fields
            $table->string('image')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();

            // Date field shown in list
            $table->date('published_date')->nullable();

            // Status (toggle)
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insights');
    }
};
