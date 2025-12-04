<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_csrs', function (Blueprint $table) {
            $table->id();

            // Member offering CSR
            $table->unsignedBigInteger('member_id')->nullable()->index();

            // Who created the CSR record
            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->enum('creator_role', ['admin','member','partner'])->default('admin');

            // Basic project info
            $table->string('title', 255);
            $table->string('slug', 255)->nullable()->unique();
            $table->string('category', 120)->nullable()->index();
            $table->longText('description')->nullable();

            // Financials
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('currency', 10)->default('INR');

            // Chapter
            $table->unsignedBigInteger('chapter_id')->nullable()->index();

            // Single date field (replacing start/end date)
            $table->date('date')->nullable();

            // Documents
            $table->json('documents')->nullable();
            $table->json('report_files')->nullable();

            // Meta
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('member_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_csrs');
    }
};
