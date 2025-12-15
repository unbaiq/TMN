<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('member_basic_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('full_name');
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('photo')->nullable();
            $table->string('contact_mobile')->nullable();
            $table->string('contact_whatsapp')->nullable();
            $table->string('contact_office')->nullable();
            $table->string('email')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('social_links')->nullable();
            $table->string('bni_chapter_name')->nullable();
            $table->string('bni_chapter_role')->nullable();
            $table->string('membership_id')->nullable();
            $table->date('date_joined')->nullable();
            $table->date('membership_renewal_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('member_basic_infos');
    }
};
