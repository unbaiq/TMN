<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_businesses', function (Blueprint $table) {
            $table->id();

            // reference users table (members stored in users)
            $table->foreignId('member_one_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('member_two_id')->nullable()->constrained('users')->nullOnDelete();

            // Role of member_one
            $table->enum('member_one_role', ['giver', 'taker']);

            // Business details
            $table->string('business_title');
            $table->text('description')->nullable();

            // Business value
            $table->decimal('business_value', 15, 2)->default(0);

            // Optional attachment (file path or filename)
            $table->string('attachment')->nullable();

            // Business status
            $table->enum('status', ['initiated','in_progress','completed','cancelled'])->default('initiated');

            // Notes from both parties
            $table->text('member_one_notes')->nullable();
            $table->text('member_two_notes')->nullable();

            // Completed timestamp
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes for queries
            $table->index(['member_one_id', 'member_two_id']);
            $table->index('status');
            $table->index('member_one_role');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_businesses');
    }
};
