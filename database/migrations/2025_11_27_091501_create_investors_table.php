<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investors', function (Blueprint $table) {
            $table->id();

            // who this investor record belongs to (member / external)
            $table->foreignId('member_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name')->nullable()->comment('Investor name (if external)');
            $table->string('contact')->nullable();

            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->nullOnDelete();

            $table->decimal('amount_to_invest', 18, 2)->nullable();
            $table->string('currency', 10)->default('INR');

            // Interested categories: startup / partner / sponsor
            $table->enum('interested_category', ['startup','partner','sponsor'])->nullable();

            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investors');
    }
};
