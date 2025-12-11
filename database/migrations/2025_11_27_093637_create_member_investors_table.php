<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_investors', function (Blueprint $table) {
            $table->id();

            // reference users table for the member (safe & common)
            $table->foreignId('member_id')->constrained('users')->cascadeOnDelete();

            $table->decimal('investment_amount', 15, 2)->default(0);
            $table->string('interested_categories')->nullable(); // comma or JSON per design
            $table->string('startup_interest')->nullable();
            $table->text('member_notes')->nullable();

            $table->enum('status', ['pending','verified','rejected'])->default('pending');

            // who verified (nullable user id)
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();

            $table->text('rejection_reason')->nullable();
            $table->text('admin_notes')->nullable();
            $table->string('investment_proof')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_investors');
    }
};
