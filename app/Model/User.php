<?php namespace App\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['username', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function followingevent()
	{
		return $this->hasMany('App\Model\FollowingEvent', 'userid');
	}

	public function following()
	{
		return $this->hasMany('following', 'userid');
	}

	public function posts()
	{
		return $this->hasMany('posts', 'userId');
	}


	//Get the following events we have.
	public function getFollowingEvents()
	{
		$hashTags = array();
        foreach ($this->followingevent as $followObject) {
            $hashTags[] = $followObject->hashtag;
        }
        return $hashTags;
	}

	public function getFollowing()
	{
		return array_map(function($follower){
			return $follower->followingid;
		}, $this->following);
	}
}
