<?php

namespace App\Models\Bidding_Creation;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use App\Models\DriverInfo\DriverDetails\DriverDetails;
use App\Models\DriverInfo\DriverDetails\DriverRateCard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bidding extends Model
{
    use HasFactory;
    const bidding_rate  = 'bidding_rate';
    const rider_id = 'rider_id';
    const driver_id = 'driver_id';
    const trip_id = 'trip_id';
    const live_bidding_rate = 'live_bidding_rate';
    const driver_status = 'driver_status';

    const bidding_bidding_rate = self::bidding_rate . AppConfig::DOT . AppConfig::STAR;
    const bidding_rider_id = self::bidding_rate . AppConfig::DOT . self::rider_id;
    const bidding_driver_id = self::bidding_rate . AppConfig::DOT . self::driver_id;
    const bidding_trip_is = self::bidding_rate . AppConfig::DOT . self::trip_id;
    const bidding_live_bidding_rate = self::bidding_rate . AppConfig::DOT . self::live_bidding_rate;
    const bidding_driver_status = self::bidding_rate . AppConfig::DOT . self::driver_status;

    protected $table = self::bidding_rate;
    protected $fillable = [
        self::rider_id,
        self::driver_id,
        self::trip_id,
        self::live_bidding_rate,
        self::driver_status
    ];

    public $timestamps = false;

    public static function addBiddingRate($DriverRate)
    {

        $biddingRate = new self();

        // return $DriverRates;

        $biddingRate[self::rider_id] = $DriverRate['rider_id'];
        $biddingRate[self::driver_id] = $DriverRate['driver_id'];
        $biddingRate[self::trip_id] = $DriverRate['trip_id'];
        $biddingRate[self::live_bidding_rate] = $DriverRate['min_rate'];
        $biddingRate[self::driver_status] = 1;

        $biddingAdder = $biddingRate->save();
        if ($biddingAdder) {
            return $DriverRate['min_rate'];
            //  return response()->json([$response = 'result'=>true, 'message'=>"first driver"]);
        } else {
            return (string)$DriverRate['min_rate'];
        }
    }

    public static function lowBiddingRate($request)
    {

        $rider_id = $request['rider_id'];
        $trip_id = $request['trip_id'];

        $GetLowestPrice = self::select(self::bidding_live_bidding_rate)
            ->where(self::rider_id, $rider_id)
            ->orWhere(self::trip_id, $trip_id)
            ->get();
          //  return $GetLowestPrice;
        $MinimumRate = array();

        foreach ($GetLowestPrice as $key => $value) {

            $value->live_bidding_rate = $MinimumRate[] = $value->live_bidding_rate;
            $value->minRate = $mina = min($MinimumRate);
            $value->maxRate = $max = max($MinimumRate);

            
        }
        return $mina;
        //  return response()->json(array([$response = "result"=>true,"message"=>"lowest rate available","bidding_rate"=>array($mina)]));
       
    }

    public static function driverLowestPrice($request)
    {

        $currentLowestRate = $request['current_lowest_rate'];
        $rider_id = $request['rider_id'];
        $driver_id = $request['driver_id'];

        if (DriverRateCard::where(DriverRateCard::driver_driver_id, $driver_id)->first()) {

            if (self::where(self::driver_id, $driver_id)->first()) {
                $DriverLowestRate = DriverRateCard::select(DriverRateCard::driver_min_rate)
                    ->where(DriverRateCard::driver_driver_id, $driver_id)
                    ->get();

                foreach ($DriverLowestRate as $key => $value) {
                    if ($currentLowestRate < $value['min_rate']) {
                        $UpdateBiddingRates = DB::update('update bidding_rate set live_bidding_rate=? where driver_id=?', [$value['min_rate'], $driver_id]);
                         return response()->json([$response = "result" => true, "message" => "live rate not changed", "currentRate" => $currentLowestRate]);
                         
                    }
                    else {
                        $UpdateBiddingRates = DB::update('update bidding_rate set live_bidding_rate=? where driver_id=?', [$value['min_rate'], $driver_id]);
                        return response()->json([$response = "result" => false, "message" => "live rate changed","currentRate"=>$value['min_rate']]);
                    }
                }
            } else {

                $DriverLowestRate = DriverRateCard::select(DriverRateCard::driver_min_rate)
                                       ->where(DriverRateCard::driver_driver_id,$driver_id)
                                       ->get();

                 foreach($DriverLowestRate as $key => $value){
                     if($currentLowestRate < $value['min_rate']){
                        $insertNewRate = new self();
                        $insertNewRate[self::driver_id] = $driver_id;
                        $insertNewRate[self::rider_id] = $rider_id;
                        $insertNewRate[self::live_bidding_rate] = $value['min_rate'];
                        $insertNewRate[self::trip_id] = $request['trip_id'];
        
                        $result = $insertNewRate->save();
                        if ($result)
                            return response()->json([$response = "result" => true, "message" => "lowest rate unavailable", "currentRate" =>$currentLowestRate]);
                        
                     }
                     else{

                        $insertNewRate = new self();
                        $insertNewRate[self::driver_id] = $driver_id;
                        $insertNewRate[self::rider_id] = $rider_id;
                        $insertNewRate[self::live_bidding_rate] = $value['min_rate'];
                        $insertNewRate[self::trip_id] = $request['trip_id'];
        
                        $result = $insertNewRate->save();
                        return response()->json([$response = "result" => false, "message" => "lowest rate available", "currentRate" =>$value['min_rate']]);

                     }                  
                 }          
            }
        } else {
            return response()->json([$response = "result" => false, "message" => "driver id not matched"]);
        }
    }

    public static function getDriversWithBiddingCurrentPrice($request){

        $GetNewDriver = self::select(self::driver_id,self::trip_id,self::live_bidding_rate)
                            ->where(self::driver_status,1)
                            ->where(self::rider_id,$request['rider_id'])
                            ->get();

            $Data = DB::update('update bidding_rate set driver_status = ? where rider_id = ?',[0,$request['rider_id']]);

            if($Data)
            return response()->json([$response = "result"=>true,'message'=>"new driver find","driver"=>$GetNewDriver]);
                       
    }

    public static function refreshTheBiddingPrice($request){
        $driver_id =[$request[self::driver_id]];
        $rider_id = [$request[self::rider_id]];

        $MinimumRate = array();

        //get all bidding live rates
        $biddingRate = self::select(self::live_bidding_rate)->where(self::rider_id,$rider_id)->get();

        foreach($biddingRate as $key=>$value){
            //get minimum rate from table
            $value->live_bidding_rate = $MinimumRate[] = $value->live_bidding_rate;
            $mina = min($MinimumRate);
        }

        return response()->json([$response = "result"=>true,"message"=>"new rate","minRate"=>$mina]);
    }
}
