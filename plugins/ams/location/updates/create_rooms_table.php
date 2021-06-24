<?php namespace Ams\Location\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateRoomsTable extends Migration
{
    public function up()
    {
        Schema::create('ams_location_rooms', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('building_id');
            $table->string('name');
            $table->timestamps();
            $table->string('slug');
            $table->string('parameter', 32);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ams_location_rooms');
    }
}
