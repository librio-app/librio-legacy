<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateThemes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('active');
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('theme_book', function (Blueprint $table) {
            $table->increments('theme_book_id');
            $table->unsignedInteger('theme_id');
            $table->unsignedInteger('book_id');
        });

        Schema::table('theme_book', function (Blueprint $table) {
            $table->foreign('theme_id')->references('id')->on('themes');
            $table->foreign('book_id')->references('id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('themes');
        Schema::dropIfExists('theme_book');
    }
}
