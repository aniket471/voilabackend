<?php

namespace App\Models\RateCards;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use App\Models\DriverInfo\DriverDetails\DriverDetails;
use App\Models\DriverRegistartionRequestCreation\DriverRegistrationRequestModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class SystemRateCardModel extends Model
{
    use HasFactory;

    const system_rates = 'system_rates';
    const min_rate = 'min_rate';
    const max_rate = 'max_rate';
    const canceled_trip_limit = 'canceled_trip_limit';
    const global_vehicle_id = 'global_vehicle_id';
    const vehicle_type = 'vehicle_type';

    const system_rates_all = self::system_rates . AppConfig::DOT . AppConfig::STAR;
    const system_min_rate = self::system_rates . AppConfig::DOT . self::min_rate;
    const system_max_rate = self::system_rates . AppConfig::DOT . self::max_rate;
    const system_canceled_trip_limit = self::system_rates . AppConfig::DOT . self::canceled_trip_limit;
    const system_global_vehicle_id = self::system_rates . AppConfig::DOT . self::global_vehicle_id;
    const system_vehicle_type = self::system_rates . AppConfig::DOT . self::vehicle_type;

    protected $table = self::system_rates;
    protected $fillable= [

        self::min_rate,
        self::max_rate,
        self::canceled_trip_limit,
        self::global_vehicle_id,
        self::vehicle_type
    ];


    // get system rates
    public static function getSystemRates($request){

        $validator = Validator::make($request->all(), [
            "auth_token" => 'required'
        ]);

        if ($validator->fails()) {

            return APIResponses::failed_result("Oops system rate card is currently not available for you");
        }
        else{

            if(DriverRegistrationRequestModel::where(DriverRegistrationRequestModel::request_token, $request["auth_token"])->first()){

               $data = DriverRegistrationRequestModel::select(DriverRegistrationRequestModel::vehicle_type,
                                                               DriverRegistrationRequestModel::vehicle_RTO_registration_number,
                                                               DriverRegistrationRequestModel::global_vehicle_id
                                                               )
                                                               ->where(DriverRegistrationRequestModel::request_token, $request['auth_token'])
                                                               ->get();
                
                if(isset($data)){
                    foreach($data as $key=>$value){
                        $min_rate = self::getMinRate($data[0]["global_vehicle_id"]);
                        $max_rate = self::getMaxRate($data[0]["global_vehicle_id"]);
                        $value["min_rate"] = $min_rate;
                        $value["max_rate"] = $max_rate;
                    }                                               
                    return response()->json(["result"=>true, "message"=>"system rate found", "systemRates"=>$data]);                                               

                }
                else{
                    return APIResponses::failed_result("Oops system rate card is currently not available for you");
                }                                                                
            }
            else{
                return APIResponses::failed_result("Oops system rate card is currently not available for you");
            }
        }
    }

  public static function getMinRate($request){
        $min_rate = self::select(self::min_rate)->where(self::global_vehicle_id,$request)->get();
        return $min_rate;
    }

    public static function getMaxRate($request){
        $max_rate = self::select(self::max_rate)->where(self::global_vehicle_id, $request)->get();
        return $max_rate;
    }
}
