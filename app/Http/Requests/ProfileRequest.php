<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response, Auth, Input;


class ProfileRequest extends FormRequest
{
	public function rules()
    {
        return [
            'bio' => 'max:500'
        ];
    }
    
    public function authorize()
    {
        // Only allow logged in users
        return Auth::check();
    }
    
    //Check if the Biography has illegal characters in it And if the image doesn't exceeds the limit. 
    public function getValidatorInstance() {
        $validator = parent::getValidatorInstance();

        $mb = 2;
        $sizeLim = $mb * pow(1024,2);
        $file = Input::file('profile');
        $illegal = "#%^&[]/{}|:<>";

         $validator->after(function() use ($validator, $sizeLim, $file, $illegal) {
            
            if(strpbrk(Input::get('bio'), $illegal))
            {
                $validator->errors()->add('Bio', 'Cannot contain illegal characters');
            }
            
            
            
            
           if(!in_array($file->getClientOriginalExtension(), array('png', 'jpg', 'gif')))
            {
                $validator->errors()->add('Bio', 'Incorrect File Type used.');
            }
            
            
            if($file->getSize() > $sizeLim)
            {
                $validator->errors()->add('Size', 'File exceeds upload limit of '.$mb.' mb');
            } 

        });
        return $validator;
    }
}