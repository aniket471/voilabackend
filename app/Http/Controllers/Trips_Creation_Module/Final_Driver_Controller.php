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
}
