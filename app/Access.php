<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Access extends Model{
	protected $table = 'api_access';

    protected $guarded = [];

    protected $primaryKey = 'id';
    
    public $incrementing = true;

 //    public function user(){
	// 	return $this->belongsTo('App\User', 'username', 'username');
	// }
	public function getAuthIdentifier(){
		# code...
	}
    
}
