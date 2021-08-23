<?php

namespace App\Http\Controllers\Rider\RiderTrip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rider\RiderTripLocation;
use App\Models\DriverInfo\DriverLocation\DriverLocation;
use App\Models\DriverInfo\DriverLocation\DriverVehicles;
use App\Models\Rider\RiderPickupLocation;
use App\Models\TripDetails_Modeule\TripAcceptRateCard;

class RiderTripLocationController extends Controller
{
    //update the driver location continuously need driverid,currentLat,currentLng,currentAddress
    public function driverCurrentLocation(Request $request){
        return DriverLocation::insertTheCurrentLatLngForDriver($request);
    }
    public function findTheDriverBetweenRadius(Request $request){
        return DriverLocation::findTheDriver($request);
    }

    public function getAllVehicleAndRates(Request $request){
        return DriverVehicles::getAllVehicleWithRate($request);
    }

    //show a all drivers when rider select a global vehicle . all driver should be in 5km radius
    public function showAllDriver(Request $request){
        return DriverLocation::showAllDriver($request);
    }

    public function tripAcceptedDriver(Request $request)
    {
        return TripAcceptRateCard::tripAcceptedDriver($request);
    }

    //update a rider current/pickup location continuously
    public static function updateRiderLocationContinuously(Request $request){
        return RiderPickupLocation::updateRiderLocationContinuously($request);
    }
}
