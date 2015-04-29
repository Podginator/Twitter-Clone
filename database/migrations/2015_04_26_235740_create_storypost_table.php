<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorypostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('storypost', function($table)
	    {
	        $table->increments('id');
			$table->integer('storyid')->unsigned();
	        $table->integer('postid')->unsigned();
	    });
	    
	    Schema::table('storypost', function($table)
	    {
	        $table->foreign('storyid')->references('id')->on('story');
	        $table->foreign('postid')->references('id')->on('posts');
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop("storypost");
	}

}
