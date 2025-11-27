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

            // Member who is taking the service
            $table->unsignedBigInteger('taker_member_id');

            // Member who is giving the service
            $table->unsignedBigInteger('giver_member_id')->nullable();

            // What service is being taken
            $table->string('service_name');

            // Description of the service taken
            $table->text('description')->nullable();

            // Optional attachment (e.g., document or file)
            $table->string('attachment')->nullable();

            // Status
            $table->enum('status', [
                'requested',     // taker requested service
                'received',      // service received successfully
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
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('take_services');
    }
};
