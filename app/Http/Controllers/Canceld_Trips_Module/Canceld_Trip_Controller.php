<?php

namespace App\Http\Controllers\Canceld_Trips_Module;

use App\Http\Controllers\Controller;
use App\Models\Canceld_Trips_Model\Canceld_Trips_Model;
use Illuminate\Http\Request;

class Canceld_Trip_Controller extends Controller
{
    
    public  function canceledTrip(Request $request){
     return Canceld_Trips_Model::canceledTrip($request);
    }
}
