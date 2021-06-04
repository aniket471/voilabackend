<?php

namespace App\Http\Controllers\Rider\RiderTrip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rider\RiderTripLocation;
use App\Models\DriverInfo\DriverLocation\DriverLocation;
use App\Models\DriverInfo\DriverLocation\DriverVehicles;
use App\Models\TripDetails_Modeule\TripAcceptRateCard;

class RiderTripLocationController extends Controller
{
    public function driverCurrentLocation(Request $request){
        return DriverLocation::insertTheCurrentLatLngForDriver($request);
    }
    public function findTheDriverBetweenRadius(Request $request){
        return DriverLocation::findTheDriver($request);
    }

    public function getAllVehicleAndRates(Request $request){
        return DriverVehicles::getAllVehicleWithRate($request);
    }

    public function showAllDriver(Request $request){
        return DriverLocation::showAllDriver($request);
    }

    public function tripAcceptedDriver(Request $request)
    {
        return TripAcceptRateCard::tripAcceptedDriver($request);
    }
}
