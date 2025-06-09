<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('FirstName', 100)->nullable()->after('id');
            $table->string('Surname', 100)->nullable()->after('FirstName');
            $table->date('DateOfBirth')->nullable()->after('Surname');
            $table->text('Address')->nullable()->after('DateOfBirth');
            $table->string('PhoneNumber', 20)->nullable()->after('Address');
            $table->string('IDType', 50)->nullable()->after('PhoneNumber');
            $table->string('IDNumber', 100)->nullable()->after('IDType');
            $table->string('IDUpload', 255)->nullable()->after('IDNumber');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'FirstName',
                'Surname',
                'DateOfBirth',
                'Address',
                'PhoneNumber',
                'IDType',
                'IDNumber',
                'IDUpload',
            ]);
        });
    }
}
