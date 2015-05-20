<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FollowingEvent extends Model {

	public $timestamps = false; 
	protected $table = "followingevent";
	protected $fillable = ['userid', 'hashtag'];
	
	//A following event belongs to User. With the Userid.
	public function user()
	{
		return $this->belongsTo('App\Model\User', 'userid');
	}

}
