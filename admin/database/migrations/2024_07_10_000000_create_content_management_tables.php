<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentManagementTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Table for managing frontend content (e.g., pages, posts)
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('body')->nullable();
            $table->string('type')->default('page'); // page, post, etc.
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });

        // Table for managing uploaded files metadata
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('filepath');
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->timestamps();

            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
        Schema::dropIfExists('files');
    }
}
