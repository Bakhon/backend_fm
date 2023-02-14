<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReportsFamilyMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_families', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('report_id')->unsigned();
            $table->string('name');
            $table->string('version');
            $table->uuid('guid')->unique();
            $table->integer('family_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('report_id')->references('id')->on('reports');
            $table->foreign('family_id')->references('id')->on('cases');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_families');
    }
}
