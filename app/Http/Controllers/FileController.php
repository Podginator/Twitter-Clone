<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;
use App\Model\Files;
use Auth, View, Response, Input, Image, File, FilesystemIterator;

class FileController extends Controller {


    // now save your image to your $path
	//All we need. This will return an id for an Image Item when uploaded. 
	public function store(ImageRequest $request)
	{
		
		//To upload an image a user needs to be logged in.
		if(Auth::user())
		{
			//We get where the post is on the server ( to store in an image object.)
			$serverDir =  "uploaded_images/".Auth::user()->username;
			$dir = public_path($serverDir);
 
			$Mb = 2;											// Valid Mega bytes. 
			$validExt = array('mp4', 'png', 'jpg', 'gif');			// Valid file extensions.
			$validSize = $Mb * pow(pow(2, 10), 2 );      	 	// Valid image size in Mb.
			
			if( File::exists($dir) or File::makeDirectory($dir) )
			{
				//FileSystemIterator is just to get the count of objects.
				$fi = new FilesystemIterator($dir, FilesystemIterator::SKIP_DOTS);
				//We get the extensions (ie:.ping)
				//TODO: Add check to make sure object is image, both client and server side.
				$extension = Input::file('image')->getClientOriginalExtension();
				$fileSize = Input::file('image')->getSize();

				if( in_array($extension, $validExt) && $fileSize <= $validSize ) 		// Checks if the file extension is valid AND
																							// if the image size doesn't exceeds the limit.											
				{
					//Get Random Generated Number + Amount of File to avoid users being able to go /userimages/img/whatever
	      			$filename = rand(11111,99999).iterator_count($fi).'.'.$extension;
					  //Get Path.
				    $path = $dir."/".$filename;
					//Get Move the file to the directory.
					Input::file('image')->move($dir,$filename);
					//Create an image with a url
					$newImage = Files::create(array(
							"url"=> ''.$serverDir.'/'.$filename
						));
						
					//Return the ID to use on the post.
					return Response::json(array('success' => true, 'id' =>$newImage->id));
				}
				else
				{
					//break;
					return Response::json(array('success' => false, 'id' =>null));
				}
			}
		}
		
		//Otherwise, we'll return a fail response. 
		return Response::json(array('success' => false, 'id' =>null));
	}

}
