<?php

namespace App\Http\Controllers\Trips_History_Module;

use App\Http\Controllers\Controller;
use App\Models\TripDetails_Modeule\TripHistory;
use Illuminate\Http\Request;

class TripHistoryController extends Controller
{
    public static function generatePDF(Request $request){
        return TripHistory::generatePDF($request);
    }

    public static function downloadPDf(Request $request){
        return TripHistory::downloadPDf($request);
    }
}
