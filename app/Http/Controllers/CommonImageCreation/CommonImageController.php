<?php

namespace App\Http\Controllers\CommonImageCreation;

use App\Http\Controllers\Controller;
use App\Models\CommonImageCreation\CommanImageModel;
use App\Models\CommonImageCreation\FilterOptionModel;
use Illuminate\Http\Request;

class CommonImageController extends Controller
{
    //add common image
    public static function addCommonImage(Request $request){
        return CommanImageModel::addCommonImage($request);
    }

    //get account under review image
    public static function getCommonImageForAccountUnderReview(){
        return CommanImageModel::getCommonImageForAccountUnderReview();
    }


    // --------------------  FILTER OPTIONS ------------------------------- //
    
    //add filter  option
    public static function addNewFilterOptions(Request $request){
        return FilterOptionModel::addNewFilterOptions($request);
    }

    //get all filter option
    public static function getAllFilterOption(){
        return FilterOptionModel::getAllFilterOption();
    }
    //get dish with filter option
    public static function getDishWithFilter(Request $request){
        return FilterOptionModel::getDishWithFilter($request);
    }
}
