<?php

namespace App\Models\TripDetails_Modeule;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use App\Models\DriverInfo\DriverLocation\DriverLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pre_Confom_Trips extends Model
{
    use HasFactory;

    const pre_conform_trips = 'pre_conform_trips';
    const rider_id = 'rider_id';
    const driver_id = 'driver_id';
    const trip_id = 'trip_id';
    const driver_rate = 'driver_rate';
    const driver_lat = 'driver_lat';
    const driver_long = 'driver_long';
    const otp = 'otp';
    const trip_status = 'trip_status';

    const pre_conform_trips_all = self::pre_conform_trips . AppConfig::DOT . AppConfig::STAR;
    const pre_conform_trips_rider_id = self::pre_conform_trips . AppConfig::DOT . self::rider_id;
    const pre_conform_trips_driver_id = self::pre_conform_trips . AppConfig::DOT . self::driver_id;
    const pre_conform_trips_trip_id = self::pre_conform_trips . AppConfig::DOT . self::trip_id;
    const pre_conform_trips_driver_rate = self::pre_conform_trips . AppConfig::DOT . self::driver_rate;
    const pre_conform_trips_driver_lat = self::pre_conform_trips . AppConfig::DOT . self::driver_lat;
    const pre_conform_trips_driver_long = self::pre_conform_trips . AppConfig::DOT . self::driver_long;
    const pre_conform_trips_trip_status = self::pre_conform_trips . AppConfig::DOT . self::trip_status;
    const pre_conform_trips_otp = self::pre_conform_trips . AppConfig::DOT . self::otp;

    protected $table = self::pre_conform_trips;
    protected $fillable = [
        self::rider_id,
        self::driver_id,
        self::trip_id,
        self::driver_rate,
        self::driver_lat,
        self::driver_long,
        self::trip_status,
        self::otp
    ];
    public $timestamps = false;

    //rider select a driver to start a trip
    public static function selectDriverToTrip($request)
    {

        $selectedDriver = new self();

        if(isset($request[self::rider_id])){

            if(isset($request[self::driver_id])){

                if(isset($request[self::trip_id])){

                    if(isset($request[self::driver_lat]) && isset($request[self::driver_long])){

                        if(isset($request[self::driver_rate])){

                            $selectedDriver[self::rider_id] = $request[self::rider_id] ?? 0;
                            $selectedDriver[self::driver_id] = $request[self::driver_id] ?? 0;
                            $selectedDriver[self::trip_id] = $request[self::trip_id] ?? 0;
                            $selectedDriver[self::driver_rate] = $request[self::driver_rate] ?? 0;
                            $selectedDriver[self::driver_lat] = $request[self::driver_lat] ?? 0;
                            $selectedDriver[self::driver_long] = $request[self::driver_long] ?? 0;
                            $selectedDriver[self::trip_status] = 5;
                    
                            $result = $selectedDriver->save();
                            if ($result)
                                return APIResponses::success_result("driver conform to ride");
                            else
                                return APIResponses::failed_result("driver conform request failed");

                        }
                        else return APIResponses::failed_result("Driver rate missing");
                    }
                    else return APIResponses::failed_result("Driver lat lng null");
                }
                else return APIResponses::failed_result("trip id missing");
            }
            else return APIResponses::failed_result("Driver id missing");
        
        }
        else{
            return APIResponses::failed_result("Rider id missing");
        }

       
    }

    //enable/Notify the trip to selected driver 
    public static function enableTripToSelectedDriver($request)
    {

        if (self::where(self::driver_id, $request[self::driver_id])
            ->where(self::rider_id, $request[self::rider_id])->first()
        ) {
            $data = self::select(self::driver_rate,self::trip_id,self::driver_lat,self::driver_long)->
                      where(self::driver_id,$request[self::driver_id])
                         ->where(self::rider_id,$request[self::rider_id])->get();

            return response()->json([$response = "result"=>true ,"message"=>"trip enable","tripEnableData"=>$data]);
            
        } else {
            return APIResponses::failed_result("trip not enable");
        }
    }

    //convert a trip pre-conform_trips to conform_trips after driver start the ride

    public static function convertTripToConformTrip($request)
    {
        $result = DB::delete('delete from pre_conform_trips where rider_id=? and driver_id=?', [$request[self::rider_id], $request[self::driver_id]]);
        if ($result)
            return 1;
        else
            return 0;
    }

    //generate the otp before pickup the rider
    public static function generateTheOtpToVerifyTheDriver($request)
    {

        $otp = AppConfig::get4DigitOtp();

        if (!empty($request[self::rider_id])) {

            $updateTheOtp = DB::update('update pre_conform_trips set otp=? where rider_id=?', [$otp, $request[self::rider_id]]);

            if ($updateTheOtp) {
                return APIResponses::success_result_with_data("OTP generated successfully", strval($otp));
            } else {
                return APIResponses::failed_result("OTP not generated");
            }
        } else {
            return APIResponses::failed_result("Rider Id missing..Please check");
        }
    }

    //update driver location after trip enable to driver (Driver site api)
    public static function updateDriverLocation($request)
    {
        if (self::where(self::driver_id, $request[self::driver_id])->first()) {

            if (!empty($request[self::driver_lat]) && !empty($request[self::driver_long]) && !empty($request[self::driver_id])) {


                $updateDriverLocation = DB::update('update pre_conform_trips set driver_lat=?,driver_long=? where driver_id=?', [$request[self::driver_lat], $request[self::driver_long], $request[self::driver_id]]);
                if ($updateDriverLocation) {
                    return APIResponses::success_result("Driver location updated");
                } else {
                    return APIResponses::failed_result("Driver Location not updated");
                }
            } else {
                return APIResponses::failed_result("Data missing");
            }
        } else {
            return APIResponses::failed_result("Driver id not matched");
        }
    }

    //get driver location when trip enable to driver on online tracking system
    public static function getDriverUpdatedLocation($request)
    {
        if (!empty($request[self::rider_id]) && !empty($request[self::driver_id])) {
            if (ConformTrips::where(ConformTrips::driver_id, $request[self::driver_id])->where(ConformTrips::rider_id, $request[self::rider_id])->first()) {
                return APIResponses::failed_result("Driver is reached");
            } 
            else {
                $DriverLatLng = self::select(self::driver_lat, self::driver_long, self::driver_id)
                    ->where(self::driver_id, $request[self::driver_id])
                    ->where(self::rider_id, $request[self::rider_id])
                    ->get();

                return response()->json([$response = "result" => true, "message" => "Driver new location find", "driverLocation" => $DriverLatLng]);
            }
        } else {
            return APIResponses::failed_result("Data missing");
        }
    }

    //otp verification when driver start a trip
    public static function verifyDriver($request)
    {

        if (self::where(self::driver_id, $request[self::driver_id])
            ->where(self::rider_id, $request[self::rider_id])
            ->where(self::otp, $request[self::otp])
            ->first()
        ) {
            return APIResponses::success_result("Otp Matched..");
        } else {
            return APIResponses::failed_result("Otp mismatch please check the otp..");
        }
    }
}
