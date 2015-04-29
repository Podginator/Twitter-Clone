<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FollowingEvent extends Model {

	protected $table = "followingevent";

	public function user()
	{
		return $this->belongsTo('App\Model\User', 'userid');
	}

}
