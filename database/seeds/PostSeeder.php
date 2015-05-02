<?php 

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Posts;
	
class PostSeeder extends Seeder {

	public function run()
	{
	    DB::table('posts')->delete();
    
        Posts::create(array(
            'text' => 'test post',
            'userId' => 1,
			'imgId' =>  null,
        ));
		
		Posts::create(array(
            'text' => 'test post2',
            'userId' => 1,
			'imgId' =>  null,
        ));
		Posts::create(array(
            'text' => 'test post3',
            'userId' => 2,
			'imgId' =>  null,
        ));
		Posts::create(array(
            'text' => 'test post4',
            'userId' => 2,
			'imgId' =>  null,
        ));
		
		 Posts::create(array(
            'text' => '#Nepal testing if Nepal hashtag works',
            'userId' => 2,
			'imgId' =>  null,
        ));
	}
}