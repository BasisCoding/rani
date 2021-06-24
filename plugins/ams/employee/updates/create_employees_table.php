<?php namespace Ams\Employee\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('ams_employee_employees', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->integer('department_id')->nullable();
            $table->integer('team_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->timestamps();
            $table->string('parameter');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ams_employee_employees');
    }
}
