<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StoryPost extends Model {
	public $timestamps = false; 
	protected $fillable = ['postid', 'storyid'];
	protected $table = "storypost";
	
	public function users()
	{
		$this->belongsTo('App\Model\Story', 'storyid');
	}
	
	
	
}
