<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookSeriesNr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->unsignedInteger('series_id')->nullable();
            $table->foreign('series_id')->references('id')->on('series');
        });

        Schema::table('books', function (Blueprint $table) {
            $table->string('series_nr')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::table('books', function ($table) {
            $table->dropColumn('series_nr');
        });

        Schema::dropIfExists('series');
    }
}
