<?php namespace App\Model;

use App\Model\TimeModel;
use DB, Auth;
class Posts extends TimeModel {

	protected $fillable = ['userId', 'text', 'imgId'];
	protected $table = "posts";
	
	//Define the relationships.
	public function users()
	{
		return $this->belongsTo('App\Model\User', 'userId');
	}
	
	
	//This is the Query most 
	public static function defaultQuery()
	{
		return Posts::join('users', function($join){
				$join->on('users.id', '=', 'posts.userId');
			})
			->leftJoin('files', function($join){
				$join->on('files.id', '=', 'posts.imgId');
			})
			->leftJoin('following', function($join){
				$join->on('following.followingid', '=', 'posts.userId');
			})
			->groupBy('posts.id')
			->orderBy('posts.created_at', 'desc');
	}
	
	public static function getSelect()
	{
		$arr = array('posts.*',
						'users.username',
						'files.url',
						DB::raw('CASE WHEN posts.userId = following.followingid THEN 1 ELSE 0 END AS following'));
		if(Auth::user())
		{
			array_push($arr, DB::raw('CASE WHEN '.Auth::user()->id.' = posts.userId THEN 1 ELSE 0 END AS editable'));
	
		}
		return $arr;
	}
	
	
	//Override of All, we need to ensure we get the username.
	public static function all($columns = array('*'))
	{
		return self::defaultQuery()
			->select(array(
					'posts.*',
					'users.username',
					'files.url'
					))
			->get();
	}
	
	//This is where all the home posts are gotten. 
	public static function getAllHome(User $user)
	{
		//Get homepage posts. 
		//This will get all of the users posts and all 
		//of the events they're following.
		$followingEv = $user->getFollowingEvents();
		$following = $user->getFollowing();
		$posts = self::defaultQuery() 
			->where('posts.userId', $user->id)
			->orWhere(function($query) use ($followingEv, $following){
				foreach($followingEv as $follow)
				{
					$query->orWhere('text', 'RLIKE', '(#'.$follow.')[[:>:]]');

				}
				foreach($following as $follow)
				{
					$query->orWhere('posts.userId', '=', $follow);
				}
			});
			
			
		return $posts->select(self::getSelect())->get();
	}
	
	
	public static function getUserPosts($user)
	{	
			$posts = self::defaultQuery() 
				->where('users.username', $user);
				
					
			return $posts->select(self::getSelect())->get();
	}
	
	
	public static function getPostsFromStory($id)
	{
		$posts = self::defaultQuery()
			->leftJoin('storypost', function($join){
				$join->on('storypost.postid', '=', 'posts.id');
			})
			->where('storypost.storyid', $id);
			
		return $posts->select(self::getSelect())->get();
	}
	
	public static function getPost($id)
	{

		$posts = self::defaultQuery() 
				->where('posts.id', $id);
					
		return $posts->select(self::getSelect())->get();

	} 
	
	public static function getTagged($id)
	{
		$posts = self::defaultQuery() 
			->where('text', 'RLIKE', '(#'.$id.')[[:>:]]');
			
		return $posts->select(self::getSelect())->get();
	}
	
	public function getPostTags() 				// Create link for each tag.
	{
		return preg_grep("/#(\[[\w\s]+\])|#(\w+)/", explode(' ', $this->text));
	}

}
