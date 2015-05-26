<?php namespace App\Model;

use Illuminate\Auth\Authenticatable;
use App\Model\TimeModel;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends TimeModel implements AuthenticatableContract, CanResetPasswordContract {

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
	protected $fillable = ['username', 'email', 'password', 'profileId', 'biography'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token', 'email'];


	//Get all the relationships.
	public function followingevent()
	{
		return $this->hasMany('App\Model\FollowingEvent', 'userid');
	}

	public function following()
	{
		return $this->hasMany('App\Model\Following', 'userid');
	}

	public function post()
	{
		return $this->hasMany('App\Model\Posts', 'userId');
	}
	
	public function story()
	{
		return $this->hasMany('App\Model\Story', 'userId');
	}

	public function files()
	{
		return $this->hasOne('App\Model\Files', 'id', 'profileId');
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
		$following = array();
        foreach ($this->following as $followObject) {
            $following[] = $followObject->followingid;
        }
        return $following;
	}
}
