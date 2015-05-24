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
	}
}