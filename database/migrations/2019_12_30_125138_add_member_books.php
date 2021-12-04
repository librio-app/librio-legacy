<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddMemberBooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('member_books', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id');
            $table->unsignedInteger('book_barcode_id');
            $table->timestamp('lend_at')->nullable();
            $table->timestamp('take_in_at')->nullable();
            $table->double('cost')->default(0);
            $table->double('penalty')->default(0);
            $table->timestamps();
        });

        Schema::table('member_books', function (Blueprint $table) {
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('book_barcode_id')->references('id')->on('book_barcodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('member_subscription');
    }
}
