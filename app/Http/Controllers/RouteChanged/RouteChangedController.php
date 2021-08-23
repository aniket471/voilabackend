<?php

namespace App\Http\Controllers\RouteChanged;

use App\Http\Controllers\Controller;
use App\Models\RouteChangedModeule\RouteChangeRequestModel;
use App\Models\TripDetails_Modeule\TripHistory;
use Illuminate\Http\Request;

class RouteChangedController extends Controller
{
    public static function getMidLatLng(Request $request){
        return TripHistory::getMidLatLng($request);
    }

    public static function requestToChangedRoute(Request $request){
        return RouteChangeRequestModel::requestToChangedRoute($request);
    }

    public static function checkTheRouteChangeRequest(Request $request){
        return RouteChangeRequestModel::checkTheRouteChangeRequest($request);
    }

    public static function acceptTheChangeRouteRequest(Request $request){
        return RouteChangeRequestModel::acceptTheChangeRouteRequest($request);
    }
}
