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

            // reference users table (members are stored in `users`)
            $table->foreignId('giver_member_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->foreignId('receiver_member_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->string('service_title');
            $table->text('description')->nullable();
            $table->decimal('fee', 12, 2)->nullable();
            $table->enum('status', ['open','accepted','completed','cancelled'])->default('open');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('give_services');
    }
};
