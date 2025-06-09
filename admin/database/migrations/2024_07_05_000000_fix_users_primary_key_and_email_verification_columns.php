<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixUsersPrimaryKeyAndEmailVerificationColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Rename UserID to id in users table if column exists
        if (Schema::hasColumn('users', 'UserID')) {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('UserID', 'id');
            });
        }

        // Add email_verified_at column if not exists
        if (!Schema::hasColumn('users', 'email_verified_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('email_verified_at')->nullable()->after('PasswordHash');
            });
        }

        // Remove IsEmailVerified column if exists
        if (Schema::hasColumn('users', 'IsEmailVerified')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('IsEmailVerified');
            });
        }

        // Safely drop and rename UserID to user_id and re-add FK
        foreach (['emailverifications', 'logincodes', 'accounts'] as $tableName) {
            if (Schema::hasColumn($tableName, 'UserID')) {
                // Check if foreign key exists before dropping
                $foreignKeyName = $tableName . '_userid_foreign';
                $foreignKeyExists = DB::selectOne("
                    SELECT CONSTRAINT_NAME
                    FROM information_schema.TABLE_CONSTRAINTS
                    WHERE CONSTRAINT_TYPE = 'FOREIGN KEY'
                    AND TABLE_SCHEMA = DATABASE()
                    AND TABLE_NAME = ?
                    AND CONSTRAINT_NAME = ?
                ", [$tableName, $foreignKeyName]);

                Schema::table($tableName, function (Blueprint $table) use ($tableName, $foreignKeyExists, $foreignKeyName) {
                    if ($foreignKeyExists) {
                        $table->dropForeign($foreignKeyName);
                    }

                    // Rename column
                    $table->renameColumn('UserID', 'user_id');

                    // Recreate foreign key
                    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                });
            }
        }
    }

    private function getOldColumnName($table)
    {
        return 'UserID';
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert users table
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('id', 'UserID');
            $table->dropColumn('email_verified_at');
            $table->boolean('IsEmailVerified')->default(false)->after('PasswordHash');
        });

        foreach (['emailverifications', 'logincodes', 'accounts'] as $tableName) {
            if (Schema::hasColumn($tableName, 'user_id')) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    try {
                        $table->dropForeign(['user_id']);
                    } catch (\Throwable $e) {
                        // FK might not exist
                    }

                    $table->renameColumn('user_id', 'UserID');

                    $table->foreign('UserID')->references('UserID')->on('users')->onDelete('cascade');
                });
            }
        }
    }
}
