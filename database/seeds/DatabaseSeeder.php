<?php 

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

    public function run()
    {
        $this->call('UserSeeder');
        $this->call('PostSeeder');
        $this->call('FollowingEventSeeder');

        $this->command->info('User table seeded!');
    }

}