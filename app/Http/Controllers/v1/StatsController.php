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
Use App\Sale;
Use App\Product;
Use App\Site;
use Illuminate\Support\Facades\Validator;

class StatsController extends Controller{

	public function index(){
		$stats = [
			"total_staff" => count(Staff::all()),
			"total_sales" => count(Sale::all()),
			"total_sales_amount" => Sale::all()->sum("total"),
			"total_products" => count(Product::all()),
		];

		return ["success"=>true, "response"=>$stats];
	}

	public function total_staff(){
		$c = count(Staff::all());
		return ["success"=>true, "response"=>$c];
	}

	public function total_sales(){
		$c = count(Sale::all());
		return ["success"=>true, "response"=>$c];
	}

	public function total_sales_amount(){
		$c = Sale::all()->sum("total");
		return ["success"=>true, "response"=>$c];
	}

	public function total_products(){
		$c = count(Product::all());
		return ["success"=>true, "response"=>$c];
	}

	
}
