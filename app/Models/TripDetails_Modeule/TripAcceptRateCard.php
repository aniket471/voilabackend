<?php

namespace App\Models\TripDetails_Modeule;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use App\Models\DriverInfo\DriverLocation\DriverLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TripAcceptRateCard extends Model
{
    use HasFactory;
    const trip_accept_with_rate_card = 'trip_accept_with_rate_card';
    const id = 'id';
    const driver_id = 'driver_id';
    const rider_id = 'rider_id';
    const booking_status = 'booking_status';
    const rate_card_rate = 'rate_card_rate';
    const trip_id = 'trip_id';

    const trip_trip_accept_custom_rate_card = self::trip_accept_with_rate_card . AppConfig::DOT . AppConfig::STAR;
    const trip_driver_id = self::trip_accept_with_rate_card . AppConfig::DOT . self::driver_id;
    const trip_rider_id = self::trip_accept_with_rate_card . AppConfig::DOT . self::rider_id;
    const trip_booking_status = self::trip_accept_with_rate_card . AppConfig::DOT . self::booking_status;
    const trip_rate_card_rate = self::trip_accept_with_rate_card . AppConfig::DOT . self::rate_card_rate;
    const trip_trip_id = self::trip_accept_with_rate_card . AppConfig::DOT . self::trip_id;

    protected $table = self::trip_accept_with_rate_card;
    protected $fillable = [
        self::id,
        self::driver_id,
        self::rider_id,
        self::booking_status,
        self::rate_card_rate,
        self::trip_id
    ];
    
    public $timestamps = false;

    public static function acceptBookingWithRateCard($request){
       $accept_rate_card = new self();
       if(is_null($request['rider_id']) && is_null($request['trip_id']) && is_null($request['accepted_rate'])){
           return response()->json([$response = "result"=>false,"message"=>"id missing"]);
       }
       elseif((is_null($request['booking_status'])))
       return APIResponses::failed_result("booking_status missing");
       
       $accept_rate_card[self::driver_id] = $request['driver_id'];
       $accept_rate_card[self::rider_id] = $request['rider_id'];
       $accept_rate_card[self::booking_status] = $request['booking_status'];
       $accept_rate_card[self::rate_card_rate] = $request['accepted_rate'];
       $accept_rate_card[self::trip_id] = $request['trip_id'];

       $result = $accept_rate_card->save();
       if($result){
       $updateTripDetails = DB::update('update trip_details set trip_status_id = ? where rider_id = ? and driver_id = ?',[$request['booking_status'],$request['rider_id'],$request['driver_id']]);
        if($updateTripDetails)           
        return APIResponses::success_result("booking Accepted");
        else
        return APIResponses::failed_result("booking status not update");
       }
       else
       return APIResponses::failed_result("bookingNotAccepted");
    }

    public static function tripAcceptedDriver($request){

        if(self::where(self::rider_id,$request['rider_id'])->first()){

            $driverDetails = self::select(self::driver_id,
                                          self::trip_id,self::trip_rate_card_rate)
                                          ->where(self::rider_id,$request['rider_id'])
                                          ->get();
            $driverDetails->flatmap(function ($driverDetail){
                $driverDetail[DriverLocation::driver_location] = DriverLocation::getAllDriverInfo($driverDetail);
            });
            
             return APIResponses::success_result_with_data("Driver Details Find",$driverDetails);
                                
        }
        else{
            return TripAcceptCustomeCard::tripAcceptedDriverWithCustomRate($request);
        }
    }
}
