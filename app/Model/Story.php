<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Story extends Model {

	protected $fillable = ['name', 'description', "userId", "hashtag"];
	protected $table = "story";

	public function posts()
	{
		return $this->hasMany('App\Model\StoryPost', 'postid');
	}
	
	public function users()
	{
		return $this->belongsTo('App\Model\User', 'userId');
	}
	
	public static function getAllUserStories(User $user)
	{
		$followingEv = $user->getFollowingEvents();
		$following = $user->getFollowing();


		$stories = Story::join('users', function($join){
				$join->on('users.id', '=', 'story.userId');
			})
			->where('story.userId', $user->id)
			->orWhere(function($query) use ($followingEv, $following){
				foreach($followingEv as $follow)
				{
					$query->orWhere('story.name', 'RLIKE', '('.$follow.')[[:>:]]');
				}
				foreach($following as $follow)
				{
					$query->orWhere('story.userId', '=', $follow);
				}
			})
			->leftJoin('storypost', function($join){
				$join->on('storypost.storyid', '=', 'story.id');
			})
			->groupBy('story.id')
			->orderBy('story.created_at', 'desc')
			->select( array('story.*',
						'users.username',
						DB::raw('CASE WHEN story.userId = '.$user->id.' THEN 1 ELSE 0 END AS editable'),
						DB::raw('count(storypost.id) as PostAmount')
						)
					)
			->get();
		
		
		
		return $stories;
	}
	
}
