<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class Posts extends Model {

	protected $fillable = ['userId', 'text', 'imgId'];
	protected $table = "posts";

	public static $rules = [
		//setup rules here
	];

	public function users()
	{
		$this->belongsTo('App\Model\User', 'userId');
	}
	
	//Override of All.
	public static function all($columns = array('*'))
	{
		return Posts::join('users', function($join){
				$join->on('users.id', '=', 'posts.userId');
			})
			->leftJoin('images', function($join){
				$join->on('images.id', '=', 'posts.imgId');
			})
			->groupBy('posts.id')
			->orderBy('posts.created_at', 'desc')
			->select(array(
					'posts.*',
					'users.username',
					'images.url'
					))
			->get();
	}
	
	
	public static function getAllHome(User $user)
	{
		//Get homepage posts. 
		//This will get all of the users posts and all 
		//of the events they're following.
		$followingEv = $user->getFollowingEvents();
		return Posts::where('userId', $user->id)
			->orWhere(function($query) use ($followingEv){
				foreach($followingEv as $follow)
				{
					$query->orWhere('text', 'RLIKE', '(#'.$follow.')[[:>:]]');

				};
			})
			->join('users', function($join){
				$join->on('users.id', '=', 'posts.userId');
			})
			->leftJoin('images', function($join){
				$join->on('images.id', '=', 'posts.imgId');
			})
			->groupBy('posts.id')
			->orderBy('posts.created_at', 'desc')
			->select(array(
					'posts.*',
					'users.username',
					'images.url',
					DB::raw('CASE WHEN '.$user->id.' = posts.userId THEN 1 ELSE 0 END AS editable'),
					))
			->get();
	}

	public static function getUserPosts(User $user)
	{
		//Just get all posts from a user
		return Post::where('userId', $user->id)
			->join('users', function($join){
				$join->on('users.id', '=', 'posts.userId');
			})
			->groupBy('posts.id')
			->orderBy('posts.created_at', 'desc')
			->select(array(
					'posts.*',
					'users.username',
					))
			->get();
	}
	
	public static function getUserPost()
	{
		echo "clicked on get user post!";
		
	}
	
	public static function GetTagged($id)
	{
		return Posts::where('text', 'RLIKE', '(#'.$id.')[[:>:]]')
			->join('users', function($join){
				$join->on('users.id', '=', 'posts.userId');
			})
			->leftJoin('images', function($join){
				$join->on('images.id', '=', 'posts.imgId');
			})
			->groupBy('posts.id')
			->orderBy('posts.created_at', 'desc')
			->select(array(
					'posts.*',
					'users.username',
					'images.url'
					))
			->get();
	}

}
