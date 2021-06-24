<?php namespace Ams\User\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('ams_user_locations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('office_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ams_user_locations');
    }
}
