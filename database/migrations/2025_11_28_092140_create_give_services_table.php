<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('give_services', function (Blueprint $table) {
            $table->id();

            // Member who is giving the service
            $table->unsignedBigInteger('giver_member_id');

            // Member who is receiving the service
            $table->unsignedBigInteger('receiver_member_id')->nullable();

            // Domain of service (Branding, HR, Finance, IT etc.)
            $table->string('service_domain')->nullable();

            // Name of service given
            $table->string('service_name');

            // Service details
            $table->text('description')->nullable();

            // Optional proof or supporting file
            $table->string('attachment')->nullable();

            // Workflow status
            $table->enum('status', [
                'given',         // service has been given
                'received',      // receiver confirmed receipt
                'cancelled'
            ])->default('given');

            // Notes
            $table->text('giver_notes')->nullable();
            $table->text('receiver_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('giver_member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('receiver_member_id')->references('id')->on('members')->onDelete('set null');

            // Index
            $table->index(['giver_member_id', 'service_domain']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('give_services');
    }
};
