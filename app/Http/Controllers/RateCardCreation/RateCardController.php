<?php

namespace App\Http\Controllers\RateCardCreation;

use App\Http\Controllers\Controller;
use App\Models\DriverInfo\DriverDetails\DriverRateCard;
use App\Models\RateCards\SystemRateCardModel;
use Illuminate\Http\Request;

class RateCardController extends Controller
{
    //
    public static function getSystemRates(Request $request){
        return SystemRateCardModel::getSystemRates($request);
    }

    public static function createCustomeRateCard(Request $request){
        return DriverRateCard::createCustomeRateCard($request);
    }

    public static function getDriverVehicleInfo(Request $request){
        return DriverRateCard::getDriverVehicleInfo($request);
    }
}
