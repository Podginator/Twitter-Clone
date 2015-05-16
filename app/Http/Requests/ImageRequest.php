<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response, Auth, Input;


class ImageRequest extends FormRequest
{
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

         $validator->after(function() use ($validator) {
            if(!in_array(Input::file('image')->getClientOriginalExtension(), array('mp4', 'png', 'jpg', 'gif')))
            {
                $validator->errors()->add('Bio', 'Incorrect File Type used.');
            }

        });
        return $validator;
    }
    
}