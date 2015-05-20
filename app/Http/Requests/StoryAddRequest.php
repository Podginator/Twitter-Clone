<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response, Auth, Input;
use Auth\model\Post;


class StoryAddRequest extends FormRequest
{
	public function rules()
    {
        return [
            'title' => array('max:140', 'required'),
            'hashtag' => array('max:140', 'required', 'regex:/^[a-zA-Z0-9]+$/'),
            'description' => "max:255"
        ];
    }
    
    public function authorize()
    {
        return Auth::check();
    }
    
    public function getValidatorInstance() {
        $validator = parent::getValidatorInstance();

         $validator->after(function() use ($validator) {
            if(count(Input::get('posts')) == 0 )
            {
                $validator->errors()->add('Posts', 'A story post should contain some posts.');
                foreach(Input::get('posts') as $value)
                {
                    $post = Post::where("id", '=', $value)->first();
                    if(!strpost($post->text,Input::get('hashtag')) === FALSE){
                        $validator->errors()->add('A post', 'A post does not contain your hashtag');
                    }
                }
            }

        });
        return $validator;
    }
    
}