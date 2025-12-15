<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();

            // BASIC DETAILS
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->string('company_name')->nullable();
            $table->string('industry')->nullable();
            $table->string('designation')->nullable();
            $table->text('about')->nullable();

            // CONTACT DETAILS
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('alternate_phone', 20)->nullable();
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();

            // ADDRESS
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('India');
            $table->string('pincode', 10)->nullable();

            // PARTNERSHIP DETAILS
            $table->enum('partner_type', ['strategic', 'sponsor', 'vendor', 'associate', 'technology'])->default('associate');
            $table->enum('level', ['platinum', 'gold', 'silver', 'bronze'])->default('silver');
            $table->string('partnership_duration')->nullable()->comment('e.g. 1 Year, 3 Months');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // MEDIA
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('gallery')->nullable(); // JSON for multiple images
            $table->string('brochure')->nullable(); // Optional PDF

            // LINKS & BRAND INFO
            $table->string('profile_link')->nullable();
            $table->string('promo_video')->nullable();

            // STATUS
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->enum('status', ['pending', 'approved', 'rejected', 'expired'])->default('approved');

            // ANALYTICS
            $table->integer('views')->default(0);
            $table->integer('clicks')->default(0);
            $table->integer('inquiries')->default(0);

            // SEO & META
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            // AUDIT TRAIL
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

            // FOREIGN KEYS
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
