<?php namespace App\Http\Controllers;
 
use Auth, View, Response, Input, File;
use App\Model\FollowingEvent;
use App\Model\Following;
use App\Model\User;
use App\Model\Files;
use App\Http\Requests\ProfileRequest;
use App\Model\Entities\Image;
use ValidationService;

class UserController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| User Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the restful for user and makes the profile pages
	| It also handles profile uploads.
	|
	*/
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
	
	public function getCurrentUser()
	{
		 return Response::json(Auth::user());
	}
	
	public function updateProfile(ProfileRequest $response)
	{
		$user = Auth::user();
		if($user)
		{
			$id = Input::file('profile') ?  $this->uploadImage(Input::file('profile')) : $user->files->id;
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

		$mb = 5;											// Valid Mega bytes. 
		$validExt = array('mp4', 'png', 'jpg', 'gif');		// Valid file extensions.
		$validSize = $mb * pow(1024, 2 );      	 	// Valid image size in Mb.
			
		if( File::exists($dir) or File::makeDirectory($dir) )
		{
			$extension = $file->getClientOriginalExtension();
			$fileSize = $file->getSize();
			// Checks if the file extension is valid AND
			// if the image size doesn't exceeds the limit.
			if( in_array($extension, $validExt) && $fileSize <= $validSize ) 											
			{	
				$filename = 'profile.'.$extension;
			    $path = $dir."/".$filename;
				
				$file = new Image($file);
				$file->squareCrop(140);
				$file->getFileInstance()->move($dir,$filename);
				//Create an image with a url
				$newImage = Files::create(array(
						"url"=> ''.$serverDir.'/'.$filename
				));	
			
				return $newImage->id;
			}
		}
		return null;
	}
	
	public function subscribePerson(User $user)
	{
		$success =  Response::json(array('success' => true));
		$fail =  Response::json(array('success' => false));
		
		$follow = Following::create(array(
			"userid" => Auth::user()->id,
			"followingid" => $user->id
		));
		
		return $follow->id ? $success : $fail;
	}
	
	public function isFollowing()
	{
		return Response::json(array('success'=> true, 'users'=>User::find(Auth::user()->getFollowing())));
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
