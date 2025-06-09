<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('contents')) {
            Schema::create('contents', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('body')->nullable();
                $table->string('type')->default('page');
                $table->boolean('is_published')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
}
