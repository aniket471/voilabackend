<?php

namespace App\Models\TripDetails_Modeule;

use App\Models\Bidding_Creation\Bidding;
use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use App\Models\Common\Notify\NotificationToDriver;
use App\Models\DriverInfo\DriverDetails\DriverDetails;
use App\Models\Rider\RiderLogin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConformTrips extends Model
{
    use HasFactory;
    const conform_trips = 'conform_trips';
    const rider_id = 'rider_id';
    const driver_id = 'driver_id';
    const trip_id = 'trip_id';
    const driver_rate = 'driver_rate';
    const rider_pickup_lat = 'rider_pickup_lat';
    const rider_pickup_long = 'rider_pickup_long';
    const rider_dest_lat = 'rider_dest_lat';
    const rider_dest_long = 'rider_dest_long';
    const rider_pickup_address = 'rider_pickup_address';
    const rider_drop_address = 'rider_drop_address';
    const driver_current_lat = 'driver_current_lat';
    const driver_current_long = 'driver_current_long';
    const updated_at = 'updated_at';
    const trip_status = 'trip_status';

    const conform_trips_all = self::conform_trips . AppConfig::DOT . AppConfig::STAR;
    const conform_trips_rider_id = self::conform_trips . AppConfig::DOT . self::rider_id;
    const conform_trips_driver_id = self::conform_trips . AppConfig::DOT . self::driver_id;
    const conform_trips_trip_id = self::conform_trips . AppConfig::DOT . self::trip_id;
    const conform_trips_driver_rate = self::conform_trips . AppConfig::DOT . self::driver_rate;
    const conform_trips_rider_pickup_lat = self::conform_trips . AppConfig::DOT . self::rider_pickup_lat;
    const conform_trips_rider_pickup_long = self::conform_trips . AppConfig::DOT . self::rider_pickup_long;
    const conform_trips_rider_dest_lat = self::conform_trips . AppConfig::DOT . self::rider_dest_lat;
    const conform_trips_rider_dest_long = self::conform_trips . AppConfig::DOT . self::rider_dest_long;
    const conform_trips_rider_pickup_address = self::conform_trips . AppConfig::DOT . self::rider_pickup_address;
    const conform_trips_rider_drop_address = self::conform_trips . AppConfig::DOT . self::rider_drop_address;
    const conform_trips_driver_current_long = self::conform_trips . AppConfig::DOT . self::driver_current_long;
    const conform_trips_driver_current_lat = self::conform_trips . AppConfig::DOT . self::driver_current_lat;
    const conform_trips_trip_status = self::conform_trips . AppConfig::DOT . self::trip_status;
    const conform_trips_updated_at = self::conform_trips . AppConfig::DOT . self::updated_at;

    protected $table = self::conform_trips;
    protected $fillable = [
        self::rider_id,
        self::driver_id,
        self::trip_id,
        self::driver_rate,
        self::rider_pickup_lat,
        self::rider_pickup_long,
        self::rider_dest_lat,
        self::rider_dest_long,
        self::rider_pickup_address,
        self::rider_drop_address,
        self::driver_current_lat,
        self::driver_current_long,
        self::updated_at,
        self::trip_status
    ];


    //when driver start a trip after reaching the rider pickup point
    public static function startTheRide($request)
    {

        if (isset($request[self::rider_id]) && isset($request[self::driver_id])) {

            $convertTrip = Pre_Confom_Trips::convertTripToConformTrip($request);
            if ($convertTrip === 1) {
                return self::conformTheTrip($request);
            } elseif ($convertTrip === 0) {
                return APIResponses::failed_result("Unable to start a ride.Trip not converted pre_conform to conform");
            }
        } else {
            //if the driver id and rider is missing
            return APIResponses::failed_result("Unable to start a ride.Driver id and Rider id null");
        }
    }
    //conform trip after delete the pre_conform_trip by driver
    public static function conformTheTrip($request)
    {

        $conformTrip = new self();

        if (isset($request[self::driver_id]) && isset($request[self::rider_id])) {

            $conformTrip[self::rider_id] = $request[self::rider_id];
            $conformTrip[self::driver_id] = $request[self::driver_id];
            $conformTrip[self::trip_id] = $request[self::trip_id];
            $conformTrip[self::driver_rate] = $request[self::driver_rate];
            $conformTrip[self::rider_pickup_lat] = $request[self::rider_pickup_lat] ?? "";
            $conformTrip[self::rider_pickup_long] = $request[self::rider_pickup_long] ?? "";
            $conformTrip[self::rider_dest_lat] = $request[self::rider_dest_lat] ?? "";
            $conformTrip[self::rider_dest_long] = $request[self::rider_dest_long] ?? "";
            $conformTrip[self::rider_pickup_address] = $request[self::rider_pickup_address] ?? "";
            $conformTrip[self::rider_drop_address] = $request[self::rider_drop_address] ?? "";
            $conformTrip[self::driver_current_lat] = $request[self::driver_current_lat] ?? "";
            $conformTrip[self::driver_current_long] = $request[self::driver_current_long] ?? "";
            $conformTrip[self::trip_status] = 6;

            $result = $conformTrip->save();

    $riderFCMToken = RiderLogin::select(RiderLogin::rider_fcm_token)->where(RiderLogin::rider_id,$request[self::rider_id])->get();

             self::notifyTheRiderTripIsStarted($riderFCMToken[0]["fcm_token"]);

            if ($result) {
                $data = [
                    "rider_dest_lat" => $request[self::rider_dest_lat] ?? "",
                    "rider_dest_lng" => $request[self::rider_dest_long] ?? "",
                    "rider_drop_address" => $request[self::rider_drop_address] ?? ""
                ];
                return response()->json([$response= "result"=>true , "message"=>"Trip started successfully","tripStartData"=>array($data)]);

            } else {
                return APIResponses::failed_result("Unable to start trip");
            }
        } else {
            //if the driver id and rider is missing
            return APIResponses::failed_result("Unable to start a ride.Driver id and Rider id null");
        }
    }

   //end the ride params driver_id, rider_id
    public static function endTheRide($request)
    {

        $conformTripData = self::select(
            self::rider_id,
            self::driver_id,
            self::trip_id,
            self::driver_rate,
            self::rider_pickup_lat,
            self::rider_pickup_long,
            self::rider_dest_lat,
            self::rider_dest_long,
            self::rider_pickup_address,
            self::rider_drop_address,
            self::CREATED_AT,
            self::trip_status
        )
            ->where(self::driver_id, $request[self::driver_id])
            ->where(self::rider_id, $request[self::rider_id])
            ->where(self::trip_status, 6)
            ->get();

      // Bidding::removeBidding($request);  
       // return $conformTripData;
        $saveTrip = TripHistory::addTripHistory($conformTripData);
       // return $saveTrip;
        $saveTripData = json_decode($saveTrip, true);
        // return $saveTripData[0]["saveTrip"];

        if (($saveTripData[0]["saveTrip"]) === "trip history added") {
            return self::updateTheConformTrips($request);
        }
        if (($saveTripData[0]["saveTrip"]) === "trip history not added") {
            return APIResponses::failed_result("trip history not saved");
        }
    }

    public static function updateTheConformTrips($request)
    {

        $updateData = DB::delete('delete from conform_trips where rider_id=? and driver_id=?', [$request[self::rider_id], $request[self::driver_id]]);
        $deleteTripDetails = TripDetails::removeTripDetails($request);
        if ($updateData)
            return APIResponses::success_result("trip successfully completed");
        else
            return APIResponses::failed_result("trip not completed please try again..");
    }

    //feedback to driver() params driver_id
    public static function feedBackToDriver($request)
    {

        if (isset($request[DriverDetails::driver_driver_ratings])) {
            return APIResponses::failed_result("feedback failed rating required");
        } else {
            $driverRating = DriverDetails::updateTheDriverRatings($request);
            if (isset($driverRating)) {
                if($driverRating===1)
                return APIResponses::success_result("Thanks for FeedBack to Voila Driver");
                elseif($driverRating===0)
                return APIResponses::failed_result("Failed the feedback");
            } else {
                return APIResponses::failed_result("Failed the feedback");
            }
        }
    }

    //notify the rider when trip is started
    public static function notifyTheRiderTripIsStarted($token)
    {
        return NotificationToDriver::notifyToDriver($token);
    }

}
