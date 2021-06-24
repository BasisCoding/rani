<?php namespace Ams\Asset\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('ams_asset_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('parent_id')->nullable()->default(NULL);
            $table->string('name')->nullable();
            $table->string('slug');
            $table->string('code')->nullable();
            $table->timestamps();
            $table->integer('is_other')->nullable()->default(0);
            $table->string('parameter', 32);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ams_asset_categories');
    }
}
