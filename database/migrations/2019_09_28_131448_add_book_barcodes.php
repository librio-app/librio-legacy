<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddBookBarcodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('book_barcodes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('book_id');
            $table->string('barcode');
            $table->boolean('enabled')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['barcode', 'deleted_at']);
        });

        Schema::table('book_barcodes', function (Blueprint $table) {
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
        Schema::dropIfExists('book_barcodes');
    }
}
