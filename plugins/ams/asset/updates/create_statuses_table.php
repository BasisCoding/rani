<?php namespace Ams\Asset\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateStatusesTable extends Migration
{
    public function up()
    {
        Schema::create('ams_asset_statuses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('color');
            $table->text('description')->nullable();
            $table->integer('is_system')->nullable()->default(0);
            $table->integer('is_create')->nullable()->default(0);
            $table->timestamps();
            $table->string('slug');
            $table->string('parameter', 32);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ams_asset_statuses');
    }
}
