<?php

use Illuminate\Database\Migrations\Migration;

class RefactorBarcodeDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        $prefix = \DB::getTablePrefix();
        $table = $prefix . 'book_barcodes';

        \DB::statement("ALTER TABLE {$table} MODIFY COLUMN status ENUM('new', 'in_repair', 'lost', 'taken_in', 'lended', 'available', 'in_reservation', 'deleted') DEFAULT 'new'");
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        $prefix = \DB::getTablePrefix();
        $table = $prefix . 'book_barcodes';

        \DB::statement("ALTER TABLE {$table} MODIFY COLUMN status ENUM('new', 'in_repair', 'lost', 'taken_in', 'lended', 'available', 'in_reservation') DEFAULT 'new'");
    }
}
