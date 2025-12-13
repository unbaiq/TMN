<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tableName = 'member_details';

        // If the table already exists, add any missing columns safely.
        if (Schema::hasTable($tableName)) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {

                // Add user_id (unique + foreign key) if missing
                if (! Schema::hasColumn($tableName, 'user_id')) {
                    // create unsignedBigInteger first so we can add FK and unique
                    $table->unsignedBigInteger('user_id')->nullable()->after('id');
                    // Unique index
                    $table->unique('user_id', $tableName . '_user_id_unique');
                    // Add foreign key if users table exists
                    if (Schema::hasTable('users')) {
                        $table->foreign('user_id', $tableName . '_user_id_foreign')
                              ->references('id')
                              ->on('users')
                              ->cascadeOnDelete();
                    }
                }

                if (! Schema::hasColumn($tableName, 'phone')) {
                    $table->string('phone', 20)->nullable()->after('user_id');
                }

                if (! Schema::hasColumn($tableName, 'business_name')) {
                    $table->string('business_name')->nullable()->after('phone');
                }

                if (! Schema::hasColumn($tableName, 'address')) {
                    $table->text('address')->nullable()->after('business_name');
                }

                if (! Schema::hasColumn($tableName, 'city')) {
                    $table->string('city')->nullable()->after('address');
                }

                if (! Schema::hasColumn($tableName, 'pincode')) {
                    $table->string('pincode', 20)->nullable()->after('city');
                }

                if (! Schema::hasColumn($tableName, 'referral_code')) {
                    $table->string('referral_code')->nullable()->after('pincode');
                    $table->index('referral_code', $tableName . '_referral_code_index');
                }

                if (! Schema::hasColumn($tableName, 'meta')) {
                    $table->json('meta')->nullable()->after('referral_code');
                }

                // Add timestamps if missing
                if (! Schema::hasColumn($tableName, 'created_at')) {
                    $table->timestamps();
                }
            });

            return;
        }

        // If the table does not exist, create it fresh
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();

            // user relation
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();

            // profile fields
            $table->string('phone', 20)->nullable();
            $table->string('business_name')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode', 20)->nullable();
            $table->string('referral_code')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();

            // indexes
            $table->index(['city']);
            $table->index(['referral_code']);
        });
    }

    public function down(): void
    {
        $tableName = 'member_details';

        // If we created/changed columns, remove only the columns we added (safer than dropping the table).
        if (Schema::hasTable($tableName)) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                // Drop foreign key safely if exists
                if (Schema::hasColumn($tableName, 'user_id')) {
                    // Drop FK if it exists
                    $sm = Schema::getConnection()->getDoctrineSchemaManager();
                    $doctrineTable = $sm->listTableDetails($tableName);
                    if ($doctrineTable->hasForeignKey($tableName . '_user_id_foreign')) {
                        $table->dropForeign($tableName . '_user_id_foreign');
                    } elseif ($doctrineTable->hasForeignKey('user_id')) {
                        $table->dropForeign(['user_id']);
                    }

                    // Drop unique index if exists
                    $indexes = $doctrineTable->getIndexes();
                    if (array_key_exists($tableName . '_user_id_unique', $indexes)) {
                        $table->dropUnique($tableName . '_user_id_unique');
                    } else {
                        try {
                            $table->dropUnique(['user_id']);
                        } catch (\Throwable $e) {
                            // ignore
                        }
                    }

                    // finally drop column
                    try {
                        $table->dropColumn('user_id');
                    } catch (\Throwable $e) {
                        // ignore
                    }
                }

                // Drop other columns if they exist
                foreach (['phone','business_name','address','city','pincode','referral_code','meta'] as $col) {
                    if (Schema::hasColumn($tableName, $col)) {
                        try {
                            $table->dropColumn($col);
                        } catch (\Throwable $e) {
                            // ignore
                        }
                    }
                }

                // Attempt to drop referral_code index if exists
                try {
                    $table->dropIndex($tableName . '_referral_code_index');
                } catch (\Throwable $e) {
                    // ignore
                }

                // Do not drop timestamps here to avoid accidental data loss; keep them.
            });

            return;
        }

        // If table does not exist (unlikely in down), nothing to do
    }
};
