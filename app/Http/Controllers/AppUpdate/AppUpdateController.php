<?php

namespace App\Http\Controllers\AppUpdate;

use App\Http\Controllers\Controller;
use App\Models\AppUpdate\AppUpdateModel;
use Illuminate\Http\Request;

class AppUpdateController extends Controller
{
    //
    public static function addNewBuild(Request $request){
        return AppUpdateModel::addNewBuild($request);
    }
}
