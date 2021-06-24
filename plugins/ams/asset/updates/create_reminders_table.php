<?php namespace Ams\Asset\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateRemindersTable extends Migration
{
    public function up()
    {
        Schema::create('ams_asset_reminders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->enum('type', ['once', 'repeat'])->default('once');
            $table->date('reminded_at');
            $table->timestamps();
            $table->string('parameter', 32);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ams_asset_reminders');
    }
}
