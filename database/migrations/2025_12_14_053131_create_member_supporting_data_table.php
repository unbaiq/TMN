<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('member_supporting_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('business_cards')->nullable();
            $table->string('profile_sheet')->nullable();
            $table->string('presentation_schedule')->nullable();
            $table->string('recent_training')->nullable();
            $table->string('awards')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('member_supporting_data');
    }
};
