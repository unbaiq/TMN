<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('take_businesses', function (Blueprint $table) {
            $table->id();

            // Member who takes business
            $table->unsignedBigInteger('taker_member_id');

            // Member who gives business
            $table->unsignedBigInteger('giver_member_id')->nullable();

            // Business details
            $table->string('business_title');
            $table->text('description')->nullable();

            // Value of business taken
            $table->decimal('business_value', 15, 2)->default(0);

            // Proof (invoice, screenshot)
            $table->string('attachment')->nullable();

            // Status (Take Business)
            $table->enum('status', [
                'requested',
                'received',
                'completed',
                'cancelled'
            ])->default('requested');

            // Notes
            $table->text('taker_notes')->nullable();
            $table->text('giver_notes')->nullable();

            // Business confirmation
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('taker_member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('giver_member_id')->references('id')->on('members')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('take_businesses');
    }
};
