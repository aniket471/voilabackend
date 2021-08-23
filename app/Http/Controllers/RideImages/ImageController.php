<?php

namespace App\Http\Controllers\RideImages;

use App\Http\Controllers\Controller;
use App\Models\RideImages\RiderImageModel;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    //
    public static function storeRideImage(Request $request){
        return RiderImageModel::storeRideImage($request);
    }
    
    //get image
    public static function getImage(Request $request){
        return RiderImageModel::getImage($request);
    }
}
