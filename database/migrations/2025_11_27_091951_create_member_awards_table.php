<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('member_awards', function (Blueprint $table) {
            $table->id();

            // Member who receives the award
            $table->unsignedBigInteger('member_id');

            // Award Title (e.g., "Best Leader of the Year")
            $table->string('title');

            // Award Category (e.g., Leadership, Innovation, Contribution)
            $table->string('category')->nullable();

            // Reason / description of the award
            $table->text('description')->nullable();

            // Event where the award was given (Annual Gala, Chapter Meetup)
            $table->string('award_event')->nullable();

            // Award date
            $table->date('award_date')->nullable();

            // Certificate or trophy image
            $table->string('certificate_file')->nullable();
            $table->string('trophy_image')->nullable();

            // Award given by
            $table->unsignedBigInteger('given_by')->nullable();
            $table->enum('given_by_role', ['admin', 'chapter'])->default('admin');

            // Award status
            $table->enum('status', ['active', 'archived'])->default('active');

            // Admin notes
            $table->text('admin_notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('given_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('member_awards');
    }
};
