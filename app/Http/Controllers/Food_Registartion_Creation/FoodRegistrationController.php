<?php

namespace App\Http\Controllers\Food_Registartion_Creation;

use App\Http\Controllers\Controller;
use App\Models\DriverRegistartionRequestCreation\DriverRegistrationRequestModel;
use App\Models\Food_Registration_Creation\Food_Dishes_Registartion_Request_Model;
use App\Models\Food_Registration_Creation\RequiredDishDocsModel;
use App\Models\Food_Registration_Creation\Restaurant_Registartion_RequestModel;
use App\Models\RegistrationProcessLogin\RegistrationProcessLoginModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Contracts\Service\Attribute\Required;

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


    //restaurant account verification 
    public static function isRestaurantAccountVerify(Request $request){

        return Restaurant_Registartion_RequestModel::isAccountVerifyOrNot($request);
    }

    //get requested all information
    public static function getAllRestaurantRequestedInfo(Request $request){
        return Restaurant_Registartion_RequestModel::getAllRestaurantRequestedInfo($request);
    }


    // get all dish/menu
    public static function getAllMenus(Request $request){
        return Food_Dishes_Registartion_Request_Model::getAllMenus($request);
    }

  //update restaurant owner info
    public static function updateResaturantOwnerInformation(Request $request){
        return Restaurant_Registartion_RequestModel::updateResaturantOwnerInformation($request);
    }

     //update restaurant information before account verification
     public static function updateRestaurantInformation(Request $request){
         return Restaurant_Registartion_RequestModel::updateRestaurantInformation($request);
     }

        //update restaurant documnet
    public static function updateRestaurantProfile(Request $request){
        return Restaurant_Registartion_RequestModel::updateRestaurantProfile($request);
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

    public static function addDriverVehicleDetails(Request $request){
        return DriverRegistrationRequestModel::addDriverVehicleDetails($request);
    }

    public static function addVehicleProfilePicture(Request $request){
        return DriverRegistrationRequestModel::addVehicleProfilePicture($request);
    }

    //check driver  registration process
    public static function driverRegistrationProcess(Request $request){
        return DriverRegistrationRequestModel::driverRegistrationProcess($request);
    }

    //to update the menu list
    public static function updateDishInfo(Request $request){
        return Food_Dishes_Registartion_Request_Model::updateDishInfo($request);
    }

    //get all driver information before account is verify
    public static function getAllRequestedInfo(Request $request){
        return DriverRegistrationRequestModel::getAllRequestedInfo($request);
    }

  public static function updatePersonalInformation(Request $request){
        return DriverRegistrationRequestModel::updatePersonalInformation($request);
    }

    public static function updateAddressInformation(Request $request){
        return DriverRegistrationRequestModel::updateAddressInformation($request);
    }

    public static function updateVehicleInformation(Request $request){
        return DriverRegistrationRequestModel::updateVehicleInformation($request);
    }

    public static function updateKYCDetails(Request $request){
        return DriverRegistrationRequestModel::updateKYCDetails($request);
    }

    public static function updateVehicleDocument(Request $request){
        return DriverRegistrationRequestModel::updateVehicleDocument($request);
    }

    // -------------------------------------------- Dish Required Docs ------------------------------------//

    //to add new dish docs
    public static function addNewDishDocs(Request $request){
        return RequiredDishDocsModel::addDishDoc($request);
    }

    //to get all dish docs
    public static function getDishRequiredDocs(){
        return RequiredDishDocsModel::getDishRequiredDocs();
    }

      //remove the dish
     public static function removeDishFromRestaurant(Request $request){
        return Food_Dishes_Registartion_Request_Model::removeDishFromRestaurant($request);
    }

    public static function getKYCRequestdInfo(Request $request){
        return DriverRegistrationRequestModel::getKYCRequestdInfor($request);
    }
 // used for dash-board side
    public static function getRestaurantProfilePic(Request $request){
        return Restaurant_Registartion_RequestModel::getRestaurantProfilePic($request);
    }
}
