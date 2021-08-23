<?php

namespace App\Http\Controllers\Food_Registartion_Creation;

use App\Http\Controllers\Controller;
use App\Models\DriverRegistartionRequestCreation\DriverRegistrationRequestModel;
use App\Models\Food_Registration_Creation\Food_Dishes_Registartion_Request_Model;
use App\Models\Food_Registration_Creation\Restaurant_Registartion_RequestModel;
use App\Models\RegistrationProcessLogin\RegistrationProcessLoginModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class FoodRegistrationController extends Controller
{


    // -------------------------------- registration process login --------------------------------------//
    
    public static function registrationProcessLogin(Request $request){
        return RegistrationProcessLoginModel::registrationProcessLogin($request);
    }

    public static function verifyOtp(Request $request){
        return RegistrationProcessLoginModel::verifyOtp($request);
    }

    // ------------------------------------------- registration of restaurant ---------------------------------------//

    //adding restaurant owner info
    public static function addNewRestaurantOwner(Request $request){
        return Restaurant_Registartion_RequestModel::addNewRestaurantOwner($request);
    }


    //adding restaurant profile details
    public static function addNewRestaurantProfileInfo(Request $request){
        return Restaurant_Registartion_RequestModel::addNewRestaurantProfileInfo($request);
    }

    public static function addRestaurantProfile(Request $request){
        return Restaurant_Registartion_RequestModel::addRestaurantProfile($request);
    }

    //add new food
    public static function addNewDish(Request $request){
        return Food_Dishes_Registartion_Request_Model::addNewDish($request);
    }

    public static function getAllDishDetails(Request $request){
        return Food_Dishes_Registartion_Request_Model::getAllDishDetails($request);
    }

    //track the registration process
    public static function restaurantRegistrationProcess(Request $request){
        return Restaurant_Registartion_RequestModel::restaurantRegistrationProcess($request);
    }



    // ------------------------------------------  Driver registration Process -------------------------------------//

    //request for driver registration
    public static function addPersonalInformation(Request $request){
        return DriverRegistrationRequestModel::addPersonalInformation($request);
    }

    public static function addAddressDetails(Request $request){
        return DriverRegistrationRequestModel::addAddressDetails($request);
    }

    public static function addKYCDetails(Request $request){
        return DriverRegistrationRequestModel::addKYCDetails($request);
    }

    public static function addVehicleDetails(Request $request){
        return DriverRegistrationRequestModel::addVehicleDetails($request);
    }

    public static function addVehicleProfilePicture(Request $request){
        return DriverRegistrationRequestModel::addVehicleProfilePicture($request);
    }

    //check driver  registration process
    public static function driverRegistrationProcess(Request $request){
        return DriverRegistrationRequestModel::driverRegistrationProcess($request);
    }
}
