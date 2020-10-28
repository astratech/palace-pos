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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AccessController extends Controller{

	public function index(){
		$r = Access::all();
		return ["success"=>true, "response"=>$r];
	}

	public function create(Request $request){
		$validator = Validator::make($request->all(), [
           'name' => 'required|string|unique:api_access',
       	]);

       	if($validator->fails()) {
       		return ["success"=>false, "response"=>$validator->messages()->first()];
       	}
       	else{
       		$token = Str::random(60);
       		Access::create(
				['name' => $request->name, 'api_token' => $token]
			);
       	}

		return ["success"=>true, "response"=>$token];
	}
}
