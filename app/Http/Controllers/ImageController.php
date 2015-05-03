<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Model\Images;
use Auth, View, Response, Input, Image, File, FilesystemIterator;

class ImageController extends Controller {


    // now save your image to your $path
	//All we need. This will return an id for an Image Item when uploaded. 
	public function store()
	{
		//To upload an image a user needs to be logged in.

		if(Auth::user())
		{
			$serverDir =  "uploaded_images\\".Auth::user()->username;
			$dir = public_path($serverDir);
			
			if( File::exists($dir) or File::makeDirectory($dir) )
			{
				$fi = new FilesystemIterator($dir, FilesystemIterator::SKIP_DOTS);
				$extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
      			$filename = rand(11111,99999).'.'.$extension;
			    $path = $dir."/".$filename;
				Input::file('image')->move($dir,$filename);
				$newImage = Images::create(array(
						"url"=> '\\'.$serverDir.'\\'.$filename
					));
				return Response::json(array('success' => true, 'id' =>$newImage->id));
			}
		}
		
		//Otherwise, we'll return a fail response. 
		return Response::json(array('success' => true, 'id' =>null));
	}

}
