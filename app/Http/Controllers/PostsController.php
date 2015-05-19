<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Model\Posts;
use App\Http\Requests\PostRequest;
use Auth, View, Response, Input;

class PostsController extends Controller {


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
	
	public function GetTag($id)
	{
		return Response::json(Posts::GetTagged($id));
	}
	
	public function GetUserPosts($user)
	{
		return Response::json(Posts::getUserPosts($user));
	}
	
	
	public function ViewPost($id) 						// Get Specific Post:
	{
		$jsonData = Response::json(Posts::getPost($id)); 	// Get this post data from json.
		$jsonData = substr($jsonData, 123); 				// Remove header data. 
																// (!) Change this to regex, seriously..
		
		$data = json_decode( $jsonData, true );				// Decode json data to assoc array.
		$data = $data[0];									// Remove outer array.		
		print_r($data['text']);	
		
		return View::make('posts.thisPost')->with($data);	// Return the data to the view.
	} 
}