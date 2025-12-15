<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('event_invitations', function (Blueprint $table) {
            $table->id();

            // Member who invited
            $table->foreignId('inviter_id')
                ->constrained('users')
                ->onDelete('cascade');

            // Event invited to
            $table->foreignId('event_id')
                ->constrained('events')
                ->onDelete('cascade');

            // Guest information
            $table->string('guest_name');
            $table->string('guest_email')->nullable();
            $table->string('guest_phone')->nullable();
            $table->string('profession')->nullable();

            // Invitation status
            $table->enum('status', ['invited', 'accepted', 'attended', 'declined'])
                  ->default('invited');

            // If guest later becomes a registered member
            $table->foreignId('converted_user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_invitations');
    }
};
