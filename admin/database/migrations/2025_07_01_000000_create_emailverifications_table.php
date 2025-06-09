<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailverificationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emailverifications', function (Blueprint $table) {
            $table->bigIncrements('VerificationID');
            $table->unsignedBigInteger('user_id');
            $table->string('VerificationCode', 100);
            $table->dateTime('Expiry');
            $table->boolean('IsUsed')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emailverifications');
    }
}
