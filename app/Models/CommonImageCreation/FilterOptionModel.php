<?php

namespace App\Models\CommonImageCreation;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Food_Registration_Creation\Food_Dishes_Registartion_Request_Model;
use Illuminate\Database\Eloquent\Model;

class FilterOptionModel extends Model
{
    use HasFactory;

    const filter_options = 'filter_options';
    const filter_name = 'filter_name';
    const filter_type = 'filter_type';
    const status = 'status';

    const filter_options_all = self::filter_options . AppConfig::DOT . AppConfig::STAR;
    const filter_filter_name = self::filter_options . AppConfig::DOT . self::filter_name;
    const filter_filter_type = self::filter_options . AppConfig::DOT . self::filter_type;
    const filter_status = self::filter_options . AppConfig::DOT . self::status;

    protected $table = self::filter_options;
    protected $fillable = [
        self::filter_name,
        self::filter_type,
        self::status
    ];

    public $timestamps = false;

    //add new filter option
    public static function addNewFilterOptions($request){

        $filter_option = new self();

        $filter_option[self::filter_name] = $request[self::filter_name];
        $filter_option[self::filter_type] = $request[self::filter_type];
        $filter_option[self::status] = 1;

        $result = $filter_option->save();
        
        if($result) return APIResponses::success_result("New Filter Addedd Successfully");
        else return APIResponses::failed_result("New Filter Option Not Addedd Failed");
    }

    //get All Filter Option
    public static function getAllFilterOption(){

        $filter_option = self::all();

        if(!empty($filter_option)){
            return APIResponses::success(
                "Filter options available",
                "filterOptions",
                $filter_option
            );
        }
        else return APIResponses::failed_result("Current not any filter available,Please try again");
    }

//get dish from selected filter options
    public static function getDishWithFilter($request){

        $veg = "veg";
        $non_veg = "non veg";
        $new = "new";
        $old = "old";

        if(strtolower($veg) === strtolower($request[self::filter_type])){
            return Food_Dishes_Registartion_Request_Model::getAllVegDish($request);
        }
        elseif(strtolower($non_veg) === strtolower($request[self::filter_type])){
            return Food_Dishes_Registartion_Request_Model::getAllVegDish($request);
        }
        elseif(strtolower($new) === strtolower($request[self::filter_type])){
            return Food_Dishes_Registartion_Request_Model::getNewestDish($request);
        }
        elseif(strtolower($old) === strtolower($request[self::filter_type])){
            return Food_Dishes_Registartion_Request_Model::getAllOldestDishes($request);
        }
        else return APIResponses::failed_result("Filter option missMatch");
    }
}
