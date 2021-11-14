<?php

namespace App\Models\Required_Docs_Creation;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantOwnerRequiredDocsModel extends Model
{
    use HasFactory;

    const  restaurant_owner_required_docs    = 'restaurant_owner_required_docs';
    const required_docs_name = 'required_docs_name';
    const required_docs_type = 'required_docs_type';
    const status = 'status';

    const restaurant_owner_required_docs_all = self:: restaurant_owner_required_docs   . AppConfig::DOT . AppConfig::STAR;
    const restaurant_required_docs_name = self:: restaurant_owner_required_docs   . AppConfig::DOT . self::required_docs_name;
    const restaurant_required_docs_type = self:: restaurant_owner_required_docs   . AppConfig::DOT . self::required_docs_type;
    const restaurant_status = self:: restaurant_owner_required_docs   . AppConfig::DOT . self::status;

    protected $table = self:: restaurant_owner_required_docs ;
    protected $fillable = [
        self::required_docs_name,
        self::required_docs_type,
        self::status
    ];

    public $timestamps = false;

       //add docs
       public static function addRestaurantOwnerRequiredDocs($request){

        $addNewDocs = new self();
        $addNewDocs[self::required_docs_name] = $request[self::required_docs_name];
        $addNewDocs[self::required_docs_type] = $request[self::required_docs_type];
        $addNewDocs[self::status] = 1;

        $result = $addNewDocs->save();
        if($result) return APIResponses::success_result("Document Added..");
        else return APIResponses::failed_result("Document Not Addedd . Please try again");
    }

    //get docs
    public static function getRestaurantOwnerRequiredDocs(){

        return self::all();
    }
}
