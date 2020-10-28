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
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller{

	public function index(){
		$r = Product::orderBy("id", "desc")->paginate(10);
		return ["success"=>true, "response"=>$r];
	}

	public function list(){
		$r = Product::orderBy("id", "desc")->get();
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
			'name' => 'required|string|unique:products',
			'price' => 'required|numeric',
			'categories' => 'string',
			'avatar' => 'file',
		]);

		if($validator->fails()) {
			return ["success"=>false, "response"=>$validator->messages()->first()];
		}
		else{

       		// sanitize inputs
			$data = [
				"name" => strtolower($request->name),
				"price" => strtolower($request->price),
				"categories" => strtolower($request->categories),
			];

			$r = Product::create($data);
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
		$data = Product::find($id);
		if(is_null($data)){
			return ["success"=>false, "response"=>"record does not exist"];
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
     * @param  int 	$price
     * @return JSON
    */
	public function update($id, Request $request){
		$validator = Validator::make($request->all(), [
			'name' => 'required|string',
			'price' => 'required|numeric',
			'categories' => '',
			'avatar' => 'file',
		]);

		if($validator->fails()) {
			return ["success"=>false, "response"=>$validator->messages()->first()];
		}
		else{

			$record = Product::find($id);

			if($record){
				// sanitize inputs
				$data = [
					"name" => empty($request->name) ? $record->name : strtolower($request->name),
					"price" => empty($request->price) ? $record->price : $request->price,
					"avatar" => empty($request->avatar) ? $record->avatar : $request->avatar,
					"categories" => $request->categories,
				];

				$record->update($data);
				return ["success"=>true, "response"=>$record];

			}
			else{
				return ["success"=>false, "response"=>"record does not exist"];
			}
		}
	}

	public function upload($id, Request $request){
		$validator = Validator::make($request->all(), [
			'file' => 'file|required',
		]);

		if($validator->fails()) {
			return ["success"=>false, "response"=>$validator->messages()->first()];
		}
		else{
			$teller = $request->file('file');

            if(($teller->getClientOriginalExtension() != 'png') AND ($teller->getClientOriginalExtension() != 'jpg') AND ($teller->getClientOriginalExtension() != 'jpeg')){
              
                return ["success"=>false, "response"=>"Invalid Image. Only jpg and png supported"];
            }

            $m = base_path("products/");
            $f = $id.".".$teller->getClientOriginalExtension();
            $teller->move($m, $f);

           

			$record = Product::find($id);
			if($record){
				// sanitize inputs
				 $data = [
					"avatar" => $f,
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
     * update product category record - to add new category
     *
     * @param  int 		$id
     * @param  array 	$catogeries
     *
     * @return JSON
    */
	public function update_category($id, Request $request){
		$validator = Validator::make($request->all(), [
			'categories' => 'required|string',
		]);

		if($validator->fails()) {
			return ["success"=>false, "response"=>$validator->messages()->first()];
		}
		else{

			$record = Product::find($id);
			if($record){

				// $n = json_decode($record->categories);
				// $request->categories = json_decode($request->categories);
				// foreach($request->categories as $key => $value) {
				// 	array_push($n, "$value");
				// }
				$record->update(["categories"=>$request->categories]);

				return ["success"=>true, "response"=>$record];

			}
			else{
				return ["success"=>false, "response"=>"record does not exist"];
			}
		}
	}

	/**
     * delete product category - to remove single category
     *
     * @param  int 		$id
     * @param  string 	$catogeries
     *
     * @return JSON
    */
	public function delete_category($id, Request $request){
		$record = Product::find($id);
		$validator = Validator::make($request->all(), [
			'category' => 'required|string',
		]);

		if($validator->fails()) {
			return ["success"=>false, "response"=>$validator->messages()->first()];
		}
		else{
			if($record){
				$n = json_decode($record->categories);
				$n = array_merge(array_diff($n, array("$request->category")));
				$record->update(["categories"=>$n]);
				return ["success"=>true, "response"=>$record];
			}
			else{
				return ["success"=>false, "response"=>"record not found"];
			}
		}
	}

	public function search(Request $request){
	  	$validator = Validator::make($request->all(), [
	  		'clause' => 'required|string',
	  	]);

	  	if($validator->fails()) {
	  		return ["success"=>false, "response"=>$validator->messages()->first()];
	  	}
	  	else{
	  		$data = Product::where('name', 'like', "%$request->clause%")
	  		->orWhere('price', 'like', "%$request->clause%")
	  		->orWhere('categories', 'like', "%$request->clause%")
	  		->get();

	  		if(is_null($data)){
	  			return ["success"=>false, "response"=>"record not found"];
	  		}
	  		else{
	  			return ["success"=>true, "response"=>$data];
	  		}
	  		// return ["success"=>true, "response"=>$request->clause];
	  	}
	}

	/**
     * delete single record
     *
     * @param  int 	$id
     * @return JSON
    */
	public function delete($id){
		$record = Product::find($id);
		if($record){
			$record->delete();
			return ["success"=>true, "response"=>"record deleted"];
		}
		else{
			return ["success"=>false, "response"=>"record does not exist"];
		}
	}
}
