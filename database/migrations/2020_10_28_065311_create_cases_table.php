<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id', 'fk_case_category_id')->references('id')->on('categories');
            $table->integer('compositions_id')->nullable();
            $table->string('name');
            $table->uuid('guid')->unique();
            $table->integer('creator_id')->unsigned();
            $table->integer('edition')->nullable();
            $table->smallInteger('version')->nullable();
            $table->char('key')->nullable();
            $table->integer('status')->nullable();
            $table->timestamp('restricted_at')->nullable();
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
        Schema::dropIfExists('cases');
    }
}
