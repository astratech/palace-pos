<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Schema;
use DB;

// session_start();
class Site extends Model{
  

    public static function fil_email($str){
        $val = preg_replace("/[^A-Za-z0-9_.-@]/", "", $str);
        $val = strtolower($val);
        return $val;
    }
 
    public static function fil_num($str){
        $val = preg_replace("/[^0-9+.]/", "", $str);
        return $val;
    }

    public static function fil_text($str){
        $val = preg_replace("/[^A-Za-z0-9,_.\-@() ]/", "", $str);
        $val = strtolower($val);
        return $val;
    }
    
    public static function fil_special($str){
        $val = preg_replace("/[^A-Za-z0-9,_.\-@() ]/", "", $str);
        return $val;
    }

    public static function fil_string($str){
        $val = preg_replace("/[^A-Za-z0-9_.\-]/", "", $str);
        $val = strtolower($val);
        return $val;
    }

    public static function fil_password($str){
        $val = preg_replace("/[^A-Za-z0-9_.\-@!#$%&*() ]/", "", $str);
        return $val;
    }
    
    public static function encode_password($t) {
        $a = "677HHge";
        $b = "lopjdhg";
        //encode pass
        $r = base64_encode($t);
        //add pre salt
        $r = $a.$r;
        return $r;
    }

    public static function decode_password($t) {
        $r = substr($t, 7);
        $r = base64_decode($r);
        return $r;
    }

    public static function gen_uq_id($txt) {
        // $a = uniqid();
        $a = mt_rand(9000,9000000);
        $r = $txt.substr(str_shuffle($a),0, 4);
        return strtoupper($r);
    }

    public static function gen_token() {
        $a = mt_rand(9000,9000000);
        $r = substr(str_shuffle($a),0, 6);
        return strtoupper($r);
    }

    public static function fil_request($in, $except = null) {
        if(is_array($in)){
            $filtered = [];
            foreach ($in as $key => $value) {
                $k = strtolower($key);


                if(!is_array($value)){

                    // get exceptions
                    if($k != $except){
                        $v = strtolower($value);
                       
                    }
                    else{
                        $v = $value;
                    }

                     $filtered[$k] = $v;
                }
                else{
                    // level 2 array
                    $k = strtolower($key);
                    foreach ($value as $ky => $vl) {
                        $k1 = strtolower($ky);
                        $v1 = strtolower($vl);

                        $filtered[$k][$k1] = $v1;
                    }

                }
                
            }

            return $filtered;
        }
        else{
            return null;
        }
    }

}
