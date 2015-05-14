<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Images extends Model {
	public $timestamps = false; 
	protected $fillable = ['url'];
	protected $table = "images";
	
	 public function user()
    {
        return $this->belongsTo('App\Model\User', 'profileId');
    }

	
}
