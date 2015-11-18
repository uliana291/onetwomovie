<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('title');
            $table->integer('duration');
            $table->string('original_title');
            $table->integer('production_year');
            $table->integer('rating');
            $table->string('age_restriction');
            $table->text('poster');
            $table->text('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('movies');
    }
}
