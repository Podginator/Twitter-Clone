<?php namespace App\Http\Controllers;
 
use Auth, View, Response, Input, File;
use App\Model\FollowingEvent;
use App\Model\User;
use App\Model\Images;
use App\Http\Requests\ProfileRequest;
use ValidationService;

class UserController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        //STUB
		//return view("home.home");
	}
	
	public function store()
	{
		//First we need to check if the user is logged in, if so, he can post.
		$success =  Response::json(array('success' => true));
		$fail =  Response::json(array('success' => false));
		//We also need to check whether a user has posted less than 140 characters. 
		
		if(Auth::user() && count(Input::get('text')) > 0 &&  preg_match('/^[a-zA-Z ]*$/', Input::get('text')))
		{
			$newFollowingEvent = FollowingEvent::create(array(
						"userid"=>Auth::user()->id,
						"hashtag"=>Input::get('text'),
					));
					
 
 			//here we check if the newpost entered the db, if it did then the newPost will have an id, otherwise it will not.
			return $newFollowingEvent->id ? $success : $fail;
		}
		
		//Otherwise, we'll return a fail response. 
		return $fail;
	}
	
	public function userPage(User $user)
	{
		if($user->id == null)
		{
 			return View::make("errors.user");
		}
		$data['user'] = $user;

		return View::make('users.page', $data);
	}
	
	public function profilePage()
	{
		return View::make('users.fullprofile');
	}
	
	public function GetCurrentUser()
	{
		 return Response::json(Auth::user());
	}
	
	public function updateProfile(ProfileRequest $response)
	{
		$user = Auth::user();
		if($user)
		{
			$id = Input::file('Image') ?  $this->uploadImage(Input::file('Image')) : $user->images->id;
			$user->fill(array(
				"profileId" => $id,
				"biography" => Input::get('bio')
			));
			$user->save();
		}
		
		return redirect('/profile');
	}
	
	private function uploadImage($file)
	{
		$serverDir =  "uploaded_images/".Auth::user()->username;
		$dir = public_path($serverDir);
		if( File::exists($dir) or File::makeDirectory($dir) )
		{
			$extension = $file->getClientOriginalExtension();
  			$filename = 'profile.'.$extension;
		    $path = $dir."/".$filename;
			//Get Move the file to the directory.
			$file->move($dir,$filename);
			//Create an image with a url
			$newImage = Images::create(array(
					"url"=> ''.$serverDir.'/'.$filename
			));
			
			return $newImage->id;
		}
		
		return null;
	}
	
	public function removeUserTag($id)
	{
		$tag = FollowingEvent::where('id', '=', $id)->first();
		
		//Do we have permission to do so?
		if($tag->userid == Auth::user()->id)
		{
			$tag->delete();
			return redirect('/profile');
		}
		
		abort(404);
		return false;
		
	}
	
}
