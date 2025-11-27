<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->id();

            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->nullOnDelete();
            $table->foreignId('member_id')->nullable()->constrained('users')->nullOnDelete()->comment('Recipient');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('awarded_on')->nullable();
            $table->string('award_file')->nullable(); // certificate / media file
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('awards');
    }
};
