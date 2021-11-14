<?php

namespace App\Http\Controllers\RequiredDocs_Creation;

use App\Http\Controllers\Controller;
use App\Models\DriverRegistartionRequestCreation\DriverRegistrationRequestModel;
use App\Models\Required_Docs_Creation\DriverAddressRequiredDocs;
use App\Models\Required_Docs_Creation\DriverKYCRequiredDocsModel;
use App\Models\Required_Docs_Creation\DriverRegistrationRequiredDocsModel;
use App\Models\Required_Docs_Creation\DriverVehicleRequiredDocsModel;
use App\Models\Required_Docs_Creation\RestaurantDetailsRequiredDocsModel;
use App\Models\Required_Docs_Creation\RestaurantOwnerRequiredDocsModel;
use Illuminate\Http\Request;
use Svg\Tag\Rect;

class RequiredDocsController extends Controller
{
    //--------------------------------------------- Driver Registration required Docs -----------------------------------//
    

    //add driver details required docs
    public static function addDriverRegistrationRequiredDocs(Request $request){
        return DriverRegistrationRequiredDocsModel::addDriverRegistrationRequiredDocs($request);
    }

    //add driver address docs list
    public static function addDriverAddressRequiredDocs(Request $request){
        return DriverAddressRequiredDocs::addDriverAddressRequiredDocs($request);
    }

    //add driver kyc docs list
    public static function addDriverKYCRequiredDocs(Request $request){
        return DriverKYCRequiredDocsModel::addDriverKYCRequiredDocs($request);
    }

    //add driver vehicle required docs list
    public static function addDriverVehicleRequiredDocs(Request $request){
        return DriverVehicleRequiredDocsModel::addDriverVehicleRequiredDocs($request);
    }


    // --------------------------------------------  For Restaurant Registration Required Docs ----------------------//

    //add restaurant owner docs details
    public static function addRestaurantOwnerRequiredDocs(Request $request){
        return RestaurantOwnerRequiredDocsModel::addRestaurantOwnerRequiredDocs($request);
    }

    //add restaurant details
    public static function addRestaurantDetailsRequiredDocs(Request $request){
        return RestaurantDetailsRequiredDocsModel::addRestaurantDetailsRequiredDocs($request);
    }



    // ------------------------------------ GET ALL REQUIRED DOCS LIST ---------------------------------//
    public static function getAllRequiredDocsToRegister(Request $request){
        return DriverRegistrationRequiredDocsModel::getAllRequiredDocsToRegister($request);
    }
}
