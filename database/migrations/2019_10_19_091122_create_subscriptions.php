<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('book_limit'); // zero is unlimited
            $table->integer('book_lending_days'); // zero is unlimited
            $table->enum('currency', ['EUR', 'USD']);
            $table->double('subscription_price'); // zero is free
            $table->boolean('penalty')->default(1);
            $table->double('penalty_price')->nullable(); // per day
            $table->enum('payment_period', ['per-book-daily', 'weekly', 'monthly', 'yearly']);
            $table->boolean('enabled')->default(1);
            $table->dateTime('expire_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
