<?php namespace Ams\Asset\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateAssetRemindersTable extends Migration
{
    public function up()
    {
        Schema::create('ams_asset_asset_reminders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('reminder_id');
            $table->integer('asset_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ams_asset_asset_reminders');
    }
}
