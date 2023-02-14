<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->text('full_name');
            $table->string('name');
            $table->string('version')->default(2);
            $table->integer('system')->nullable();
            $table->integer('number')->nullable();
            $table->char('key')->nullable();
            $table->integer('_lft')->unsigned()->default(0);
            $table->integer('_rgt')->unsigned()->default(0);
            $table->integer('creator_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
