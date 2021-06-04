<?php

namespace App\Http\Controllers\DriverInfo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DriveInfo\DriverInfoModel;

class DriverInfoandDocController extends Controller
{
    public function driverRegistrations(Request $request){
        $phone_number = $request->input('phone_number');
        $email = $request->input('email');
        $current_address = $request->input('current_address');
        $vehicle_reg_number = $request->input('vehicle_reg_number');
        $rc = $request->input('rc');
        $vehicle_color = $request->input('vehicle_color');
        $vehicle_model = $request->input('vehicle_model');
        $make_year = $request->input('make_year');
        $vehicle_type = $request->input('vehicle_type');
    
        return DriverInfoModel::driverRegistration($request);
    }
}
