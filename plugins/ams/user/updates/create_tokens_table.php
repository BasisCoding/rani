<?php namespace Ams\User\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTokensTable extends Migration
{
    public function up()
    {
        Schema::create('ams_user_tokens', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->text('token');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ams_user_tokens');
    }
}
