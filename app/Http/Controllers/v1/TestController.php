<?php

/**
 * User Controller for Fimiti
 * @author Sangosanya Segun - Flamezbaba <flamezbaba@gmail.com>
 * @version 1.0
**/

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Access;
// Use App\Site;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller{

	public function index(){
		$user = Access::all();
		return ["success"=>true, "response"=>$user];
	}

	public function auth_failed(){
		return ["success"=>false, "response"=>"API Authentication Failed"];
	}
}
