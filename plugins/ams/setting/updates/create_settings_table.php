<?php namespace Ams\Setting\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('ams_setting_settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('value');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ams_setting_settings');
    }
}
