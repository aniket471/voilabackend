<?php

namespace App\Models\DriverInfo\DriverDetails;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use App\Models\DriverRegistartionRequestCreation\DriverRegistrationRequestModel;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\PseudoTypes\True_;

class DriverRateCard extends Model
{
    use HasFactory;
    const driver_rate_card = 'driver_rate_card';
    const driver_id = 'driver_id';
    const min_rate = 'min_rate';
    const max_rate = 'max_rate';
    const system_rate = "system_rate";
    const canceled_trips = 'canceled_trips';
    const canceled_trip_limit = 'canceled_trip_limit';

    const driver_driver_rate_card = self::driver_rate_card . AppConfig::DOT . AppConfig::STAR;
    const driver_driver_id = self::driver_rate_card . AppConfig::DOT . self::driver_id;
    const driver_min_rate = self::driver_rate_card . AppConfig::DOT . self::min_rate;
    const driver_max_rate = self::driver_rate_card . AppConfig::DOT . self::max_rate;
    const driver_system_rate = self::driver_rate_card . AppConfig::DOT . self::system_rate;
    const driver_canceled_trip_limit = self::driver_rate_card . AppConfig::DOT . self::canceled_trip_limit;
    const driver_canceled_trips = self::driver_rate_card . AppConfig::DOT . self::canceled_trips;

    protected $table = self::driver_rate_card;
    protected $fillable = [
        self::driver_id,
        self::min_rate,
        self::max_rate,
        self::system_rate,
        self::canceled_trips,
        self::canceled_trip_limit
    ];

    public $timestamps = false;


    //check driver enable to cancēled the trip
    public static function canceledTripByDriver($request)
    {
        $getCanceledTrips = self::select(self::canceled_trips, self::driver_id)->where(self::driver_id, $request[self::driver_id])->get();

        foreach ($getCanceledTrips as $key => $value) {
            $value->check = self::getDriverCanceledLimit($value);
        }
        return $getCanceledTrips;
    }

    public static function getDriverCanceledLimit($request)
    {
        $getCanceledTripsLimit = self::select(self::canceled_trip_limit)
            ->where(self::driver_id, $request[self::driver_id])
            ->get();
        foreach ($getCanceledTripsLimit as $key => $value) {

            if ($request[self::canceled_trips] < $value[self::canceled_trip_limit]) {

                $updateTheLimit = DB::update('update driver_rate_card set canceled_trips=? where driver_id=?', [$request[self::canceled_trips] + 1, $request[self::driver_id]]);
                if ($updateTheLimit)
                    return "Enable";
                else
                    return "Trip not update";
            } else {
                return "Disable";
            }
        }
    }

    public static function createCustomeRateCard($request)
    {

        $validator = Validator::make($request->all(), [
            self::driver_id => 'required',
            self::min_rate =>  'required',
            self::max_rate =>  'required',

        ]);

        if ($validator->fails()) {

            return APIResponses::failed_result("Oops custome rate card  not generated please try again...");
        } else {

            if (self::where(self::driver_id, $request[self::driver_id])->first()) {


                $updateData[self::min_rate] = $request[self::min_rate];
                $updateData[self::max_rate] = $request[self::max_rate];

                $result = self::where(self::driver_id, $request[self::driver_id])->update($updateData);

                if ($result) {
                    return APIResponses::success_result("Custome rate card created successfully");
                } else {
                    return APIResponses::failed_result("Failed to create a custome rate card please try again...");
                }
            } else {

                $data = new self();

                $data[self::driver_id] = $request[self::driver_id];
                $data[self::min_rate] = $request[self::min_rate];
                $data[self::max_rate] = $request[self::max_rate];
                $data[self::system_rate] = 30; 
                $data[self::canceled_trips] = 0;
                $data[self::canceled_trip_limit] = 30;

                $result = $data->save();

                if ($result) {
                    return APIResponses::success_result("Custome rate card created successfully");
                } else {
                    return APIResponses::failed_result("Failed to create a custome rate card please try again...");
                }
            }
        }
    }

    public static function getDriverVehicleInfo($request)
    {

        $validator = Validator::make($request->all(), [
            self::driver_id => 'required'
        ]);

        if ($validator->fails()) {

            return APIResponses::failed_result("Oops custome rate card  not generated please try again...");
        } else {

            if (self::where(self::driver_id, $request[self::driver_id])->first()) {

                if(DriverRegistrationRequestModel::where(DriverRegistrationRequestModel::request_token,$request['request_token'])->first()){

                    $data = DriverRegistrationRequestModel::select(
                        DriverRegistrationRequestModel::vehicle_type,
                        DriverRegistrationRequestModel::vehicle_RTO_registration_number,
                    )
                        ->where(DriverRegistrationRequestModel::request_token, $request['request_token'])
                        ->get();
    
                    $rateCard = self::select(self::min_rate,self::max_rate)->where(self::driver_id,$request[self::driver_id])->get();
                    
                    return response()->json(["result" => true, "message" => "Vehicle Info find", "isRateCardSet" => true, "vehicleInfoRate" => $data, "oldRates"=>$rateCard]);
                }
                else{
                    return APIResponses::failed_result("Failed to add custome rate card please try again");
                }
                
            } else {

                $data = DriverRegistrationRequestModel::select(
                    DriverRegistrationRequestModel::vehicle_type,
                    DriverRegistrationRequestModel::vehicle_RTO_registration_number,
                )
                    ->where(DriverRegistrationRequestModel::request_token)
                    ->get();
                return response()->json(["result" => true, "message" => "Vehicle Info find", "isRateCardSet" => false, "vehicleInfoRate" => $data]);
            }
        }
    }
}
