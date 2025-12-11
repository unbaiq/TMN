<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cluster_meeting_participants', function (Blueprint $table) {
            $table->id();

            // create columns (unsignedBigInteger matches $table->id())
            $table->unsignedBigInteger('cluster_meeting_id');
            $table->unsignedBigInteger('member_id');

            $table->enum('attendance', ['pending','accepted','rejected','present','absent'])->default('pending');
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['cluster_meeting_id','member_id'], 'cluster_member_unique');
        });

        // add FKs only if referenced tables exist
        if (Schema::hasTable('cluster_meetings')) {
            Schema::table('cluster_meeting_participants', function (Blueprint $table) {
                $table->foreign('cluster_meeting_id')->references('id')->on('cluster_meetings')->onDelete('cascade');
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('cluster_meeting_participants', function (Blueprint $table) {
                $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade');
            });
        } elseif (Schema::hasTable('members')) {
            Schema::table('cluster_meeting_participants', function (Blueprint $table) {
                $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('cluster_meeting_participants')) {
            Schema::table('cluster_meeting_participants', function (Blueprint $table) {
                try { $table->dropForeign(['cluster_meeting_id']); } catch (\Exception $e) {}
                try { $table->dropForeign(['member_id']); } catch (\Exception $e) {}
            });
            Schema::dropIfExists('cluster_meeting_participants');
        }
    }
};
