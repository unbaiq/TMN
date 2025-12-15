<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('member_relationship_intelligence', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('connection_strength', ['close', 'moderate', 'new'])->nullable();
            $table->text('collaboration_history')->nullable();
            $table->text('follow_up_notes')->nullable();
            $table->enum('preferred_communication', ['call', 'whatsapp', 'email'])->nullable();
            $table->text('interests')->nullable();
            $table->date('key_date_birthday')->nullable();
            $table->date('key_date_anniversary')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('member_relationship_intelligence');
    }
};
