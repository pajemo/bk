<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('AccountID');
            $table->unsignedBigInteger('user_id');
            $table->decimal('Balance', 18, 2)->default(0);
            $table->string('AccountNumber')->nullable();
            $table->string('BankName', 100)->nullable();
            $table->string('AccountName', 255)->nullable();
            $table->string('RoutingNumber', 50)->nullable();
            $table->string('SwiftBIC', 50)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
