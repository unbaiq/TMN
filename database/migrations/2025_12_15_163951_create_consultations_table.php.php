
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();

            // IDENTIFICATION
            $table->string('key')->unique()
                  ->comment('Unique identifier e.g. tmn_welcome, why_tmn');

            // CONTENT
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('content')->nullable();

            // CTA
            $table->string('cta_text')->nullable();
            $table->string('cta_link')->nullable();

            // FEED CONTROL
            $table->integer('display_order')->default(0)
                  ->comment('Controls feed order');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_public')->default(true);

            // ANALYTICS
            $table->integer('views')->default(0);
            $table->integer('clicks')->default(0);

            // AUDIT
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();

            // FOREIGN KEYS
            $table->foreign('created_by')
                  ->references('id')->on('users')
                  ->nullOnDelete();

            $table->foreign('updated_by')
                  ->references('id')->on('users')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
