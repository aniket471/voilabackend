<?php

namespace App\Models\Rider;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RiderPickupLocation extends Model
{
    use HasFactory;
    const rider_pickup_location = 'rider_pickup_location';
    const rider_id = 'rider_id';
    const rider_pickup_lat = 'rider_pickup_lat';
    const rider_pickup_long = 'rider_pickup_long';
    const rider_pickup_address = 'rider_pickup_address';

    const rider_pickup_location_all = self::rider_pickup_location . AppConfig::DOT . AppConfig::STAR;
    const rider_rider_pickup_lat = self::rider_pickup_location . AppConfig::DOT . self::rider_pickup_lat;
    const rider_rider_pickup_long = self::rider_pickup_location . AppConfig::DOT . self::rider_pickup_long;
    const rider_rider_pickup_address = self::rider_pickup_location . AppConfig::DOT . self::rider_pickup_address;

    protected $table = self::rider_pickup_location;
    protected $fillable = [
        self::rider_id,
        self::rider_pickup_lat,
        self::rider_pickup_long,
        self::rider_pickup_address
    ];

    public $timestamps = false;
    //update a rider location continuously if rider change the pickup location also update that new location
    public static function updateRiderLocationContinuously($request)
    {

        $riderLocation = new self();

        if (isset($request[self::rider_id])) {

            if (self::where(self::rider_id, $request[self::rider_id])->first()) {

                $updateLocation = DB::update('update rider_pickup_location set rider_pickup_lat=? ,rider_pickup_long=?,rider_pickup_address=? where rider_id=?',[$request[self::rider_pickup_lat],$request[self::rider_pickup_long],$request[self::rider_pickup_address],$request[self::rider_id]]);
                if($updateLocation)
                return APIResponses::success_result("Location updated successfully");
                else
                return APIResponses::failed_result("Location not updated");
            }
            else{

                $riderLocation[self::rider_id] = $request[self::rider_id] ?? 0;
                $riderLocation[self::rider_pickup_lat] = $request[self::rider_pickup_lat] ?? 0;
                $riderLocation[self::rider_pickup_long] = $request[self::rider_pickup_long] ?? 0;
                $riderLocation[self::rider_pickup_address] = $request[self::rider_pickup_address]??"";

                $result = $riderLocation->save();
                if ($result)
                    return APIResponses::success_result("Rider new Location addedd");
                else
                    return APIResponses::success_result("Rider location not addedd");
            }
        }
        else
        return APIResponses::failed_result("Failed check anything missing..");
    }

    //get rider current/pickup location when send a alert to drivers
   public static function getRiderLocationContinuously($request){

    if(isset($request[self::rider_id]))
    return self::select(self::rider_pickup_lat,self::rider_pickup_long,self::rider_pickup_address,self::rider_id)
              ->where(self::rider_id,$request[self::rider_id])->get();
     else
     return 0;         
   }

}
