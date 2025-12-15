<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_relationship_intelligences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('connection_strength')->nullable();
            $table->text('collaboration_history')->nullable();
            $table->text('follow_up_notes')->nullable();
            $table->string('preferred_communication')->nullable();
            $table->string('interests')->nullable();
            $table->date('key_date_birthday')->nullable();
            $table->date('key_date_anniversary')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_relationship_intelligences');
    }
};
