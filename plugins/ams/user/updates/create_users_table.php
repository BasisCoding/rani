<?php namespace Ams\User\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('ams_user_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('plain');
            $table->string('password');
            $table->integer('is_admin')->nullable()->default(0);
            $table->timestamps();
            $table->string('parameter', 32);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ams_user_users');
    }
}
