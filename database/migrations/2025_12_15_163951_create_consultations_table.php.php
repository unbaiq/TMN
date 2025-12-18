<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();

            /* =========================================================
             | IDENTIFICATION
             ========================================================= */
            $table->string('key', 255)
                ->unique()
                ->index()
                ->comment('Unique identifier e.g. build_brand_banner, why_tmn');

            /* =========================================================
             | CONTENT
             ========================================================= */
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('content')->nullable();

            /* =========================================================
             | CALL TO ACTION
             ========================================================= */
            $table->string('cta_text')->nullable();
            $table->string('cta_link')->nullable();

            /* =========================================================
             | FEED CONTROL
             ========================================================= */
            $table->integer('display_order')
                ->default(0)
                ->comment('Controls feed order');

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_public')->default(true);

            /* =========================================================
             | ANALYTICS
             ========================================================= */
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('clicks')->default(0);

            /* =========================================================
             | AUDIT
             ========================================================= */
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
