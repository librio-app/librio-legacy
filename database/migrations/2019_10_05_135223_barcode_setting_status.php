<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class BarcodeSettingStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::table('book_barcodes', function (Blueprint $table) {
            $table->enum('status', ['new', 'in_repair', 'available'])->default('available');
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
    }
}
