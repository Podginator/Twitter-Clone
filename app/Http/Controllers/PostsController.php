<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Model\Posts;
use Auth;
use View;
use Response;
class PostsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function homepage()
	{
		$posts = Auth::user() ? Posts::getAllHome(Auth::user()) : Posts::all();
		return View::make("home.testposts")->with('posts', $posts);
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

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * PUT request.
	 * @return Response
	 */
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

		//For later:: Auth::user()->admin
		if(Auth::user() == $post->user)
		{
			Posts::destroy($id);	
			return Response::json(array('success'=>true));
		}
		
		return Response::json(array('success'=>false));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	

}
