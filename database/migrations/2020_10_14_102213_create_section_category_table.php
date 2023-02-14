<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_category', function (Blueprint $table) {
            $table->id();
            $table->integer('section_id')->unsigned();
            $table->foreign('section_id','fk_section_id')->references('id')->on('sections');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id','fk_category_id')->references('id')->on('categories');
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
        Schema::dropIfExists('section_category');
    }
}
