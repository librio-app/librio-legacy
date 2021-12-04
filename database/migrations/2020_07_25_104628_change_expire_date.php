<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeExpireDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('expire_date');
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->enum('expire_date', ['1-week', '1-month', '3-months', 'half-year', 'year', '2-years', 'ongoing'])->default('year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn('expire_date');
        });

        Schema::table('member_books', function($table) {
            $table->dateTime('expire_date')->nullable();
        });
    }
}
