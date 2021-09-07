<?php

namespace App\Models\Required_Docs_Creation;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantDetailsRequiredDocsModel extends Model
{
    use HasFactory;

    const   restaurant_details_required_docs    = 'restaurant_details_required_docs';
    const required_docs_name = 'required_docs_name';
    const required_docs_type = 'required_docs_type';
    const required_docs_input = 'required_docs_input';
    const status = 'status';

    const restaurant_owner_required_docs_all = self:: restaurant_details_required_docs   . AppConfig::DOT . AppConfig::STAR;
    const restaurant_required_docs_name = self:: restaurant_details_required_docs   . AppConfig::DOT . self::required_docs_name;
    const restaurant_required_docs_type = self:: restaurant_details_required_docs   . AppConfig::DOT . self::required_docs_type;
    const restaurant_required_docs_input = self::restaurant_details_required_docs . AppConfig::DOT . self::required_docs_input;
    const restaurant_status = self:: restaurant_details_required_docs   . AppConfig::DOT . self::status;

    protected $table = self:: restaurant_details_required_docs ;
    protected $fillable = [
        self::required_docs_name,
        self::required_docs_type,
        self::required_docs_input,
        self::status
    ];

    public $timestamps = false;

       //add docs
       public static function addRestaurantDetailsRequiredDocs($request){

        $addNewDocs = new self();
        $addNewDocs[self::required_docs_name] = $request[self::required_docs_name];
        $addNewDocs[self::required_docs_type] = $request[self::required_docs_type];
        $addNewDocs[self::status] = 1;

        $result = $addNewDocs->save();
        if($result) return APIResponses::success_result("Document Added..");
        else return APIResponses::failed_result("Document Not Addedd . Please try again");
    }

    //get docs
    public static function getRestaurantDetailsRequiredDocs(){

        return self::all();
    }




    //get only image type docs
    public static function getAllRestaurantDocsByTypeImg(){

        return self::select(self::required_docs_name,self::required_docs_type)->where(self::required_docs_type,"image")->get();
    }

    //get only type text docs
    public static function getTextTypeDocs(){
        return self::select(self::required_docs_name,self::required_docs_type,self::required_docs_input)
                    ->where(self::required_docs_type,"!=","image")
                    ->get();    
    }
}
