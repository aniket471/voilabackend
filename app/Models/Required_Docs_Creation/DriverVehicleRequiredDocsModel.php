<?php

namespace App\Models\Required_Docs_Creation;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverVehicleRequiredDocsModel extends Model
{
    use HasFactory;
    const  driver_vehicle_details_required_docs    = 'driver_vehicle_details_required_docs';
    const required_docs_name = 'required_docs_name';
    const required_docs_type = 'required_docs_type';
    const status = 'status';

    const driver_vehicle_details_required_docs_all = self:: driver_vehicle_details_required_docs  . AppConfig::DOT . AppConfig::STAR;
    const driver_required_docs_name = self:: driver_vehicle_details_required_docs  . AppConfig::DOT . self::required_docs_name;
    const driver_required_docs_type = self:: driver_vehicle_details_required_docs  . AppConfig::DOT . self::required_docs_type;
    const driver_status = self:: driver_vehicle_details_required_docs  . AppConfig::DOT . self::status;

    protected $table = self:: driver_vehicle_details_required_docs;
    protected $fillable = [
        self::required_docs_name,
        self::required_docs_type,
        self::status
    ];

    public $timestamps = false;

       //add docs
       public static function addDriverVehicleRequiredDocs($request){

        $addNewDocs = new self();
        $addNewDocs[self::required_docs_name] = $request[self::required_docs_name];
        $addNewDocs[self::required_docs_type] = $request[self::required_docs_type];
        $addNewDocs[self::status] = 1;

        $result = $addNewDocs->save();
        if($result) return APIResponses::success_result("Document Added..");
        else return APIResponses::failed_result("Document Not Addedd . Please try again");
    }

    //get docs
    public static function getDriverVehicleRequiredDocs(){

        return self::all();
    }

//get docs by text type
    public static function getDocsByTextType(){
       return $docs = self::select(self::required_docs_name,self::required_docs_type)->where(self::required_docs_type,"!=", "image")->get();
    }

    //get docs by image type
    public static function getDocsByImageType(){
        return $docs =self::select(self::required_docs_name,self::required_docs_type)->where(self::required_docs_type,"image")->get();
    }
}
