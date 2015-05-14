<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('username')->unique();
			$table->string('password', 60);
			$table->string('biography', 255);
			$table->integer('profileId')->unsigned()->nullable();
			$table->rememberToken();
			$table->timestamps();
		});
		
		Schema::table('users', function(Blueprint $table)
	    {
	        $table->foreign('profileId')->references('id')->on('images');
	    });
		
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
