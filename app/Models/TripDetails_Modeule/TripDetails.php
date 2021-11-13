<?php

namespace App\Models\TripDetails_Modeule;

use App\Models\Bidding_Creation\Bidding;
use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use App\Models\DriverInfo\DriverDetails\DriverRateCard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TripDetails extends Model
{
    use HasFactory;

    const trip_details  = 'trip_details';
    const driver_id  = 'driver_id';
    const rider_id = 'rider_id';
    const rider_current_lat = 'rider_current_lat';
    const rider_current_lng = 'rider_current_lng';
    const rider_dest_lat = 'rider_dest_lat';
    const rider_dest_lng = 'rider_dest_lng';
    const rider_current_address = 'rider_current_address';
    const trip_rate = 'trip_rate';
    const trip_id = 'trip_id';
    const trip_status_id = 'trip_status_id';

    const trip_trip_details = self::trip_details . AppConfig::DOT . AppConfig::STAR;
    const trip_driver_id = self::trip_details . AppConfig::DOT . self::driver_id;
    const trip_rider_id = self::trip_details . AppConfig::DOT . self::rider_id;
    const trip_rider_current_lat = self::trip_details . AppConfig::DOT . self::rider_current_lat;
    const trip_rider_current_lng = self::trip_details . AppConfig::DOT . self::rider_current_lng;
    const trip_rider_dest_lat = self::trip_details . AppConfig::DOT . self::rider_dest_lat;
    const trip_rider_dest_lng = self::trip_details . AppConfig::DOT . self::rider_dest_lng;
    const trip_rider_current_address = self::trip_details . AppConfig::DOT . self::rider_current_address;
    const trip_trip_rate = self::trip_details . AppConfig::DOT . self::trip_rate;
    const trip_trip_id = self::trip_details . AppConfig::DOT . self::trip_id;
    const trip_trip_status_id = self::trip_details . AppConfig::DOT . self::trip_status_id;

    protected $table = self::trip_details;
    protected $fillable = [
        self::driver_id,
        self::rider_id,
        self::rider_current_lat,
        self::rider_current_lng,
        self::rider_dest_lat,
        self::rider_dest_lng,
        self::rider_current_address,
        self::trip_rate,
        self::trip_id,
        self::trip_status_id
    ];
    public $timestamps = false;

    public static function checkTheTripStatus($request)
    {
        if (self::where(self::driver_id, $request['driver_id'])->first()) {

            if (self::where(self::driver_id, $request['driver_id'])->where(self::trip_trip_status_id, 1)->first()) {

                $TripStat = self::select(
                    self::trip_trip_status_id,
                    self::trip_rider_id,
                    self::trip_rider_current_lat,
                    self::trip_rider_current_lng,
                    self::trip_rider_dest_lat,
                    self::trip_rider_dest_lng,
                    self::trip_rider_current_address,
                    self::trip_trip_rate,
                    self::trip_trip_id
                )
                    ->where(self::driver_id, $request['driver_id'])
                    ->get();
                return response()->json([$response = "result" => true, "message" => "trip find", "trip" => $TripStat]);
            } else {
                return APIResponses::failed_result("trip not pending");
            }
        } else {
            return APIResponses::failed_result("nothing any trip");
        }
    }

    public static function acceptTripForTemp($request)
    {
        $driver_id = $request['driver_id'];
        $rider_id = $request['rider_id'];
        if (self::where(self::trip_status_id, 1)->where(self::driver_id, $driver_id)->where(self::rider_id, $rider_id)->first()) {

            $UpdateTripStatus = DB::update('update trip_details set trip_status_id = ? where rider_id = ?', [0, $rider_id]);

            if ($UpdateTripStatus) {

                $DriverRate = DriverRateCard::select(
                    DriverRateCard::driver_min_rate,
                    self::trip_driver_id,
                    self::trip_rider_id,
                    self::trip_trip_id,self::trip_rider_current_lat,
                    self::trip_rider_current_lng,self::rider_dest_lat,
                    self::trip_rider_dest_lng,
                    self::trip_trip_rate,
                    self::trip_rider_current_address
                )
                    ->join(self::trip_details, DriverRateCard::driver_driver_id, self::trip_driver_id)
                    ->where(DriverRateCard::driver_driver_id, $driver_id)
                    ->get();
                // return $DriverRate;                               
                if ($DriverRate) {
                    $DriverRate->flatmap(function ($DriverRates) {
                        $DriverRates[Bidding::bidding_rate] = Bidding::addBiddingRate($DriverRates);
                    });

                    //  return response()->json([$response = "result"=>true ,"message"=>"first driver","driverRate"=>$DriverRate]);
                    return APIResponses::success_result_with_data("first Driver", $DriverRate);
                } else {
                    return APIResponses::failed_result("something went wrong");
                }
            } else {
                return APIResponses::failed_result("Trip status not updated");
            }
        } else {

            //return (Bidding::lowBiddingRate($request));
            $DriverRate = DriverRateCard::select(
                DriverRateCard::driver_min_rate,
                self::trip_driver_id,
                self::trip_rider_id,
                self::trip_trip_id,self::trip_rider_current_lat,
                self::trip_rider_current_lng,self::rider_dest_lat,
                self::trip_rider_dest_lng,
                self::trip_rider_current_address
            )
                ->join(self::trip_details, DriverRateCard::driver_driver_id, self::trip_driver_id)
                ->where(DriverRateCard::driver_driver_id, $driver_id)
                ->get();
            // return $DriverRate;                               
            if ($DriverRate) {
                $DriverRate->flatmap(function ($DriverRates) {
                    $DriverRates[Bidding::bidding_rate] = Bidding::lowBiddingRate($DriverRates);
                });

                //  return response()->json([$response = "result"=>true ,"message"=>"first driver","driverRate"=>$DriverRate]);
                return APIResponses::success_result_with_data("Lowest rate available", $DriverRate);
            }
        }
    }
}
