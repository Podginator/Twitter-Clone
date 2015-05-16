<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Files extends Model {
	public $timestamps = false; 
	protected $fillable = ['url'];
	protected $table = "files";
	
	 public function user()
    {
        return $this->belongsTo('App\Model\User', 'profileId');
    }
}

