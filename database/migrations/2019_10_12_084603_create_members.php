<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 50);
            $table->string('first_name');
            $table->string('insertion')->nullable();
            $table->string('last_name');
            $table->boolean('account')->default(0);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->date('birthday')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('enabled')->default(1);
            $table->string('locale')->default(config('app.locale'));
            $table->text('address_line_1');
            $table->text('address_line_2')->nullable();
            $table->string('zipcode', 30);
            $table->string('state')->nullable();
            $table->string('city');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['email', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
