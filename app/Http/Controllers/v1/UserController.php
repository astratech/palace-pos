<?php

/**
 * User Controller for Fimiti
 * @author Sangosanya Segun - Flamezbaba <flamezbaba@gmail.com>
 * @version 1.0
**/

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Users;
Use App\Site;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller{

	public function index(){
        return Users::all();
    }

 	/**
     * Return the records of a user
     *
     * @param  string             $username
     * @return JSON
    */
    public function show($username){
    	$user = Users::where("username", $username)->first();
    	if(is_null($user)){
    		return ["success"=>false, "response"=>"user not found"];
    	}
    	else{
    		return ["success"=>truw, "response"=>$user];
    	}
    }

    public function demo(Request $request){

    }

    /**
     * Create user account
     *
     * @param  string             $email
     * @param  string             $username
     * @param  string             $fullname
     * @param  string             $mobile
     * @param  string             $password
     * @param  string             $account_type
     * @return json - user data
    */
    public function create(Request $request){
    	// dd($request->all());
    	
    	$validator = Validator::make($request->all(), [
           'email' => 'required|email|unique:users',
           'username' => 'required|string|unique:users',
           'fullname' => 'required|string',
           'mobile' => 'required|numeric',
           'password' => 'required|string',
           'account_type' => 'required|string',
       	]);
        
       	if($validator->fails()) {
       		return ["success"=>false, "response"=>$validator->messages()->first()];
       	}
       	else{
       		$request->merge([ 
                'password' => Site::encode_password($request->password), 
            ]);

       		$data = Site::fil_request($request->all(), "password");
       		// dd($data);
       		// exit();
    		$r = Users::create($data);

    		$r_data = [
    			"email"=>$r->email,
    			"username"=>$r->username,
    			"fullname"=>$r->fullname,
    			"mobile"=>$r->mobile,
    			"account_type"=>$r->account_type,
    		];

        	return ["success"=>true, "response"=>$r_data];
       	}
    }

    /**
     * update user records - PUT
     *
     * @param  string             $email
     * @param  string             $username
     * @param  string             $fullname
     * @param  string             $mobile
     * @param  string             $password
     * @param  string             $account_type
     * @return json - user data
    */
    public function update(Request $request, $id){
    	
    	$validator = Validator::make($request->all(), [
           'email' => 'email|unique:users',
           'username' => 'string|unique:users',
           'fullname' => 'string',
           'mobile' => 'numeric',
           'password' => 'string',
           'account_type' => 'string',
       	]);
        
       	if($validator->fails()) {
       		return ["success"=>false, "response"=>$validator->messages()->first()];
       	}
       	else{
       		$request->merge([ 
                'password' => Site::encode_password($request->password), 
            ]);

       		$data = Site::fil_request($request->all(), "password");
       		// dd($data);
       		// exit();
    		$r = Users::create($data);

    		$r_data = [
    			"email"=>$r->email,
    			"username"=>$r->username,
    			"fullname"=>$r->fullname,
    			"mobile"=>$r->mobile,
    			"account_type"=>$r->account_type,
    		];

        	return ["success"=>true, "response"=>$r_data];
       	}

        $p = Users::findOrFail($id);
        $p->update($request->all());

        return $p;
    }

    public function delete(Request $request, $id){
        $p = Users::findOrFail($id);
        $p->delete();

        return 204;
    }
}
