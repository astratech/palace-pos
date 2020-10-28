<?php

/**
 * User Controller for Fimiti
 * @author Sangosanya Segun - Flamezbaba <flamezbaba@gmail.com>
 * @version 1.0
**/

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Product;
Use App\Site;
Use App\Sale;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller{

	public function index(){
		$r = Sale::orderBy("id", "desc")->paginate(10);
		return ["success"=>true, "response"=>$r];
	}

	public function all(){
		$r = Sale::orderBy("id", "desc")->get();
		return ["success"=>true, "response"=>$r];
	}

	public function sale_by_staff(){
		$r = Sale::orderBy("id", "desc")->get();
		return ["success"=>true, "response"=>$r];
	}

	/**
     * Create record
     *
     * @param  string 	$title
     * @param  string 	$name
     * @param  string 	$role
     * @return JSON
    */
	public function create(Request $request){
		$validator = Validator::make($request->all(), [
			'subtotal' => 'required|numeric',
			'staff_id' => 'required|numeric',
			'vat' => 'required|numeric',
			'discount' => 'required|numeric',
			'customer' => 'required|string',
			'total' => 'required|numeric',
			'products' => 'required',
		]);

		// return ["success"=>true, "response"=>json_decode($request->products)];

		if($validator->fails()) {
			return ["success"=>false, "response"=>$validator->messages()->first()];
		}
		else{

       		// sanitize inputs
			$data = [
				"subtotal" => $request->subtotal,
				"vat" => $request->vat,
				"discount" => $request->discount,
				"total" => $request->total,
				"customer" => $request->customer,
				"staff_id" => $request->staff_id,
				"products" => $request->products,
			];

			$r = Sale::create($data);
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
		$data = Sale::find($id);
		if(is_null($data)){
			return ["success"=>false, "response"=>"record not found"];
		}
		else{
			return ["success"=>true, "response"=>$data];
		}
	}

	public function show_per_staff($staff_id){
		$data = Sale::where("staff_id", $staff_id)->get();
		if(is_null($data)){
			return ["success"=>false, "response"=>"record not found"];
		}
		else{
			return ["success"=>true, "response"=>$data];
		}
	}


	/**
     * delete single record
     *
     * @param  int 	$id
     * @return JSON
    */
	public function delete($id){
		$record = Sale::find($id);
		if($record){
			$record->delete();
			return ["success"=>true, "response"=>"record deleted"];
		}
		else{
			return ["success"=>false, "response"=>"record does not exist"];
		}
	}
}
