<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response, Auth, Input;


class PostRequest extends FormRequest
{
	public function rules()
    {
        //Regex here checks if there is one ore more instance of #Hashtags.
        return [
            'text' => array('max:140', 'required', 'regex:/\S*#(?:\[[^\]]+\]|\S+)/')
        ];
    }
    
    public function authorize()
    {
        return Auth::check();
    }
    
}