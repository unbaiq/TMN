<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('take_services', function (Blueprint $table) {
            $table->id();

            // Member taking the service
            $table->unsignedBigInteger('taker_member_id');

            // Member giving the service
            $table->unsignedBigInteger('giver_member_id')->nullable();

            // Domain of service (Branding, HR, Finance etc.)
            $table->string('service_domain')->nullable();

            // Name of service being taken
            $table->string('service_name');

            // Details of service
            $table->text('description')->nullable();

            // Optional shared document/proof
            $table->string('attachment')->nullable();

            // Status workflow
            $table->enum('status', [
                'requested',     // taker requested service
                'received',      // taker received service
                'completed',     // both confirm service completed
                'cancelled'
            ])->default('requested');

            // Notes
            $table->text('taker_notes')->nullable();
            $table->text('giver_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('taker_member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('giver_member_id')->references('id')->on('members')->onDelete('set null');

            // Index
            $table->index(['taker_member_id', 'service_domain']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('take_services');
    }
};
