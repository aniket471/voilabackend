<?php

namespace App\Http\Controllers\Trips_Creation_Module;

use App\Http\Controllers\Controller;
use App\Models\TripDetails_Modeule\Pre_Confom_Trips;
use Illuminate\Http\Request;

class Final_Driver_Controller extends Controller
{
    //rider select driver to start a trip from hole driverList
    public static function selectDriverToTrip(Request $request){
        return Pre_Confom_Trips::selectDriverToTrip($request);
    }

    //enable to driver for this trip 
    public static function enableTripToSelectedDriver(Request $request){
        return Pre_Confom_Trips::enableTripToSelectedDriver($request);
    }

    public static function generateTheOtpToVerifyTheDriver(Request $request){
        return Pre_Confom_Trips::generateTheOtpToVerifyTheDriver($request);
    }

 //update the driver location after trip is enable to driver (Driver site)
    public static function updateDriverLocation(Request $request){
        return Pre_Confom_Trips::updateDriverLocation($request);
    }

    //get driver location when trip is enable to driver (Rider site)
    public static function getDriverUpdatedLocation(Request $request){
        return Pre_Confom_Trips::getDriverUpdatedLocation($request);
    }


    //verify the driver by otp
    public static function verifyDriver(Request $request){
        return Pre_Confom_Trips::verifyDriver($request);
    }
}
