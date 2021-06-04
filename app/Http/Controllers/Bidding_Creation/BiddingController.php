<?php

namespace App\Http\Controllers\Bidding_Creation;

use App\Http\Controllers\Controller;
use App\Models\Bidding_Creation\Bidding;
use Illuminate\Http\Request;

class BiddingController extends Controller
{
    public static function driverLowestPrice(Request $request){
        return Bidding::driverLowestPrice($request);
    }

    public static function getDriversWithBiddingCurrentPrice(Request $request){
        return Bidding::getDriversWithBiddingCurrentPrice($request);
    }

    public static function refreshTheBiddingPrice(Request $request){
        return Bidding::refreshTheBiddingPrice($request);
    }
}
