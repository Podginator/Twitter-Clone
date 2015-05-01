<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Model\Posts;
use Auth, View, Response, Input;

class PostsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function homepage()
	{
		$posts = Auth::user() ? Posts::getAllHome(Auth::user()) : Posts::all();
		return View::make("posts.index");
	}

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

	public function store()
	{
		//First we need to check if the user is logged in, if so, he can post.
		$success =  Response::json(array('success' => true));
		$fail =  Response::json(array('success' => false));
		if(Auth::user())
		{
			$newPost = Posts::create(array(
						"text"=>Input::get('text'),
						"userId"=>Auth::user()->id,
						"imgId"=>null,
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

		echo print_r($post);
		//For later:: Auth::user()->admin
		if(Auth::user()->id == $post->userId)
		{
			
			Posts::destroy($id);	
			return Response::json(array('success'=>true));
		}
		
		return Response::json(array('success'=>false));
	}	
}
