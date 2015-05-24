<?php 

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Story;
	
class StorySeeder extends Seeder {

	public function run()
	{
	    DB::table('story')->delete();
    
        Story::create(array(
            'name' => 'Nepal story',
            'hashtag' => 'nepal',
			'description' =>  'Hanging out in Nepal',
			'userId' => 2,
        ));
	}
}