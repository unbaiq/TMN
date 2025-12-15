<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('member_admin_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['active', 'inactive', 'visitor', 'alumni'])->default('active');
            $table->enum('payment_status', ['paid', 'unpaid', 'pending'])->default('pending');
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->text('remarks')->nullable();

            // Optional advanced analytics
            $table->float('referral_conversion_rate')->nullable();
            $table->string('top_referral_partners')->nullable();
            $table->decimal('avg_business_value_per_referral', 10, 2)->nullable();
            $table->float('member_engagement_score')->nullable();
            $table->integer('chapter_impact_rank')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('member_admin_data');
    }
};
