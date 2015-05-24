<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Model\Posts;
use App\Http\Requests\PostRequest;
use Auth, View, Response, Input;

class PostsController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Posts Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the RESTful side of the posts.
	| 
	| 
	|
	*/
	/**
	 * Display a listing of the resource.
	 * GET request
	 * @return Response
	 */
	public function index()
	{
		if(Auth::user())
		{
			return Response::json(Posts::getAllHome(Auth::user()));
		}
		return Response::json(Posts::all());
	}

	public function store(PostRequest $req)
	{
		//First we need to check if the user is logged in, if so, he can post.
		$success =  Response::json(array('success' => true));
		$fail =  Response::json(array('success' => false));
		//We also need to check whether a user has posted less than 140 characters. 

		
		if(Auth::user() && count(Input::get('text')) <= 140 &&  preg_match('/\S*#(?:\[[^\]]+\]|\S+)/', Input::get('text')))
		{
			$newPost = Posts::create(array(
						"text"=>Input::get('text'),
						"userId"=>Auth::user()->id,
						"imgId"=>Input::get('imgID') ? Input::get('imgID') : null
					));
 
 			//here we check if the newpost entered the db, if it did then the newPost will have an id, otherwise it will not.
			return $newPost->id ? $success : $fail;
		}
		
		//Otherwise, we'll return a fail response. 
		return $fail;
	}


	/**
	 * Store a newly created resource in storage.
	 * DELETE request.
	 * @return Response
	 */
	public function destroy($id)
	{
		$post = Posts::where('id', $id)->first();

		//For later:: Auth::user()->admin
		if(Auth::user()->id == $post->userId)
		{
			
			Posts::destroy($id);	
			return Response::json(array('success'=>true));
		}
		
		return Response::json(array('success'=>false));
	}
	
	public function getTag($id)
	{
		return Response::json(Posts::GetTagged($id));
	}
	
	public function getUserPosts($user)
	{
		return Response::json(Posts::getUserPosts($user));
	}
	
	
	//Get Specific Post.
	public function viewPost(Posts $post) 					// Get Specific Post:
	{
		$data["post"] = $post;
		$data["tags"] = $post->GetPostTags();
		$data["time"] = $post->getRelativeTime();
		
		return View::make('posts.thisPost')->with($data);	// Return the data to the view.
	} 
	
	

}