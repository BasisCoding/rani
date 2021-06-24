<?php namespace Ams\Asset\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('ams_asset_histories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('item_id');
            $table->integer('employee_id')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('room_id')->nullable();
            $table->string('layout_x')->nullable();
            $table->string('layout_y')->nullable();
            $table->string('code');
            $table->date('acquisitioned_at')->nullable();
            $table->date('guaranteed_at')->nullable();
            $table->string('parameter', 32);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ams_asset_histories');
    }
}
