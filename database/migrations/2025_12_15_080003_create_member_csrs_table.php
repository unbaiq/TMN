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

            // 🔗 Relations
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('chapter_id')->nullable()->constrained('chapters')->onDelete('set null');
            $table->foreignId('event_id')->nullable()->constrained('events')->onDelete('set null');

            // 🧾 CSR Core Details
            $table->string('csr_title'); // “Tree Plantation Drive”, “Blood Donation Camp”
            $table->text('csr_description')->nullable();
            $table->enum('csr_type', [
                'donation',
                'charity',
                'volunteering',
                'education',
                'environment',
                'health',
                'community_support',
                'women_empowerment',
                'animal_welfare',
                'disaster_relief',
                'other'
            ])->default('other');

            // 💰 CSR Impact Data
            $table->decimal('amount_spent', 15, 2)->nullable(); // e.g. 25000
            $table->integer('volunteer_hours')->nullable(); // e.g. 5
            $table->string('beneficiary_name')->nullable();
            $table->integer('beneficiaries_count')->nullable();

            // 📅 Timing & Venue
            $table->date('csr_date')->nullable();
            $table->string('location')->nullable();

            // 📎 Proof / Attachments
            $table->string('proof_document')->nullable(); // file: image/pdf
            $table->string('proof_photo')->nullable(); // optional extra image

            // ✅ Status & Review
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();

            // 🧠 Audit Trail
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_csrs');
    }
};
