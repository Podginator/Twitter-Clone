<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('story', function($table)
	    {
	        $table->increments('id');
			$table->string('name');
			$table->string('description');
	        $table->integer('userId')->unsigned();
			$table->timestamps();

		});

		Schema::table('story', function(Blueprint $table)
	    {
	        $table->foreign('userId')->references('id')->on('users');
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('story');
	}

}
