<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model{
	protected $table = 'product_category';

    protected $guarded = [];

    protected $primaryKey = 'id';
    
    public $incrementing = true;

 //    public function user(){
	// 	return $this->belongsTo('App\User', 'username', 'username');
	// }
}
