<?php 

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\StoryPost;
	
class StoryPostSeeder extends Seeder {

	public function run()
	{
	    DB::table('storyPost')->delete();
    
        StoryPost::create(array(
            'storyid' => 1,
            'postid' => 5,
        ));
        StoryPost::create(array(
        	'storyid' => 2,
        	'postid' =>1,
        ));
        StoryPost::create(array(
        	'storyid' => 2,
        	'postid' => 2,
        ));
        StoryPost::create(array(
        	'storyid' => 3,
        	'postid' => 3,
        ));
	}
}