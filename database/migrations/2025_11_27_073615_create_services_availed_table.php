<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services_availed', function (Blueprint $table) {
            $table->id();

            // Member who availed the service
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade');

            // Which professional (consultation) the member used
            $table->foreignId('consultation_id')->constrained('consultations')->onDelete('cascade');

            // Snapshot fields (optional but recommended)
            $table->string('member_name_snapshot')->nullable()->comment('Member name at time of booking');
            $table->string('professional_name_snapshot')->nullable()->comment('Professional name at time of booking');
            $table->string('professional_profession_snapshot')->nullable()->comment('Professional profession at time of booking');

            // Booking / availed info
            $table->timestamp('availed_at')->nullable()->comment('When the service was availed or completed');
            $table->timestamp('scheduled_at')->nullable()->comment('Scheduled date/time for the session');

            // Financial snapshot
            $table->decimal('price_paid', 10, 2)->nullable();
            $table->string('currency', 10)->default('INR');
            $table->enum('payment_status', ['pending','paid','failed','refunded'])->default('pending');

            // Administrative & lifecycle
            $table->enum('status', ['requested','confirmed','completed','cancelled'])->default('requested')->index();
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete()->comment('Admin who handled this request');

            $table->text('member_notes')->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services_availed');
    }
};
