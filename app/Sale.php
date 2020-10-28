<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Staff;

class Sale extends Model{
	protected $table = 'sales';

    protected $guarded = [];

    protected $primaryKey = 'id';
    
    public $incrementing = true;

    protected $appends = ['staff_name'];

    public function getStaffNameAttribute(){
        return Staff::find($this->staff_id)->name;
    }

}
