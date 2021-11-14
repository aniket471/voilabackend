<?php

namespace App\Http\Controllers\Trips_Creation_Module;

use App\Http\Controllers\Controller;
use App\Models\DriverInfo\DriverDetails\DriverDetails;
use App\Models\TripDetails_Modeule\ConformTrips;
use App\Models\TripDetails_Modeule\TripHistory;
use Illuminate\Http\Request;

class ConformTripsController extends Controller
{
    public static function startRide(Request $request){
        return ConformTrips::startTheRide($request);
    }

    public static function endTheRide(Request $request){
        return ConformTrips::endTheRide($request);
    }

    public static function feedBackToDriver(Request $request){
        return ConformTrips::feedBackToDriver($request);
    }

    public static function getADriverRating(Request $request){
        return DriverDetails::getADriverRating($request);
    }
    //for  only test to check the trip status
    public static function checkTripStatus(Request $request){
        return TripHistory::checkTripStatusTripEndOrNot($request);
    }
}
