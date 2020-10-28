<?php

/**
 * User Controller for Fimiti
 * @author Sangosanya Segun - Flamezbaba <flamezbaba@gmail.com>
 * @version 1.0
**/

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Staff;
Use App\Site;
Use App\Admin;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller{

	public function index(){
		$r = Staff::orderBy("id", "desc")->paginate(10);
		return ["success"=>true, "response"=>$r];
	}

	/**
     * Create staff record
     *
     * @param  string 	$title
     * @param  string 	$name
     * @param  string 	$role
     * @return JSON
    */
	public function create(Request $request){
		$validator = Validator::make($request->all(), [
			'title' => 'required|string',
			'name' => 'required|string|unique:staffs',
			'role' => 'required|string',
		]);

		if($validator->fails()) {
			return ["success"=>false, "response"=>$validator->messages()->first()];
		}
		else{

       		// sanitize inputs
			$data = [
				"title" => strtolower($request->title),
				"name" => strtolower($request->name),
				"role" => strtolower($request->role)
			];
			$r = Staff::create($data);
			return ["success"=>true, "response"=>$r];
		}

		
	}

	/**
     * Show single staff record
     *
     * @param  int 	$id
     * @return JSON
    */
	public function show($id){
		$data = Staff::find($id);
		if(is_null($data)){
			return ["success"=>false, "response"=>"record does not exist"];
		}
		else{
			return ["success"=>true, "response"=>$data];
		}
	}

  /**
     * Show single staff record
     *
     * @param  string  $clause
     * @return JSON
    */
  	public function search(Request $request){
  	$validator = Validator::make($request->all(), [
  		'clause' => 'required|string',
  	]);

  	if($validator->fails()) {
  		return ["success"=>false, "response"=>$validator->messages()->first()];
  	}
  	else{
  		$data = Staff::where('name', 'like', "%$request->clause%")
  		->orWhere('role', 'like', "%$request->clause%")
  		->orWhere('title', 'like', "%$request->clause%")
  		->get();

  		if(is_null($data)){
  			return ["success"=>false, "response"=>"record does not exist"];
  		}
  		else{
  			return ["success"=>true, "response"=>$data];
  		}
  		// return ["success"=>true, "response"=>$request->clause];
  	}



        // $data = Staff::where("name", $request->clause);

        // return ["success"=>true, "response"=>"ffdhdfhjfdhj"];
        // if(is_null($data)){
        //   return ["success"=>false, "response"=>"record does not exist"];
        // }
        // else{
        //   return ["success"=>true, "response"=>$data];
        // }
  }

	/**
     * update single staff record
     *
     * @param  int 		$id
     * @param  string 	$title
     * @param  string 	$name
     * @param  string 	$role
     * @param  int 		$pin
     * @return JSON
    */
	public function update($id, Request $request){
		$staff = Staff::find($id);

		if($staff){
			$data = [
				"title" => strtolower($request->title),
				"name" => strtolower($request->name),
				"role" => strtolower($request->role),
				"pin_code" => empty($request->pin_code) ? $staff->pin_code : $request->pin_code,
			];
			$staff->update($data);
			return ["success"=>true, "response"=>$staff];

		}
		else{
			return ["success"=>false, "response"=>"record does not exist"];
		}
	}

	public function change_admin_password($id, Request $request){
		$validator = Validator::make($request->all(), [
			'password' => 'required|string',
		]);

		if($validator->fails()) {
			return ["success"=>false, "response"=>$validator->messages()->first()];
		}
		else{

			$record = Admin::find($id);

			if($record){
				// sanitize inputs
				$data = [
					"password" => $request->password,
				];

				$record->update($data);
				return ["success"=>true, "response"=>"done"];

			}
			else{
				return ["success"=>false, "response"=>"record does not exist"];
			}
		}
	}

	/**
     * delete single staff record
     *
     * @param  int 	$id
     * @return JSON
    */
	public function delete($id){
		$staff = Staff::find($id);
		if($staff){
			$staff->delete();
			return ["success"=>true, "response"=>"record deleted"];
		}
		else{
			return ["success"=>false, "response"=>"record does not exist"];
		}
	}
}
