<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Zones;
Use App\Post;
use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller{
    public function index(){
        return ["success"=>true, "response"=>Zones::all()];
    }
 
    public function show($id){
    	return Post::find($id);
    }

    public function start(Request $request){
    	$zones = [
			"zone 1" => [
				"bodija",
				"secretariat",
				"agodi",
				"ikolaba",
				"sango",
				"u.i",
				"mokola",
				"samonda",
				"apete",
				"ijokodo",
				"agbaje",
				"yemetu",
				"total garden",
				"gate",
				"orita-bashorun",
			],
			"zone 2" => [
				"dugbe",
				"ogunpa",
				"aleshinloye",
				"eleyele",
				"jericho",
				"nihort",
			],
			"zone 3" => [
				"ojoo",
				"ajibode",
				"niser",
				"moniya",
				"iita",
			],
			"zone 4" => [
				"iwo road",
				"gbagi",
				"alakia",
				"iyana church",
				"olodo",
			],
			"zone 5" => [
				"iyaganku",
				"odo ona",
				"oke ado",
				"challenge",
				"molete",
				"orita-challenge",
				"ring road",
				"mobil",
			],
			"zone 6" => [
				"new garage",
				"elebu",
				"akala way",
				"tipa garage",
				"cosmos",
				"ire akari",
			],
			"zone 7" => [
				"ashi",
				"akobo",
			]
		];

		// foreach ($zones as $key => $value) {
		// 	Zones::create(
		// 		['name' => $key, 'regions' => $value]
		// 	);
		// }

        // return Zones::create($request->all());
    }

    public function store(Request $request){
    	$zones = [
			"zone 1" => [
				"bodija",
				"secretariat",
				"agodi",
				"ikolaba",
				"sango",
				"u.i",
				"mokola",
				"samonda",
				"apete",
				"ijokodo",
				"agbaje",
				"yemetu",
				"total garden",
				"gate",
				"orita-bashorun",
			],
			"zone 2" => [
				"dugbe",
				"ogunpa",
				"aleshinloye",
				"eleyele",
				"jericho",
				"nihort",
			],
			"zone 3" => [
				"ojoo",
				"ajibode",
				"niser",
				"moniya",
				"iita",
			],
			"zone 4" => [
				"iwo road",
				"gbagi",
				"alakia",
				"iyana church",
				"olodo",
			],
			"zone 5" => [
				"iyaganku",
				"odo ona",
				"oke ado",
				"challenge",
				"molete",
				"orita-challenge",
				"ring road",
				"mobil",
			],
			"zone 6" => [
				"new garage",
				"elebu",
				"akala way",
				"tipa garage",
				"cosmos",
				"ire akari",
			],
			"zone 7" => [
				"ashi",
				"akobo",
			]
		];

		// foreach ($zones as $key => $value) {
		// 	Zones::create(
		// 		['name' => $key, 'regions' => $value]
		// 	);
		// }

        // return Zones::create($request->all());
    }

    public function get_zone_from_region($request){
    	$validator = Validator::make($request->all(), [
           'region' => 'required|string',
       	]);
        
       	if($validator->fails()) {
       		return ["success"=>false, "response"=>$validator->messages()->first()];
       	}
       	else{

       		$zone = null;

			$region = strtolower($request->region);

			$zones_array = Zones::all();

			foreach ($zones_array['regions'] as $key => $value) {
				foreach ($zones_array['regions'][$key] as  $value) {
					if($value == $region){
						$zone = $key;
						break;
					}
				}
			}
       		
        	return ["success"=>true, "response"=>$zone];
       	}

    	

    }

    public function add_region(Request $request){
	    $validator = Validator::make($request->all(), [
           'region' => 'required|string',
           'zone' => 'required|string',
       	]);
        
       	if($validator->fails()) {
       		return ["success"=>false, "response"=>$validator->messages()->first()];
       	}
       	else{
			$region = strtolower($request->region);
			$zone = strtolower($request->zone);

			// get region array
			$z = Zones::where("name",$zone)->first();

			if(is_null($z)){
				
			}
			else{
				$n = $z->regions;
				array_push($n, "$region");
				$z->update(["regions"=>$n]);
			}

       		
        	return ["success"=>true, "response"=>$z->regions];
       	}    	
    }

    public function remove_region(Request $request){
	    $validator = Validator::make($request->all(), [
	    	'zone' => 'required|string',
           'region' => 'required|string',
       	]);
        
       	if($validator->fails()) {
       		return ["success"=>false, "response"=>$validator->messages()->first()];
       	}
       	else{
			$region = strtolower($request->region);
			$zone = strtolower($request->zone);

			// get region array
			$z = Zones::where("name",$zone)->first();

			if(is_null($z)){
				
			}
			else{
				$n = $z->regions;
				$n = array_merge(array_diff($n, array("$region")));
				$z->update(["regions"=>$n]);
			}

       		
        	return ["success"=>true, "response"=>$z->regions];
       	}    	
    }

}
