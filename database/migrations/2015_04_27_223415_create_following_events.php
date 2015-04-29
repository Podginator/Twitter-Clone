<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowingEvents extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('followingevent', function($table)
	    {
	        $table->increments('id');
			$table->integer('userid')->unsigned();
	        $table->string('hashtag');
	    });
	    
	    Schema::table('followingevent', function($table)
	    {
	        $table->foreign('userid')->references('id')->on('users');
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
