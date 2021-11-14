<?php

namespace App\Models\Food_Registration_Creation;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequiredDishDocsModel extends Model
{
    use HasFactory;

    const required_dish_docs = 'required_dish_docs';
    const required_docs_name = 'required_docs_name';
    const required_docs_type = 'required_docs_type';
    const status = 'status';

    const required_dish_docs_all = self::required_dish_docs . AppConfig::DOT . AppConfig::STAR;
    const required_required_docs_name = self::required_dish_docs . AppConfig::DOT . self::required_docs_name;
    const required_required_docs_type = self::required_dish_docs . AppConfig::DOT . self::required_docs_type;
    const required_status = self::required_dish_docs . AppConfig::DOT . self::status;

    protected $table = self::required_dish_docs;
    protected $fillable = [
        self::required_docs_name,
        self::required_docs_type,
        self::status
    ];

    public $timestamps = false;

    //add new dish required doc
    public static function addDishDoc($request){

        $newDoc = new self();

        $newDoc[self::required_docs_name] = $request[self::required_docs_name];
        $newDoc[self::required_docs_type] = $request[self::required_docs_type];
        $newDoc[self::status] = 1;

        $result = $newDoc->save();

        if($result) return APIResponses::success_result("New Required Docs Addedd Successfully");
        else return APIResponses::failed_result("New Docs not addedd");
    }

    //get type text docs
    public static function getDishRequiredDocs(){
        $docsData = self::all();

        if(!empty($docsData))
        return APIResponses::success_result_with_data("Required Docs find",$docsData);
        else
        return APIResponses::failed_result("Required Docs Not Find");
    }
}
