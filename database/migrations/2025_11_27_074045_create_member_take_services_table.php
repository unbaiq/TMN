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

            // Member requesting the service
            $table->unsignedBigInteger('taker_member_id');

            // Giver stored as NAME (because frontend uses name dropdown)
            $table->string('giver_name')->nullable();

            // Service fields
            $table->string('service_name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('service_date')->nullable();

            $table->text('description')->nullable();
            $table->string('attachment')->nullable();

            // Status: same as in your UI
            $table->enum('status', ['Requested', 'Received', 'Cancelled'])->default('Requested');

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('taker_member_id')->references('id')->on('members')->onDelete('cascade');

            // Giver FK optional (NULL because UI does not use member_id)
            $table->foreign('giver_member_id')->references('id')->on('members')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('take_services');
    }
};
