<?php

namespace App\Models\DriverInfo\DriverDetails;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverLogin extends Model
{
    use HasFactory;

    const driver_login = 'driver_login';
    const driver_id = 'driver_id';
    const api_token = 'api_token';
    const login_status = 'login_status';

    const driver_login_all = self::driver_login . AppConfig::DOT . AppConfig::STAR;
    const driver_driver_id = self::driver_login . AppConfig::DOT . self::driver_id;
    const driver_api_token = self::driver_login . AppConfig::DOT . self::api_token;
    const driver_login_status = self::driver_login . AppConfig::DOT . self::login_status;


    //check driver login session/status 
    public static function checkDriverLoginSession($request){
        // if(self::where(self::api_token,$request[self::api_token])->first()){
        //     return APIResponses::
        // }
        // else{
        //     return APIResponses::failed_result("")
        // }
    }
}
