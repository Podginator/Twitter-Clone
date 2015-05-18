<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Story extends Model {

	protected $fillable = ['name', 'description'];
	protected $table = "story";

	public function posts()
	{
		return $this->hasMany('App\Model\StoryPost', 'postid');
	}
	
	public static function getAllUserStories(User $user)
	{
		//Get homepage stories. 
		//This is similar to how it's done for posts.'
		//This will get all of the users stoires and all 
		//of the events they're following.
		$followingEv = $user->getFollowingEvents();
		$following = $user->getFollowing();

	
		$stories = Stories::join('users', function($join){
				$join->on('users.id', '=', 'story.userId');
			})
			->leftJoin('storypost', function($join){
				$join->on('storypost.storyid', '=', 'story.id');
			})
			->where('story.userId', $user->id)
			->orWhere(function($query) use ($followingEv, $following){
				foreach($followingEv as $follow)
				{
					$query->orWhere('name', 'RLIKE', '(#'.$follow.')[[:>:]]');

				}
				foreach($following as $follow)
				{
					$query->orWhere('story.userId', '=', $follow);
				}
			})
			->orderBy('story.created_at', 'desc')
			->select( array('posts.*',
						'users.username',
						DB::raw('CASE WHEN story.userId = '.$user->id.' THEN 1 ELSE 0 END AS editable'),
						DB::raw('')));
			
		return $stories->get();
	}
	
}
