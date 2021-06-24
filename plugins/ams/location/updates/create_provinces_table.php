<?php namespace Ams\Location\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProvincesTable extends Migration
{
    public function up()
    {
        Schema::create('ams_location_provinces', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('id');
            $table->string('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ams_location_provinces');
    }
}
