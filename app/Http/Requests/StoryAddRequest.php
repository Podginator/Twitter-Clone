<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response, Auth, Input;


class StoryAddRequest extends FormRequest
{
	public function rules()
    {
        return [
            'title' => array('max:140', 'required', 'regex:/^[a-zA-Z0-9]+$/')
        ];
    }
    
    public function authorize()
    {
        return Auth::check();
    }
    
}