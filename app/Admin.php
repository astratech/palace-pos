<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model{
	protected $table = 'admins';

    protected $guarded = [];

    protected $primaryKey = 'id';
    
    public $incrementing = true;

}
