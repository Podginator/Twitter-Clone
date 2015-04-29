<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('following', function($table)
	    {
	        $table->increments('id');
	        $table->integer('userid')->unsigned();
	        $table->integer('followingid')->unsigned();
	    });
	    
	    Schema::table('following', function($table)
	    {
	        $table->foreign('userId')->references('id')->on('users');
	        $table->foreign('followingid')->references('id')->on('users');
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('following');
	}

}
