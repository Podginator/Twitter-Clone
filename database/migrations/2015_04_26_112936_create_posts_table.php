<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('text');
			$table->integer('userId')->unsigned();
			$table->integer('imgId')->unsigned()->nullable();
			$table->timestamps();

		});

		Schema::table('posts', function(Blueprint $table)
	    {
	        $table->foreign('userId')->references('id')->on('users');
	        $table->foreign('imgId')->references('id')->on('images');
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
