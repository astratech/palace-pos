<?php

/**
 * User Controller for Fimiti
 * @author Sangosanya Segun - Flamezbaba <flamezbaba@gmail.com>
 * @version 1.0
**/

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\ProductCategory;
Use App\Site;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller{

	public function index(){
		$r = ProductCategory::orderBy("id", "desc")->paginate(10);
		return ["success"=>true, "response"=>$r];
	}

	public function list(){
		$r = ProductCategory::orderBy("id", "desc")->get();
		return ["success"=>true, "response"=>$r];
	}

	/**
     * Create record
     *
     * @param  string 	$name
     * @return JSON
    */
	public function create(Request $request){
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|unique:product_category',
		]);

		if($validator->fails()) {
			return ["success"=>false, "response"=>$validator->messages()->first()];
		}
		else{

       		// sanitize inputs
			$data = [
				"name" => strtolower($request->name),
			];

			$r = ProductCategory::create($data);
			return ["success"=>true, "response"=>$r];
		}
		
	}

	/**
     * Show single record
     *
     * @param  int 	$id
     * @return JSON
    */
	public function show($id){
		$data = ProductCategory::find($id);
		if(is_null($data)){
			return ["success"=>false, "response"=>"record not found"];
		}
		else{
			return ["success"=>true, "response"=>$data];
		}
	}

	/**
     * update single record
     *
     * @param  int 		$id
     * @param  string 	$name
     *
     * @return JSON
    */
	public function update($id, Request $request){
		$validator = Validator::make($request->all(), [
			'name' => 'string|unique:product_category',
		]);

		if($validator->fails()) {
			return ["success"=>false, "response"=>$validator->messages()->first()];
		}
		else{

			$record = ProductCategory::find($id);
			if($record){
				// sanitize inputs
				$data = [
					"name" => empty($request->name) ? $record->name : strtolower($request->name),
				];

				$record->update($data);
				return ["success"=>true, "response"=>$record];

			}
			else{
				return ["success"=>false, "response"=>"record does not exist"];
			}
		}
	}

	/**
     * delete single record
     *
     * @param  int 	$id
     * @return JSON
    */
	public function delete($id){
		$record = ProductCategory::find($id);
		if($record){
			$record->delete();
			return ["success"=>true, "response"=>"record deleted"];
		}
		else{
			return ["success"=>false, "response"=>"record not found"];
		}
	}
}
