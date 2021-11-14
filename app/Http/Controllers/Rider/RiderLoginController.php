<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rider\RiderLogin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class RiderLoginController extends Controller
{

    public static function riderLogin(Request $request){
        return RiderLogin::riderLogin($request);
    }

    public static function verifyTheOtp(Request $request){
      return RiderLogin::verifyTheOtp($request);
    }
  public static function checkUserLoginSession(Request $request){
      return RiderLogin::checkUserLoginSession($request);
    }

}
