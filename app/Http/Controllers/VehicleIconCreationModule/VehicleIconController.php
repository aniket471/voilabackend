<?php

namespace App\Http\Controllers\VehicleIconCreationModule;

use App\Http\Controllers\Controller;
use App\Models\VehicleIconCreationModule\VehicleIconModel;
use Illuminate\Http\Request;

class VehicleIconController extends Controller
{
    //
    public static function storeVehicleTypeWiseImage(Request $request){
        return VehicleIconModel::storeVehicleTypeWiseImage($request);
    }

    //get vehicle wise image
    public static function getVehicleTypeWiseImage(Request $request){
        return VehicleIconModel::getVehicleTypeWiseImage($request);
    }
}
