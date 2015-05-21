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
	
	
	//Get Specific Post.
	public function ViewPost(Posts $id) 						// Get Specific Post:
	{
		$data["post"] = $id;
		$data["tags"] = $this->splitByHashtag($id->text);
		$data["time"] = $this->getPostedTime($id->created_at);
		//$jsonData = Response::json(Posts::getPost($id)); 	// Get this post data from json.
		//$jsonData = substr($jsonData, 123); 				// Remove header data. 
																// (!) Change this to regex, seriously..
		
		//$data = json_decode( $jsonData, true );				// Decode json data to assoc array.
		//$data = $data[0];									// Remove outer array.		
		
		
		//print_r($id)
;		
		return View::make('posts.thisPost')->with($data);	// Return the data to the view.
	} 
	
	
	private function getPostedTime($created) 				// Show dynamic post time: 
	{	
		$createdDate = date_create(date('Y-m-d', 		// Create date var. from the post. 
		strtotime($created)) );
		$currentDate = date_create(date('Y-m-d'));		// Create date var. of the current date.
		
		$diff=date_diff($createdDate,$currentDate); 	// Get the time difference.

		$d = $diff->format('%a');						// Number of days.
		$m = $diff->format('%m');						// Number of months.

		if ($d <= 31) 									// Posted the past 31 days:					
		{
			switch($d)
			{
				case 0:		     			return 'Today'; 		break;
				case 1:		     			return 'Yesterday'; 	break;
				case ($d < 7):   		    return $d ." days ago"; break;
				case ($d >= 7 && $d < 14):  return '1 week ago'; 	break;
				case ($d >= 14 && $d < 21): return '2 weeks ago'; 	break;
				case ($d >= 21 && $d < 28): return '3 weeks ago'; 	break;
				case ($d >= 28):  			return '4 weeks ago'; 	break;
			}
		}
		else if( $m > 0 ) 								// Posted over a month ago:
			return "$m month(s), $d day(s) ago";
	}

	private function splitByHashtag($Alltags) 				// Create link for each tag.
	{
		$tags = explode('#', $Alltags);					// Create array element on split hashtag(#)
		return $tags;
	}
}