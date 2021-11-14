<?php

namespace App\Models\DriverInfo\DriverLocation;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use App\Models\Common\Notify\NotificationToDriver;
use App\Models\DriveInfo\DriverInfoModel as DriveInfoDriverInfoModel;
use App\Models\DriverInfo\DriverDetails\DriverDetails;
use App\Models\DriverInfo\DriverDetails\DriverRateCard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast\Double;
use PhpParser\Node\Expr\Cast\String_;
use Psy\Formatter\Formatter;
use App\Models\DriverInfo\DriverLocation\DriverVehicles;
use App\Models\DriverInfo\DriverInfoModel;
use App\Models\Rider\RiderPickupLocation;
use App\Models\TripDetails_Modeule\TripDetails;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;

class DriverLocation extends Model
{
    use HasFactory;
    const driver_location = 'driver_location';
    const driver_id = 'driver_id';
    const driver_current_lat = 'driver_current_lat';
    const driver_current_long = 'driver_current_long';
    const driver_current_address = 'driver_current_address';
    const on_off_status = 'on_off_status';
    const driver_vehicle_type_id = 'driver_vehicle_type_id';
    const global_vehicle_id = 'global_vehicle_id';

    const driver_driver_location = self::driver_location . AppConfig::DOT . AppConfig::STAR;
    const driver_driver_id = self::driver_location . AppConfig::DOT . self::driver_id;
    const driver_driver_current_lat = self::driver_location . AppConfig::DOT . self::driver_current_lat;
    const driver_driver_current_long = self::driver_location . AppConfig::DOT . self::driver_current_long;
    const driver_driver_current_address = self::driver_location . AppConfig::DOT . self::driver_current_address;
    const driver_on_off_status = self::driver_location . AppConfig::DOT . self::on_off_status;
    const driver_driver_vehicle_type_id = self::driver_location . AppConfig::DOT . self::driver_vehicle_type_id;
    const driver_global_vehicle_id = self::driver_location . AppConfig::DOT . self::global_vehicle_id;

    protected $table = self::driver_location;
    public $timestamps = false;
    protected $fillable = [
        self::driver_id,
        self::driver_current_lat,
        self::driver_current_long,
        self::driver_current_address,
        self::on_off_status,
        self::global_vehicle_id,
    ];

    //update the driver location continuously need driverid,currentLat,currentLng,currentAddress
    public static function insertTheCurrentLatLngForDriver($request)
    {
         $driverLocation = new self();
      
        if (isset($request[self::driver_id])) {

            if (self::where(self::driver_id, $request[self::driver_id])->first() && self::where(self::on_off_status, 1)->first()) {

                $result = DB::update('update driver_location set driver_current_lat=? , driver_current_long=? ,driver_current_address=? where driver_id=?', [$request[self::driver_current_lat], $request[self::driver_current_long], $request[self::driver_current_address], $request[self::driver_id]]);

                if ($result)
                    return APIResponses::success_result("Driver Current Location update");
                else
                    return APIResponses::failed_result("Driver current location not updated");
            } else {

                $DriverVehicleData = DriverDetails::getDriverVehicleData($request);

                // return $DriverVehicleData[0][DriverDetails::global_vehicle_id];

                $driverLocation[self::driver_id] = $request[self::driver_id] ?? 0;
                $driverLocation[self::driver_current_lat] = $request[self::driver_current_lat] ?? 0;
                $driverLocation[self::driver_current_long] = $request[self::driver_current_long] ?? 0;
                $driverLocation[self::driver_current_address] = $request[self::driver_current_address] ?? "";
                $driverLocation[self::on_off_status] = $request[self::on_off_status] ?? 0;
                $driverLocation[self::driver_vehicle_type_id] = $DriverVehicleData[0][DriverDetails::vehicle_type] ?? 0;
                $driverLocation[self::driver_global_vehicle_id] = $DriverVehicleData[0][DriverDetails::global_vehicle_id] ?? 0;

                $result = $driverLocation->save();
                if ($result)
                    return APIResponses::success_result("Driver new location updated");
            }
        } else {
            return APIResponses::failed_result("driver location not update. driver id missing");
        }
        return $request;
    }

    public static function findTheDriver($request)
    {
        $rider_current_lat = $request['rider_current_lat'];
        $rider_current_lng = $request['rider_current_lng'];
        $rider_dest_lat = $request['rider_dest_lat'];
        $rider_dest_lng = $request['rider_dest_lng'];
        $rider_current_address = $request['rider_current_address'];
        $rider_id = $request['rider_id'];

        $LatLng = self::select(
            self::driver_id,
            self::driver_current_lat,
            self::driver_current_long,
            self::driver_current_address,
            self::driver_vehicle_type_id,
            DriverVehicles::vehicle_vehicle_types,
            DriverDetails::firebase_token,
            DriverDetails::driver_driver_name
        )
            ->join(DriverVehicles::vehicle_type, self::driver_vehicle_type_id, DriverVehicles::vehicle_vehicle_type_id)
            ->join(DriverDetails::driverinfo, self::driver_id, DriverDetails::driver_id)
            ->where(self::on_off_status, 1)
            ->where(DriverVehicles::vehicle_vehicle_type_id, $request['vehicle_type_id'])
            ->get();


        foreach ($LatLng as $key => $value) {
            $point1 = array('lat' => $value->driver_current_lat, 'long' => -$value->driver_current_long);
            $point2 = array('lat' => $rider_current_lat, 'long' => -$rider_current_lng);

            $value->distance = self::getDistanceBetweenPoints($point1['lat'], $point1['long'], $point2['lat'], $point2['long']);
            $value->RiderToDestDistance = self::getDistanceBetweenRiderToDest($rider_current_lat, $rider_current_lng, $rider_dest_lat, $rider_dest_lng);
            $value->TotalDistance = self::totalDistance($value->distance, $value->RiderToDestDistance);
            $value->charges = self::calculateTheCharges($value->vehicle_types, $value->TotalDistance);
            $value->notify = self::notifyToDriver($value->firebase_token);
            $value->sendData = self::sendDataForTrip($value->driver_id, $rider_id, $rider_current_lat, $rider_current_lng, $rider_dest_lat, $rider_dest_lng, $rider_current_address, $value->charges, "1250");
        }

        return response()->json([$response = 'result' => true, 'message' => "Get The Driver", "drives" => $LatLng]);
    }

    public static function getDistanceBetweenPoints($lat1, $lon1, $lat2, $lon2)
    {
          $origins = $lat1.','.$lon1; 
        $destination = $lat2.','.$lon2;

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $origins . "&destinations=" . $destination . "&mode=driving&language=it-IT&key=AIzaSyCvT8vf4j7X6p-d21NvnX3qVdAL5xd5wiY";
               $ch = curl_init();
               curl_setopt($ch, CURLOPT_URL, $url);
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
               curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
               curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
               curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
               $response = curl_exec($ch);
               curl_close($ch);
               $response_a = json_decode($response, true);
              // return $response_a;
               if (isset($response_a['rows'][0]['elements'][0]['distance']['text'])) {
                  $m = $response_a['rows'][0]['elements'][0]['distance']['text'];
               }else{
                  $m = 0;
               }
               
        // return $kilometers;
        if ($m <= 5) {
            return $m;
        }
    }

    public static function getDistanceBetweenRiderToDest($lat1, $lon1, $lat2, $lon2)
    {
         $origins = $lat1.','.$lon1; 
        $destination = $lat2.','.$lon2;

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $origins . "&destinations=" . $destination . "&mode=driving&language=it-IT&key=AIzaSyCvT8vf4j7X6p-d21NvnX3qVdAL5xd5wiY";
               $ch = curl_init();
               curl_setopt($ch, CURLOPT_URL, $url);
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
               curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
               curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
               curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
               $response = curl_exec($ch);
               curl_close($ch);
               $response_a = json_decode($response, true);
              // return $response_a;
               if (isset($response_a['rows'][0]['elements'][0]['distance']['text'])) {
                  $m = $response_a['rows'][0]['elements'][0]['distance']['text'];
               }else{
                  $m = 0;
               }
               
               return $m;
    }

    public static function getDistanceBetweenRiderToDriver($lat1, $lon1, $lat2, $lon2, $driver_id)
    {
        
         $origins = $lat1.','.$lon1; 
        $destination = $lat2.','.$lon2;

        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $origins . "&destinations=" . $destination . "&mode=driving&language=it-IT&key=AIzaSyCvT8vf4j7X6p-d21NvnX3qVdAL5xd5wiY";
               $ch = curl_init();
               curl_setopt($ch, CURLOPT_URL, $url);
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
               curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
               curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
               curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
               $response = curl_exec($ch);
               curl_close($ch);
               $response_a = json_decode($response, true);
              // return $response_a;
               if (isset($response_a['rows'][0]['elements'][0]['distance']['text'])) {
                  $m = $response_a['rows'][0]['elements'][0]['distance']['text'];
               }else{
                  $m = 0;
               }
               
               if($m <=5){
                   return $driver_id;
               }
     
    }

    public static function calculateTheCharges($driver_vehicle, $distance)
    {
        if ($driver_vehicle == "Rikshow") {;
            $calculate = $distance  * 15;
            return $calculate;
        } else if ($driver_vehicle == "mini car") {
            $calculate = $distance * 60;
            return $calculate;
        } elseif ($driver_vehicle == "sedan") {
            $calculate = $distance * 120;
            return $calculate;
        } elseif ($driver_vehicle == "bike") {
            $calculate = $distance  * 10;
            return $calculate;
        } else {
            return $driver_vehicle;
        }
    }

    public static function totalDistance($distance, $distanceWithRiderDest)
    {
        $calculate = $distance + $distanceWithRiderDest;
        return $calculate;
    }
    public static function notifyToDriver($token)
    {
        return NotificationToDriver::notifyToDriver($token);
    }
    public static function sendDataForTrip($driver_id, $rider_id, $rider_current_lat, $rider_current_lng, $rider_dest_lat, $rider_dest_lng, $rider_current_address,$rider_drop_address, $trip_rate, $trip_id)
    {

        $trip_details = new TripDetails();
        $trip_details[TripDetails::trip_driver_id] = $driver_id;
        $trip_details[TripDetails::trip_rider_id] = $rider_id;
        $trip_details[TripDetails::trip_rider_current_lat] = $rider_current_lat ??0;
        $trip_details[TripDetails::trip_rider_current_lng] = $rider_current_lng ??0;

        $trip_details[TripDetails::trip_rider_dest_lat] = $rider_dest_lat ??0;
        $trip_details[TripDetails::trip_rider_dest_lng] = $rider_dest_lng ?? 0;
        $trip_details[TripDetails::trip_rider_current_address] = $rider_current_address ?? "";
        $trip_details[TripDetails::trip_rider_drop_address] = $rider_drop_address ?? "";
        $trip_details[TripDetails::trip_trip_rate] = $trip_rate;
        $trip_details[TripDetails::trip_trip_id] = $trip_id;
        $trip_details[TripDetails::trip_trip_status_id] = 1;

        $dataChecker = $trip_details->save();

        // if ($dataChecker) {
        //     return response()->json([$response = 'result' => true, 'message' => "trip saved",'tripData'=>$trip_id]);
        // } else {
        //     return response()->json([$response = 'result' => false, 'message' => "data not saved"]);
        // }
    }

    //show a all drivers when rider select a global vehicle . all driver should be in 5km radius
    public static function showAllDriver($request)
    {

           $riderPickupLocation = RiderPickupLocation::getRiderLocationContinuously($request);
      // return $riderPickupLocation;
        // return $riderPickupLocation[0][RiderPickupLocation::rider_pickup_address];

            if($riderPickupLocation->isEmpty()){
            return APIResponses::failed_result("Rider pickup address missing");
        }
        
        $rider_current_lat = $riderPickupLocation[0][RiderPickupLocation::rider_pickup_lat];
        $rider_current_lng = $riderPickupLocation[0][RiderPickupLocation::rider_pickup_long];
        $rider_current_address = $riderPickupLocation[0][RiderPickupLocation::rider_pickup_address];


        $rider_dest_lat = $request['rider_dest_lat'];
        $rider_dest_lng = $request['rider_dest_lng'];
        $rider_id = $request['rider_id'];
        $vehicle_type_id = $request['vehicle_type_id'];
        $rider_drop_address = $request['rider_drop_address'];

        $driverLocation = self::select(
            self::driver_current_lat,
            self::driver_current_long,
            self::driver_driver_id,
            DriverDetails::firebase_token
        )
            ->join(DriverDetails::driverinfo, self::driver_id, DriverDetails::driver_id)
            ->where(self::driver_global_vehicle_id, $vehicle_type_id)
            ->get();

           // return $driverLocation;
        foreach ($driverLocation as $value) {

            $point1 = array('lat' => $value->driver_current_lat, 'long' => -$value->driver_current_long);
            $point2 = array('lat' => $rider_current_lat, 'long' => -$rider_current_lng);
            $value->distance = self::getDistanceBetweenRiderToDriver($point1['lat'], $point1['long'], $point2['lat'], $point2['long'], $value->driver_id);
            $value->notify = self::notifyToDriver($value->firebase_token);
        }
  
     //  return $driverLocation;
        $DriverDetails = array();
       
        $DriverDetails = $driverLocation;
        $obj = json_decode (json_encode($DriverDetails), True);
       //  return ($obj);


       $newDataArray = array();
       foreach($obj as $key=>$value){
          if($value["distance"]!=null){
            //   print_r($value["driver_current_lat"]);
             $newDataArray[] = $value;
          }
       }
      //  return $newDataArray;
 $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $pin = mt_rand(1000000, 9999999)
                . mt_rand(1000000, 9999999)
                . $characters[rand(0, strlen($characters) - 1)];
            $trip_id = str_shuffle($pin);

        foreach ($newDataArray as $key => $newValue) {

           
            $newValue["saveTrip"] = self::sendDataForTrip(($newValue['driver_id']), $rider_id, $rider_current_lat, $rider_current_lng, $rider_dest_lat, $rider_dest_lng, $rider_current_address,$rider_drop_address, $request['trip_rate'], $trip_id);
        }
       return response()->json([$response = 'result' => true, 'message' => "trip saved"]);
    }

    public static function getAllDriverInfo($driverDetail)
    {
        return self::select(
            self::driver_current_lat,
            self::driver_current_long,
            self::driver_driver_current_address,
            self::driver_driver_vehicle_type_id,
            DriverDetails::driver_driver_name,
            DriverDetails::driver_phone_number
        )
            ->join(DriverDetails::driverinfo, self::driver_id, DriverDetails::driver_id)
            ->where(self::driver_id, $driverDetail[self::driver_id])
            ->get();
    }

    public static function getDriverCurrentLatLng($request){
        return self::select(self::driver_current_lat,self::driver_current_long)->where(self::driver_id,$request[self::driver_id])->get();
    }
}
