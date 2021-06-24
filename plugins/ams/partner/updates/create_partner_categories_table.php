<?php namespace Ams\Partner\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePartnerCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('ams_partner_partner_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('partner_id');
            $table->integer('category_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ams_partner_partner_categories');
    }
}
