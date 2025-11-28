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

            // Main business transaction participants
            $table->unsignedBigInteger('member_one_id'); // giver or taker
            $table->unsignedBigInteger('member_two_id'); // opposite party

            // Defines role of member_one in the transaction
            $table->enum('member_one_role', [
                'giver',
                'taker'
            ]);

            // Business details
            $table->string('business_title');
            $table->text('description')->nullable();

            // Business value
            $table->decimal('business_value', 15, 2)->default(0);

            // Optional attachment (invoice, proof)
            $table->string('attachment')->nullable();

            // Business status
            $table->enum('status', [
                'initiated',
                'in_progress',
                'completed',
                'cancelled'
            ])->default('initiated');

            // Notes from both members
            $table->text('member_one_notes')->nullable();
            $table->text('member_two_notes')->nullable();

            // When completed
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('member_one_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('member_two_id')->references('id')->on('members')->onDelete('cascade');

            // Prevent duplicates for same business deal (optional)
            $table->index(['member_one_id', 'member_two_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_businesses');
    }
};
