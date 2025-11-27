<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cluster_meetings', function (Blueprint $table) {
            $table->id();

            // Title of the cluster meeting
            $table->string('title');

            // Description / Agenda
            $table->text('description')->nullable();

            // Meeting date and time
            $table->date('meeting_date')->nullable();
            $table->time('meeting_time')->nullable();

            // Meeting location (online/offline)
            $table->string('location')->nullable();
            $table->string('meeting_link')->nullable(); // for virtual meeting

            // Created by (admin or member)
            $table->unsignedBigInteger('created_by')->nullable();
            $table->enum('created_by_role', ['admin', 'member'])->default('member');

            // Status of the meeting
            $table->enum('status', [
                'scheduled',
                'completed',
                'cancelled'
            ])->default('scheduled');

            // Notes
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign key for creator
            $table->foreign('created_by')->references('id')->on('members')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cluster_meetings');
    }
};
