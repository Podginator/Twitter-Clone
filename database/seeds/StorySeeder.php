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
        Story::create(array(
        	'name' => 'Test story',
        	'hashtag' => 'test',
        	'description' => 'testing story',
        	'userId' => 1,
        ));
        Story::create(array(
        	'name' => 'test story 2',
        	'hashtag' => 'test',
        	'description' => 'test story 2',
        	'userId' => 2,
        ));
	}
}