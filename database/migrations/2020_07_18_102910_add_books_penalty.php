<?php

use Illuminate\Database\Migrations\Migration;

class AddBooksPenalty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::table('member_books', function($table) {
            $table->double('penalty')->default(0);
            $table->double('costs')->default(0);
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
            $table->dropColumn('penalty');
            $table->dropColumn('costs');
        });
    }
}
