<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('csrs', function (Blueprint $table) {
            $table->id();

            // who logged this CSR (member or organisation)
            $table->foreignId('member_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('organization_name')->nullable();
            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->nullOnDelete();

            $table->decimal('amount_to_invest', 18, 2)->nullable();
            $table->string('currency', 10)->default('INR');

            // categories: skill development / health support / others
            $table->enum('interested_category', ['skill_development','health_support','others'])->nullable();

            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('csrs');
    }
};
