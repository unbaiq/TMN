<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('member_networking_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('referrals_given')->default(0);
            $table->integer('referrals_received')->default(0);
            $table->decimal('closed_business_value', 15, 2)->default(0);
            $table->integer('one_to_one_meetings')->default(0);
            $table->integer('testimonials_given')->default(0);
            $table->integer('testimonials_received')->default(0);
            $table->integer('visitor_invites')->default(0);
            $table->integer('substitute_attendance')->default(0);
            $table->integer('weekly_attendance')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('member_networking_data');
    }
};
