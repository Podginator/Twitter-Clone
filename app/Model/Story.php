<?php namespace App\Model;

use App\Model\TimeModel;
use DB, Auth;

class Story extends TimeModel {

	protected $fillable = ['name', 'description', "userId", "hashtag"];
	protected $table = "story";

	//Relationships.
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
					$query->orWhere('story.hashtag', '=',$follow);
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
		//--------------- Dette har jeg addet-----------------//
		public static function getUserStories(User $user)
	{				
			$stories = Story::join('users', function($join){
				$join->on('users.id', '=', 'story.userId');
			})
			->where('story.userId', $user->id)
			
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
	// -----------------------------------------------------------//
		//To do
		//User Stories.
		//Tagged Stories.
	
	public static function getTagged($id)
	{
		$stories = Story::join('users', function($join){
				$join->on('users.id', '=', 'story.userId');
			})
			->where('hashtag', '=', $id)
			->leftJoin('storypost', function($join){
				$join->on('storypost.storyid', '=', 'story.id');
			})
			->groupBy('story.id')
			->orderBy('story.created_at', 'desc')
			->select( array('story.*',
						'users.username',
						DB::raw('CASE WHEN story.userId = '.Auth::user()->id.' THEN 1 ELSE 0 END AS editable'),
						DB::raw('count(storypost.id) as PostAmount')
						)
					)
			->get();
			
		return $stories;
	}
	
}
