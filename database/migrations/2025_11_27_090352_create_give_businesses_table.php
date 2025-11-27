<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('give_businesses', function (Blueprint $table) {
            $table->id();

            // Member who gives business
            $table->unsignedBigInteger('giver_member_id');

            // Member who receives business
            $table->unsignedBigInteger('receiver_member_id')->nullable();

            // Business description
            $table->string('business_title');
            $table->text('description')->nullable();

            // Value of business given
            $table->decimal('business_value', 15, 2)->default(0);

            // Optional proof attachment
            $table->string('attachment')->nullable();

            // Status (Give Business)
            $table->enum('status', [
                'given',         // giver provided business lead
                'acknowledged',  // receiver accepted the lead
                'converted',     // business is completed
                'closed',        // closed without conversion
                'cancelled'
            ])->default('given');

            // Notes
            $table->text('giver_notes')->nullable();
            $table->text('receiver_notes')->nullable();

            // When converted (finished)
            $table->timestamp('converted_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('giver_member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('receiver_member_id')->references('id')->on('members')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('give_businesses');
    }
};
