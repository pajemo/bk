<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixPasswordColumnOnUsersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the legacy PasswordHash column if it exists
            if (Schema::hasColumn('users', 'PasswordHash')) {
                $table->dropColumn('PasswordHash');
            }

            // Ensure Laravel-standard 'password' column exists
            if (!Schema::hasColumn('users', 'password')) {
                $table->string('password')->after('email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Recreate the PasswordHash column if needed
            if (!Schema::hasColumn('users', 'PasswordHash')) {
                $table->string('PasswordHash')->nullable();
            }

            // Optional: Drop the standard password column
            if (Schema::hasColumn('users', 'password')) {
                $table->dropColumn('password');
            }
        });
    }
}
