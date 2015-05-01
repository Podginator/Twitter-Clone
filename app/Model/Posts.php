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
					$query->orWhere('text', 'LIKE', '%'.'#'.$follow.'%');
				};
			})
			->join('users', function($join){
				$join->on('users.id', '=', 'posts.userId');
			})
			->groupBy('posts.id')
			->orderBy('posts.created_at', 'desc')
			->select(array(
					'posts.*',
					'users.username',
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

}
