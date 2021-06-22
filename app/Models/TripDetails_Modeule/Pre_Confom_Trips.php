<?php

namespace App\Models\TripDetails_Modeule;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    const trip_status = 'trip_status';

    const pre_conform_trips_all = self::pre_conform_trips . AppConfig::DOT . AppConfig::STAR;
    const pre_conform_trips_rider_id = self::rider_id . AppConfig::DOT . self::rider_id;
    const pre_conform_trips_driver_id = self::driver_id . AppConfig::DOT . self::driver_id;
    const pre_conform_trips_trip_id = self::trip_id . AppConfig::DOT . self::trip_id;
    const pre_conform_trips_driver_rate = self::driver_rate . AppConfig::DOT . self::driver_rate;
    const pre_conform_trips_driver_lat = self::driver_lat . AppConfig::DOT . self::driver_lat;
    const pre_conform_trips_driver_long = self::driver_long . AppConfig::DOT . self::driver_long;
    const pre_conform_trips_trip_status = self::trip_status . AppConfig::DOT . self::trip_status;

    protected $table = self::pre_conform_trips;
    protected $fillable = [
        self::rider_id,
        self::driver_id,
        self::trip_id,
        self::driver_rate,
        self::driver_lat,
        self::driver_long,
        self::trip_status
    ];
    public $timestamps = false;

    //rider select a driver to start a trip
    public static function selectDriverToTrip($request){

        $selectedDriver = new self();

        $selectedDriver[self::rider_id] = $request[self::rider_id];
        $selectedDriver[self::driver_id] = $request[self::driver_id];
        $selectedDriver[self::trip_id] = $request[self::trip_id];
        $selectedDriver[self::driver_rate] = $request[self::driver_rate];
        $selectedDriver[self::driver_lat] = $request[self::driver_lat];
        $selectedDriver[self::driver_long] = $request[self::driver_long];
        $selectedDriver[self::trip_status] = 5;

        $result = $selectedDriver->save();
        if($result)
        return APIResponses::success_result("driver conform to ride");
        else
        return APIResponses::failed_result("driver conform request failed");
    }

    //enable/Notify the trip to selected driver 
    public static function enableTripToSelectedDriver($request){

        if(self::where(self::driver_id,$request[self::driver_id])
            ->where(self::rider_id,$request[self::rider_id])->first()){

                return APIResponses::success_result("trip enable");
        }
    }

    //track the
}
