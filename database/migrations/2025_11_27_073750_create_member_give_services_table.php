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

            // What service is given
            $table->string('service_name');

            // Description of what was given
            $table->text('description')->nullable();

            // Optional attachment (e.g., file/image proof)
            $table->string('attachment')->nullable();

            // Status of the service providing
            $table->enum('status', [
                'given',         // giver has provided service
                'received',      // receiver confirmed
                'cancelled'
            ])->default('given');

            // Notes
            $table->text('giver_notes')->nullable();
            $table->text('receiver_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('giver_member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('receiver_member_id')->references('id')->on('members')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('give_services');
    }
};
