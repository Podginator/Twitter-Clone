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
    
    //Check if the Biography has illegal characters in it. 
    public function getValidatorInstance() {
        $validator = parent::getValidatorInstance();

         $validator->after(function() use ($validator) {
            $illegal = "#%^&[]/{}|:<>";
            if(strpbrk(Input::get('bio'), $illegal))
            {
                $validator->errors()->add('Bio', 'Cannot contain illegal characters');
            }

        });
        return $validator;
    }
    
}