<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();

            // Basic enquiry details
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('contact_number', 20)->nullable();
            $table->string('profession')->nullable();

          

            // Track enquiry status
            $table->enum('status', ['new', 'in_progress', 'closed'])
                ->default('new');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
