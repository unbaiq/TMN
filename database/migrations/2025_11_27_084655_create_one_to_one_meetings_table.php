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

            // Member who receives the 1-to-1 meet request
            $table->unsignedBigInteger('requested_member_id');

            // Location (face-to-face, café, office, online link, etc.)
            $table->string('location')->nullable();

            // Meeting date & time
            $table->date('meeting_date')->nullable();
            $table->time('meeting_time')->nullable();

            // Notes from requester
            $table->text('notes')->nullable();

            // Status
            $table->enum('status', [
                'requested',
                'scheduled',
                'completed',
                'cancelled'
            ])->default('requested');

            $table->timestamps();

            // FK
            $table->foreign('requested_member_id')
                ->references('id')->on('members')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('one_to_one_meetings');
    }
};
