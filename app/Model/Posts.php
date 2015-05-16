<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB, Auth;
class Posts extends Model {

	protected $fillable = ['userId', 'text', 'imgId'];
	protected $table = "posts";
	public static $rules = [
		//setup rules here
	];
	
	public static function DefaultQuery()
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
	
	public static function GetSelect()
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
	
	public function users()
	{
		$this->belongsTo('App\Model\User', 'userId');
	}
	
	//Override of All.
	public static function all($columns = array('*'))
	{
		return self::DefaultQuery()
			->select(array(
					'posts.*',
					'users.username',
					'files.url'
					))
			->get();
	}
	
	
	public static function getAllHome(User $user)
	{
		//Get homepage posts. 
		//This will get all of the users posts and all 
		//of the events they're following.
		$followingEv = $user->getFollowingEvents();
		$following = $user->getFollowing();
		$posts = self::DefaultQuery() 
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
			
			
		return $posts->select(self::GetSelect())->get();
	}
	
	public static function getUserPosts($user)
	{	
			$posts = self::DefaultQuery() 
				->where('users.username', $user);
				
					
			return $posts->select(self::GetSelect())->get();
	}
	
	public static function getPost($id)
	{
		// Get this posts from a user (id):
		/*  return Post::where('id', $id)
			->from('posts')
			->select('id')
			->get(); */
		return DB::raw('SELECT * FROM posts WHERE id = $id');
		
	}
	
	public static function GetTagged($id)
	{
		$posts = self::DefaultQuery() 
			->where('text', 'RLIKE', '(#'.$id.')[[:>:]]');
			
		return $posts->select(self::GetSelect())->get();
	}

}
