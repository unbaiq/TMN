<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_connections', function (Blueprint $table) {
            $table->id();

            // Member who sends the connection request
            $table->unsignedBigInteger('sender_member_id');

            // Member who receives the connection request
            $table->unsignedBigInteger('receiver_member_id');

            // Optional message when sending connection
            $table->text('message')->nullable();

            // Status of connection
            $table->enum('status', [
                'pending',      // request sent
                'accepted',     // accepted
                'rejected'      // rejected
            ])->default('pending');

            // Optional notes
            $table->text('sender_notes')->nullable();
            $table->text('receiver_notes')->nullable();

            // When accepted (optional)
            $table->timestamp('accepted_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('sender_member_id')
                  ->references('id')->on('members')->onDelete('cascade');

            $table->foreign('receiver_member_id')
                  ->references('id')->on('members')->onDelete('cascade');

            // Unique constraint: Prevent duplicate connection requests
            $table->unique(['sender_member_id', 'receiver_member_id'], 'unique_connection');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_connections');
    }
};
