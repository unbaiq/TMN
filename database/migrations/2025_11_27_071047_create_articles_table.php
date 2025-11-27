<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            // Basic
            $table->string('title');
            $table->string('slug')->unique();

            // Image (list shows thumbnail)
            $table->string('image')->nullable();

            // Client Name
            $table->string('client_name')->nullable();

            // Description (short content)
            $table->text('description')->nullable();

            // Date shown in table
            $table->date('published_date')->nullable();

            // Status toggle
            $table->boolean('is_active')->default(true);

            // Optional category
            $table->foreignId('category_id')->nullable()->constrained('article_categories')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
