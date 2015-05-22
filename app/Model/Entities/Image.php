<?php namespace App\Model\Entities;

use \Symfony\Component\HttpFoundation\File\UploadedFile;
use \Symfony\Component\HttpFoundation\File\File;
class Image
{
	protected $image;
    protected $uploadedFile;

    /**
     * The UPLOAD_ERR_XXX constant provided by the uploader.
     *
     * @var int
     */
    private $error;
	
	public function getImage()
	{
		return $this->image;
	}
	
    public function __construct(UploadedFile $file)
    {   
       $this->uploadedFile = $file;
    }
    
    public function getFileInstance()
    {
        return $this->uploadedFile;
    }
    
    public function cropImage($targetHeight, $targetWidth)
    {
        
    }
    
    public function squareCrop($size)
    {
        $imageProps = getimagesize( $this->uploadedFile );
        echo $imageProps[0];
	
		$imageW = $imageProps[0];
		$imageH = $imageProps[1];
        $extension = $this->uploadedFile->getClientOriginalExtension();
		switch( $this->uploadedFile->getClientOriginalExtension())
		{
			case 'jpg':
            case 'jpeg': 
                 $oldImage = imagecreatefromjpeg( $this->uploadedFile ); 
                 break; // The current file is a JPG extension.
			case 'png':  
                $oldImage = imagecreatefrompng(  $this->uploadedFile );
                break; // The current file is a PNG extension.
			case 'gif':  
                $oldImage = imagecreatefromgif(  $this->uploadedFile );
                break; // The current file is a GIF extension.
		}

		$this->image = imagecreatetruecolor(140,140); 		// Create a new cropped image as the new profile image.

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
		
		imagecopyresampled($this->image, $oldImage, 0, 0, $cropW, $cropH,  $size, $size, $imageW, $imageH);
        $filename = $this->uploadedFile->getPathname();
		switch( $extension )
		{
			case 'jpg':  $this->image = imagejpeg($this->image,$filename, 100);   break; // The current file is a JPG extension.
			case 'png':   $this->image =imagepng($this->image, $filename, 0); 	 break; // The current file is a PNG extension.
			case 'gif':   $this->image =imagegif($this->image,$filename);		 break; // The current file is a GIF extension.
		}
    }
    
    private function getAspectRatio($width, $height)
    {
        return $width/$height;
    }
    
}
