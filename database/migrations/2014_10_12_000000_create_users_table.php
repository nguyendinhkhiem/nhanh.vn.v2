<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 40);
            $table->string('phone_number', 20);
            $table->string('username', 100)->nullable();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('password', 100);
            $table->dateTime('last_login');
            $table->boolean('email_verified')->default(0);
            $table->string('account_type')->default('normal')->comment('normal, facebook, google, ...');
            $table->string('social_id');
            $table->string('avatar')->nullable();
            $table->integer('status');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
