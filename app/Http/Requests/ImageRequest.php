<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response, Auth, Input;
use Log;

class ImageRequest extends FormRequest
{
    //All the rules are defined in the Validator, as they're more complicated'
    //Than the rules function allows.
	public function rules()
    {
        return [
        ];
    }
    
    public function authorize()
    {
        return Auth::check();
    }
    
     public function getValidatorInstance() {
        $validator = parent::getValidatorInstance();
        $mb = 5;
        $sizeLim = $mb * pow(pow(10,2),2);
        $file = Input::file('image');
         $validator->after(function() use ($validator, $sizeLim, $file) {
            if(!in_array($file->getClientOriginalExtension(), array('mp4', 'png', 'jpg', 'gif')))
            {
                $validator->errors()->add('Bio', 'Incorrect File Type used.');
            }
            if($file->getSize() > $sizeLim)
            {
                $validator->error()->add('Size', 'File exceeds upload limit of '.$mb.' mb');
            }

        });
        return $validator;
    }
    
}