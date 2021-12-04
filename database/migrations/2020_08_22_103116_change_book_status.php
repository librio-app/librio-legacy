<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeBookStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::table('book_barcodes', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('book_barcodes', function (Blueprint $table) {
            $table->enum('status', ['new', 'in_repair', 'lost', 'taken_in', 'lended', 'available'])->default('new');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::table('book_barcodes', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('book_barcodes', function (Blueprint $table) {
            $table->enum('status', ['new', 'in_repair', 'available'])->default('available');
        });
    }
}
