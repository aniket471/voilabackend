<?php

namespace App\Http\Controllers\DriverInfo\TripDetails_Module;

use App\Http\Controllers\Controller;
use App\Models\TripDetails_Modeule\TripAcceptCustomeCard;
use App\Models\TripDetails_Modeule\TripAcceptRateCard;
use App\Models\TripDetails_Modeule\TripDetails;
use Illuminate\Http\Request;

class TripDetailController extends Controller
{


    //accept trip first time means its temp accept
    public static function acceptTripForTemp(Request $request){
        return TripDetails::acceptTripForTemp($request);
    }

    public static function acceptBookingWithRateCard(Request $request){
        return TripAcceptRateCard::acceptBookingWithRateCard($request);
    }

    public static function acceptBookingWithCustomCard(Request $request){
        return TripAcceptCustomeCard::acceptBookingWithCustomCard($request);
    }

     //check new trip for driver 
    public static function checkTheTripStatus(Request $request){
        return TripDetails::checkTheTripStatus($request);
    }
}
