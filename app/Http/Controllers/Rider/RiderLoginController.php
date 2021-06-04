<?php

namespace App\Http\Controllers\Rider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rider\RiderLogin;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiderLoginController extends Controller
{

    public static function riderLogin(Request $request){
        return RiderLogin::riderLogin($request);
    }
}
