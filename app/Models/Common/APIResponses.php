<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APIResponses extends Model
{
    use HasFactory;
    public static $success_0_data_missing = ["success"=>0,"msg"=>'Required Data missing'];
    public static $success_0_unauthorised_access = ["success"=>0,"msg"=>'Unauthorised Access'];
    public static $success_0_Invalid_credentials = ["success"=>0,"msg"=>'Invalid username or password'];
    public static $success_0_AC_doesnt_exists = ["success"=>0,"msg"=>'Your account doesn\'t exist'];
    public static $success_0_something_went_wrong = ["success"=>0,"msg"=>'Something went wrong'];
    public static $success_2_cant_lock = ["success"=>2,"msg"=>"Can't lock this unit"];

    public static function success_1($data){
        return ["success"=>1,"data"=>$data];
    }
    public static function success_0(){
        return ["success"=>0,"data"=>[]];
    }
    public static function success_0_custom_msg($msg){
        return ["success"=>0,"msg"=>$msg];
    }
    public static function success_custom_msg($success,$msg){
        return ["success"=>$success,"msg"=>$msg];
    }
    public static function success_result($message){
        return ["result"=>true , "message"=>$message];
    }
    public static function failed_result($message){
        return ["result"=>false , "message"=>$message];
    }
    public static function success_result_with_data($message,$data){
        return ["result"=>true , "message"=>$message,"resultData"=>$data];
    }
    public static function failed_result_with_data($message,$data){
        return ["result"=>false , "message"=>$message,"resultData"=>$data];
    }
    
    public static function success_result_with_code($message,$code){
        return ["result"=>true,"message"=>$message,"resultCode"=>$code];
    }

    public static function failed_result_with_code($message,$code){
        return ["result"=>false,"message"=>$message,"resultCode"=>$code];
    }
 public static function success($message,$dataMSG,$data){
        return ["result"=>true,"message"=>$message,$dataMSG=>$data];
    }
}