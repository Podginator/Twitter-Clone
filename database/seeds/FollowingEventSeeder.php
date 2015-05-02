<?php 
	
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\FollowingEvent;

class FollowingEventSeeder extends Seeder {

	public function run()
	{
	    DB::table('FollowingEvent')->delete();
    
        FollowingEvent::create(array(
            'userid' => 1,
            'hashtag' => "TestHash",
        ));
		
		FollowingEvent::create(array(
            'userid' => 1,
            'hashtag' => "TextHas",
        ));
        
        FollowingEvent::create(array(
            'userid' => 2,
            'hashtag' => "Need",
        ));
        
        FollowingEvent::create(array(
            'userid' => 2,
            'hashtag' => "Nepal",
        ));
	}
}