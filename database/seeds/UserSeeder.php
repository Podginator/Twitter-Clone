<?php 

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\User;

class UserSeeder extends Seeder {

	public function run()
	{
	    DB::table('users')->delete();
    
        User::create(array(
            'email' => 'Test@gmail.com',
            'username' => 'TestAcct',
			'password' =>  Hash::make('test'),
        ));
		
		User::create(array(
            'email' => 'Test1@gmail.com',
            'username' => 'Test2',
			'password' =>  Hash::make('test'),
        ));
	}
}