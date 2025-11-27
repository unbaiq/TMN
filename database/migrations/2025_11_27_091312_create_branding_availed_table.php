<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branding_availed', function (Blueprint $table) {
            $table->id();

            // Link to chapter & member who availed
            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->nullOnDelete();
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade');

            // Type: normal (complimentary/basic) or paid (paid branding package)
            $table->enum('type', ['normal','paid'])->default('normal');

            // If paid
            $table->decimal('amount_paid', 14, 2)->nullable();
            $table->string('currency', 10)->default('INR');

            $table->string('package')->nullable()->comment('Optional package name for paid branding');
            $table->timestamp('availed_at')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branding_availed');
    }
};
