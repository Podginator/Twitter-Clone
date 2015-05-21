<?php namespace App\Http\Controllers;
 
use Auth, View, Response, Input, File;
use App\Model\FollowingEvent;
use App\Model\Following;
use App\Model\User;
use App\Model\Files;
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
			$id = Input::file('Image') ?  $this->uploadImage(Input::file('Image')) : $user->files->id;
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

		$mb = 1;											// Valid Mega bytes. 
		$validExt = array('mp4', 'png', 'jpg', 'gif');		// Valid file extensions.
		$validSize = $mb * pow(pow(2, 10), 2 );      	 	// Valid image size in Mb.

		if( File::exists($dir) or File::makeDirectory($dir) )
		{
			$extension = $file->getClientOriginalExtension();
			$fileSize = $file->getSize();

			if( in_array($extension, $validExt) && $fileSize <= $validSize ) // Checks if the file extension is valid AND
																					// if the image size doesn't exceeds the limit.											
			{	
			/*----------------------------------------*/

				// Crop image:

				$imageProps = getimagesize( $file );
	
				$imageW = $imageProps[0];
				$imageH = $imageProps[1];

				switch( $extension )
				{
					case 'jpg':  $oldImage = imagecreatefromjpeg( $file );  break; // The current file is a JPG extension.
					case 'png':  $oldImage = imagecreatefrompng(  $file );  break; // The current file is a PNG extension.
					case 'gif':  $oldImage = imagecreatefromgif(  $file );  break; // The current file is a GIF extension.
				}

				$croppedImage = imagecreatetruecolor(140,140); 		// Create a new cropped image as the new profile image.
	
				$cropH = 0;
				$cropW = 0;
				
				
				if($imageW > $imageH)         						// The original image has an aspect greater than 1.
				{
					$cropW = ($imageW - $imageH) / 2;
					$cropH = 0;
					$imageW = $imageH;
				}
				else 												// The original image has an aspect less than 1.
				{
					$cropW = 0;
					$cropH = ($imageH - $imageW) /2;
					$imageH = $imageW;
				} 
				
				imagecopyresampled($croppedImage, $oldImage, 0, 0, $cropW, $cropH,  140, 140, $imageW, $imageH);

				$filename = 'profile.'.$extension;
			    $path = $dir."/".$filename;

				switch( $extension )
				{
					case 'jpg':  imagejpeg($croppedImage, $dir."/".$filename, 100);   break; // The current file is a JPG extension.
					case 'png':  imagepng($croppedImage, $dir."/".$filename, 0); 	 break; // The current file is a PNG extension.
					case 'gif':  imagegif($croppedImage, $dir."/".$filename);		 break; // The current file is a GIF extension.
				}

			/*----------------------------------------*/
	  			
				//Get Move the file to the directory.
				$file->move($dir,$croppedImage);
				//Create an image with a url
				$newImage = Files::create(array(
						"url"=> ''.$serverDir.'/'.$filename
				));	
			
				return $newImage->id;
			}
			return null;
			
		}
		
		return null;
	}
	
	public function SubscribePerson(User $user)
	{
		$success =  Response::json(array('success' => true));
		$fail =  Response::json(array('success' => false));
		
		$follow = Following::create(array(
			"userid" => Auth::user()->id,
			"followingid" => $user->id
		));
		
		return $follow->id ? $success : $fail;
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
