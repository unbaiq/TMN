<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();

            // Event reference
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');

            // Member reference
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade');

            // Snapshot member name for history
            $table->string('member_name_snapshot')->nullable()->comment('Member name at time of registration');

            // When registered
            $table->timestamp('registered_at')->useCurrent();

            // Only two possible states: registered (default), attended
            $table->enum('status', ['registered','attended'])->default('registered')->index();

            $table->timestamps();

            // Prevent duplicate registrations
            $table->unique(['event_id', 'member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
 