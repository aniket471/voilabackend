<?php

namespace App\Models\Required_Docs_Creation;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Auth\Events\Failed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverRegistrationRequiredDocsModel extends Model
{
    use HasFactory;
    
    const driver_registration_required_docs = 'driver_registration_required_docs';
    const required_docs_name = 'required_docs_name';
    const required_docs_type = 'required_docs_type';
    const status = 'status';

    const driver_registration_required_docs_all = self::driver_registration_required_docs . AppConfig::DOT . AppConfig::STAR;
    const driver_required_docs_name = self::driver_registration_required_docs . AppConfig::DOT . self::required_docs_name;
    const driver_required_docs_type = self::driver_registration_required_docs . AppConfig::DOT . self::required_docs_type;
    const driver_status = self::driver_registration_required_docs . AppConfig::DOT . self::status;

    protected $table = self::driver_registration_required_docs;
    protected $fillable = [
        self::required_docs_name,
        self::required_docs_type,
        self::status
    ];

    public $timestamps = false;

    //add docs
    public static function addDriverRegistrationRequiredDocs($request){

        $addNewDocs = new self();
        $addNewDocs[self::required_docs_name] = $request[self::required_docs_name];
        $addNewDocs[self::required_docs_type] = $request[self::required_docs_type];
        $addNewDocs[self::status] = 1;

        $result = $addNewDocs->save();
        if($result) return APIResponses::success_result("Document Added..");
        else return APIResponses::failed_result("Document Not Addedd . Please try again");
    }

    //get docs
    public static function getDriverRequiredDocs(){

        return self::select(self::required_docs_name,self::required_docs_type)->where(self::status,1)->get();
    }

    //get all required Documents
    public static function getAllRequiredDocsToRegister($request){

        if(!empty($request['title'])){

            if($request['title'] === 'Driver'){
               return self::getAllDriverRequiredDocs();
            }
            else if($request['title'] === 'Restaurant'){
               return self::getAllRestaurantRequiredDocs();
            }
            else return APIResponses::failed_result("Title mismatch please provide right title");
        }
        else return APIResponses::failed_result("Please provide a title");
    }

    //get all driver registration required docs
    public static function getAllDriverRequiredDocs(){

        $driverRegistrationDetails = self::getDriverRequiredDocs();
        $driverAddressDocsDetails = DriverAddressRequiredDocs::getDriverAddressRequiredDocs();
        $driverKYCDocsDetails = DriverKYCRequiredDocsModel::getDriverKYCRequiredDocs();
        $driverVehicleDetails = DriverVehicleRequiredDocsModel::getDriverVehicleRequiredDocs();

        $data = ["driver_details_required_docs"=>$driverRegistrationDetails,"driver_address_required_docs"=>$driverAddressDocsDetails,
                 "driver_kyc_required_docs"=>$driverKYCDocsDetails, "driver_vehicle_required_docs"=>$driverVehicleDetails];

        $msg = "For Driver Registration Required Document";
       return response()->json([$response = "result"=>true ,"message"=>$msg,"requiredDocs"=>array($data)]);

    }

    //get all restaurant required docs
    public static function getAllRestaurantRequiredDocs(){


        $restaurantOwnerRequiredDocs = RestaurantOwnerRequiredDocsModel::getRestaurantOwnerRequiredDocs();
        $restaurantDetailsRequiredDocs = RestaurantDetailsRequiredDocsModel::getRestaurantDetailsRequiredDocs();

        $msg = "For Restaurant Registration Required Document";

        $data = ["restaurant_owner_required_docs"=>$restaurantOwnerRequiredDocs,"restaurant_details_required_docs"=>$restaurantDetailsRequiredDocs];

        return response()->json([$response = "result"=>true ,"message"=>$msg,"requiredDocs"=>array($data)]);
 
    }
}
