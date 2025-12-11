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

            // Member requesting the service (references users table primary key)
            $table->foreignId('taker_member_id')->constrained('users')->cascadeOnDelete();

            // Giver stored as NAME (because frontend uses name dropdown)
            $table->string('giver_name')->nullable();

            // If you want to optionally link giver to a user record, add this column:
            $table->foreignId('giver_member_id')->nullable()->constrained('users')->nullOnDelete();

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
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('take_services');
    }
};
