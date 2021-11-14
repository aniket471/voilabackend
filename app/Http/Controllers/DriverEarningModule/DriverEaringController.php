<?php

namespace App\Http\Controllers\DriverEarningModule;

use App\Http\Controllers\Controller;
use App\Models\TripDetails_Modeule\TripHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverEaringController extends Controller
{
    public static function getWeeklyReport(Request $request)
    {
        return TripHistory::getDriverWeeklyEaring($request);
    }

    public static function getMonthWiseEarning(Request $request){
        return TripHistory::getMonthWiseEarning($request);
    }
}
