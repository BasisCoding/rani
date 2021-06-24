<?php namespace Ams\Employee\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateUnitsTable extends Migration
{
    public function up()
    {
        Schema::create('ams_employee_units', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('team_id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->string('parameter', 32);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ams_employee_units');
    }
}
