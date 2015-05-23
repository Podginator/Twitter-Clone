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

	public function CreateStory()
	{
		$title= isset($_GET["title"]) ? $_GET["title"] : "";
		return View::make('story.createstory')->with('title', $title);
	}
	
	/**
	 * Display a listing of the resource.
	 * GET request
	 * @return Response
	 */
	 //These are our API commands. Restful and CRUD
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
		$newPost = Story::create(array(
					"name"=>Input::get('title'),
					"userId" => Auth::user()->id,
					"description" => Input::get('description'),
					"hashtag" => Input::get("hashtag")
				));
		$id = $newPost->id;
		
		$posts = Input::get('posts');
		if($posts)
		{
			foreach($posts as $value)
			{
				StoryPost::create(array('storyid' => $id, 'postid' => $value));
			}
		}
		//here we check if the newpost entered the db, if it did then the newPost will have an id, otherwise it will not.
		return $newPost->id ? Response::json(array("success"=>true, "id" => $newPost->id)) : Response::json(array("fail"=>true, "id" => $newPost->id));
	}

	/**
	 * Store a newly created resource in storage.
	 * DELETE request.
	 * @return Response
	 */
	public function destroy($id)
	{
		$story = Story::where('id', $id)->first();

		//For later:: Auth::user()->admin
		if(Auth::user()->id == $story->userId)
		{
			Story::destroy($id);	
			return Response::json(array('success'=>true));
		}
		
		return Response::json(array('success'=>false));
	}
	
	public function GetStoryPosts($id)
	{
		return Response::json(Posts::getPostsFromStory($id));
	}
}
