<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // remove from books
        Schema::table('member_books', function($table) {
            $table->dropColumn('cost');
            $table->dropColumn('penalty');
        });

        // create new table for invoices
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id');
            $table->string('invoice_nr');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id');
            $table->string('description');
            $table->enum('type', ['subscription', 'penalty', 'other']);
            $table->double('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::table('member_books', function($table) {
            $table->double('cost')->default(0);
            $table->double('penalty')->default(0);
        });

        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoice_items');
    }
}
