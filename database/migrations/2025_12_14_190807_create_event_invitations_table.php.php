<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('event_invitations', function (Blueprint $table) {
            $table->id();

            // 👤 Member who invited
            $table->foreignId('inviter_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // 📅 Event invited to
            $table->foreignId('event_id')
                ->constrained('events')
                ->cascadeOnDelete();

            // 👥 Guest information
            $table->string('guest_name');
            $table->string('guest_email')->nullable()->index();
            $table->string('guest_phone')->nullable();
            $table->string('profession')->nullable();

            // 🔗 Unique token for membership registration
            $table->uuid('membership_token')
                ->nullable()
                ->unique();

            // 📌 Invitation status
            $table->enum('status', [
                'invited',
                'accepted',
                'attended',
                'declined'
            ])->default('invited');

            // 🔄 If guest later becomes a registered user
            $table->foreignId('converted_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // 🕒 Audit timestamps
            $table->timestamps();

            // 🚀 Performance / Safety Indexes
            $table->index(['event_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_invitations');
    }
};
