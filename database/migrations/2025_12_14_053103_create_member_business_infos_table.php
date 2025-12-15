<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('member_business_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('industry')->nullable();
            $table->string('business_type')->nullable();
            $table->text('business_description')->nullable();
            $table->text('office_address')->nullable();
            $table->string('website_url')->nullable();
            $table->integer('years_in_business')->nullable();
            $table->text('target_clients')->nullable();
            $table->text('usp')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('member_business_infos');
    }
};
