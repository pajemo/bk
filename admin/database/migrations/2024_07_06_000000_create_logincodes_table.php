<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logincodes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('LoginCodeID'); // Primary key column
            $table->unsignedBigInteger('user_id'); // FK to users.id
            $table->string('Code', 10);
            $table->dateTime('Expiry');
            $table->boolean('IsUsed')->default(false);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logincodes');
    }
}
