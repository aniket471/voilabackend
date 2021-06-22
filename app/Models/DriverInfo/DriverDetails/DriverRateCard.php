<?php

namespace App\Models\DriverInfo\DriverDetails;

use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

                $updateTheLimit = DB::update('update driver_rate_card set canceled_trips=? where driver_id=?',[$request[self::canceled_trips]+1,$request[self::driver_id]]);
                if($updateTheLimit)
                return "Enable";
                else
                return "Trip not update";
            } 
            else {
                return "Disable";
            }
        }
    }
}
