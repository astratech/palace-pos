<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model{
	protected $table = 'staffs';

    protected $guarded = [];

    protected $primaryKey = 'id';
    
    public $incrementing = true;

 //    public function user(){
	// 	return $this->belongsTo('App\User', 'username', 'username');
	// }
}
