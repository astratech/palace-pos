<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{
	protected $table = 'products';

    protected $guarded = [];

    protected $primaryKey = 'id';
    
    public $incrementing = true;

 //    public function user(){
	// 	return $this->belongsTo('App\User', 'username', 'username');
	// }
}
