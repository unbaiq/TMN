<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('one_to_one_meetings', function (Blueprint $table) {
            $table->id();

            // Member who initiates the 1-to-1 request
            $table->unsignedBigInteger('requester_member_id');

            // Member who receives the 1-to-1 request
            $table->unsignedBigInteger('receiver_member_id');

            // Optional meeting details
            $table->date('meeting_date')->nullable();
            $table->time('meeting_time')->nullable();
            $table->string('location')->nullable(); // face-to-face or venue

            // Virtual meeting link (if online)
            $table->string('meeting_link')->nullable();

            // Request notes
            $table->text('requester_notes')->nullable();
            $table->text('receiver_notes')->nullable();

            // Meeting status
            $table->enum('status', [
                'requested',      // requester sent request
                'accepted',       // receiver accepted the meeting
                'rejected',       // refused
                'completed',      // meeting happened
                'cancelled'       // cancelled by either
            ])->default('requested');

            // Timestamp for when meeting was completed
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('requester_member_id')
                  ->references('id')->on('members')->onDelete('cascade');

            $table->foreign('receiver_member_id')
                  ->references('id')->on('members')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('one_to_one_meetings');
    }
};
