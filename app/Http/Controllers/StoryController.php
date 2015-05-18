<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Model\Posts;
use App\Model\Story;
use App\Model\StoryPost;
use App\Http\Requests\PostRequest;
use App\Http\Requests\StoryAddRequest;
use Auth, View, Response, Input;

class StoryController extends Controller {


	//This is our VIEW commands.
	public function ViewStory(Story $story)
	{
		$storyPosts = Posts::getPostsFromStory($story->id);
		$data['story'] = $story;
		$data['posts'] = $storyPosts;
		return View::make('story.viewstory')->with($data);
	}

	public function EditStory(Story $story)
	{
		$storyPosts = Posts::getPostsFromStory($story->id);
		$data['story'] = $story;
		$data['posts'] = $storyPosts;
		return View::make('story.createstory')->with($data);
	}

	/**
	 * Display a listing of the resource.
	 * GET request
	 * @return Response
	 */
	 //These are our API commands.
	public function index()
	{
		if(Auth::user())
		{
			return Response::json(Story::getAllUserStories(Auth::user()));
		}
		return Response::json(Story::all());
	}

	public function store(StoryAddRequest $req)
	{
		//To Do : Validation
		$newPost = Story::create(array(
					"name"=>Input::get('title'),
					"userId" => Auth::user()->id
				));

		//here we check if the newpost entered the db, if it did then the newPost will have an id, otherwise it will not.
		return $newPost->id ? Response::json(array("success"=>true, "id" => $newPost->id)) : "Fail";
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
	
	public function GetStoryPosts($id)
	{
		return Response::json(Posts::getPostsFromStory($id));
	}
	
	public function edit($id)
	{
		$story = Story::where('id','=' ,$id)->first();
		$story->description = Input::get('description');
		$story->save();
		$posts = Input::get('posts');

		if($posts)
		{
			foreach($posts as $value)
			{
				StoryPost::create(array('storyid' => $id, 'postid' => $value));
			}
		}
		
		
	}
}
