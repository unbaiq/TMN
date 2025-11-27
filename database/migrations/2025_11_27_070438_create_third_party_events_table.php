<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('third_party_events', function (Blueprint $table) {
            $table->id();

            // Member who attended the event
            $table->unsignedBigInteger('member_id');

            // Event Details (external)
            $table->string('event_name');
            $table->string('organizer')->nullable();
            $table->string('location')->nullable();
            $table->date('event_date')->nullable();
            $table->text('description')->nullable();

            // Proof of participation (certificate/image/pdf)
            $table->string('proof_file')->nullable();

            // Member notes (optional)
            $table->text('member_notes')->nullable();

            // Admin verification
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->text('rejection_reason')->nullable();

            // Admin notes
            $table->text('admin_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('verified_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('third_party_events');
    }
};
