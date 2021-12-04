<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddMemberSubscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('member_subscription', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('member_id');
            $table->unsignedInteger('subscription_id');
            $table->dateTime('expire_date')->nullable();
            $table->timestamps();
        });

        Schema::table('member_subscription', function (Blueprint $table) {
            $table->foreign('member_id')->references('id')->on('members');
            $table->foreign('subscription_id')->references('id')->on('subscriptions');
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
