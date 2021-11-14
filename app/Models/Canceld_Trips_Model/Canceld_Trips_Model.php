<?php

namespace App\Models\Canceld_Trips_Model;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use App\Models\DriverInfo\DriverDetails\DriverRateCard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isNull;

class Canceld_Trips_Model extends Model
{
    use HasFactory;

    const canceled_trips = 'canceld_trips';
    const rider_id = 'rider_id';
    const driver_id = 'driver_id';
    const trip_id = 'trip_id';
    const canceled_by = 'canceled_by';
    const canceled_mode_id = 'canceled_mode_id';
    const canceled_description = 'canceled_description';
    const others = 'others';
    const rider_current_lat = 'rider_current_lat';
    const rider_current_long = 'rider_current_long';
    const rider_dest_lat = 'rider_dest_lat';
    const rider_dest_long = 'rider_dest_long';
    const rider_pickup_address = 'rider_pickup_address';
    const rider_drop_address = 'rider_drop_address';
    const trip_status_id = 'trip_status_id';

    const canceled_trips_all = self::canceled_trips . AppConfig::DOT . AppConfig::STAR;
    const canceled_trips_rider_id = self::canceled_trips . AppConfig::DOT . self::rider_id;
    const canceled_trips_driver_id = self::canceled_trips . AppConfig::DOT . self::driver_id;
    const canceled_trips_trip_id = self::canceled_trips . AppConfig::DOT . self::trip_id;
    const canceled_trips_canceled_by = self::canceled_trips . AppConfig::DOT . self::canceled_by;
    const canceled_trips_canceled_mode_id = self::canceled_trips . AppConfig::DOT . self::canceled_mode_id;
    const canceled_trips_canceled_mode_description = self::canceled_trips . AppConfig::DOT . self::canceled_description;
    const canceled_trips_others = self::canceled_trips . AppConfig::DOT . self::others;
    const canceled_trips_rider_current_lat = self::canceled_trips . AppConfig::DOT . self::rider_current_lat;
    const canceled_trips_rider_current_long = self::canceled_trips . AppConfig::DOT . self::rider_current_long;
    const canceled_trips_rider_dest_lat = self::canceled_trips . AppConfig::DOT . self::rider_dest_lat;
    const canceled_trips_rider_dest_long = self::canceled_trips . AppConfig::DOT . self::rider_dest_long;
    const canceled_trips_rider_pickup_address = self::canceled_trips . AppConfig::DOT . self::rider_pickup_address;
    const canceled_trips_rider_drop_address = self::canceled_trips . AppConfig::DOT . self::rider_drop_address;
    const canceled_trips_trip_status_id = self::canceled_trips . AppConfig::DOT  . self::trip_status_id;

    protected $table = self::canceled_trips;
    protected $fillable = [
        self::rider_id,
        self::driver_id,
        self::trip_id,
        self::canceled_by,
        self::canceled_mode_id,
        self::canceled_description,
        self::others,
        self::rider_current_lat,
        self::rider_current_long,
        self::rider_dest_lat,
        self::rider_dest_long,
        self::rider_pickup_address,
        self::rider_drop_address,
        self::trip_status_id,
    ];

    public $timestamps = false;

    //canceled trip
    public static function canceledTrip($request)
    {
        if ($request[self::canceled_by] === $request[self::driver_id]) {
            $checkTripEnableOrNot =  DriverRateCard::canceledTripByDriver($request);

            if ( isset($checkTripEnableOrNot[0]["check"]) === "Enable") {
                return self::canceledTripByDriver($request);
            } elseif (isset($checkTripEnableOrNot[0]["check"]) === "Trip not update") {
                return APIResponses::failed_result("Voila not update");
            } elseif (isset($checkTripEnableOrNot[0]["check"]) === "Disable") {
                return APIResponses::failed_result("Voila trip canceled Disable");
            }
        }
         else {
            return self::canceledTripByDriver($request);
        }
    }

    public static function canceledTripByDriver($request)
    {
        $canceledTrip = new self();
        $canceledTrip[self::rider_id] = $request[self::rider_id] ?? 0;
        $canceledTrip[self::driver_id] = $request[self::driver_id] ?? 0;
        $canceledTrip[self::trip_id] = $request[self::trip_id] ?? '';
        $canceledTrip[self::canceled_by] = $request[self::canceled_by] ?? 0;
        $canceledTrip[self::canceled_mode_id] = $request[self::canceled_mode_id] ?? 0;
        $canceledTrip[self::canceled_description] = $request[self::canceled_description] ?? '';
        $canceledTrip[self::rider_current_lat] = $request[self::rider_current_lat] ?? '';
        $canceledTrip[self::rider_current_long] = $request[self::rider_dest_long] ?? '';
        $canceledTrip[self::rider_dest_lat] = $request[self::rider_dest_lat] ?? '';
        $canceledTrip[self::rider_dest_long] = $request[self::rider_dest_long] ?? '';
        $canceledTrip[self::rider_pickup_address] = $request[self::rider_pickup_address] ?? '';
        $canceledTrip[self::rider_drop_address] = $request[self::rider_drop_address] ?? '';
        $canceledTrip[self::trip_status_id] = 8;

         $result = $canceledTrip->save();
        if($result){
            return APIResponses::success_result("Trip Canceled Successfully");
        }
        else
        return APIResponses::failed_result("Trip not canceled");
    }
}
