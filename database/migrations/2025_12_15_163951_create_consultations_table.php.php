
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

<<<<<<< Updated upstream
return new class extends Migration
{
=======
return new class extends Migration {

>>>>>>> Stashed changes
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();

<<<<<<< Updated upstream
            /*
            |--------------------------------------------------------------------------
            | IDENTIFICATION
            |--------------------------------------------------------------------------
            | Using `key` is allowed, but we explicitly index it for performance
            */
            $table->string('key', 255)
                  ->unique()
                  ->index()
                  ->comment('Unique identifier e.g. build_brand_banner, why_tmn');

            /*
            |--------------------------------------------------------------------------
            | CONTENT
            |--------------------------------------------------------------------------
            */
=======
            // IDENTIFICATION
            $table->string('key')->unique()
                  ->comment('Unique identifier e.g. tmn_welcome, why_tmn');

            // CONTENT
>>>>>>> Stashed changes
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('content')->nullable();

<<<<<<< Updated upstream
            /*
            |--------------------------------------------------------------------------
            | CALL TO ACTION
            |--------------------------------------------------------------------------
            */
            $table->string('cta_text')->nullable();
            $table->string('cta_link')->nullable();

            /*
            |--------------------------------------------------------------------------
            | FEED CONTROL
            |--------------------------------------------------------------------------
            */
            $table->integer('display_order')->default(0);
=======
            // CTA
            $table->string('cta_text')->nullable();
            $table->string('cta_link')->nullable();

            // FEED CONTROL
            $table->integer('display_order')->default(0)
                  ->comment('Controls feed order');
>>>>>>> Stashed changes
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_public')->default(true);

<<<<<<< Updated upstream
            /*
            |--------------------------------------------------------------------------
            | ANALYTICS
            |--------------------------------------------------------------------------
            */
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('clicks')->default(0);

            /*
            |--------------------------------------------------------------------------
            | AUDIT
            |--------------------------------------------------------------------------
            */
            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->foreignId('updated_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamps();
=======
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
>>>>>>> Stashed changes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
