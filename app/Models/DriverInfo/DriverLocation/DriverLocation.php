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
        self::global_vehicle_id
    ];

    public static function insertTheCurrentLatLngForDriver($request)
    {
        $driver_location = new self();
        $driver_location[self::driver_current_lat] = $request['current_lat'];
        $driver_location[self::driver_current_long] = $request['current_long'];
        $driver_location[self::driver_current_address] = $request['current_address'];
        $result = $driver_location->save();
        if ($result) {
            $message = "Driver current latlng saved";
            return APIResponses::success_result($message);
        } else {
            $message = "Driver current not saved";
            return APIResponses::failed_result($message);
        }
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
            $value->sendData = self::sendDataForTrip($value->driver_id, $rider_id, $rider_current_lat, $rider_current_lng, $rider_dest_lat, $rider_dest_lng, $rider_current_address, $value->charges,"1250");
        }

        return response()->json([$response = 'result' => true, 'message' => "Get The Driver", "drives" => $LatLng]);
    }

    public static function getDistanceBetweenPoints($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 66 * 1.2525;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $kilometers = floor($kilometers);
        $meters = $kilometers * 1000;
        // return $kilometers;
        if ($kilometers <= 5) {
            return $kilometers;
        }
    }

    public static function getDistanceBetweenRiderToDest($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 66 * 1.2525;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $kilometers = floor($kilometers);
        $meters = $kilometers * 1000;
        return $kilometers;
    }

    public static function getDistanceBetweenRiderToDriver($lat1, $lon1, $lat2, $lon2, $driver_id)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 66 * 1.2525;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $kilometers = floor($kilometers);
        $meters = $kilometers * 1000;
        if ($kilometers <= 5 || $kilometers == 0) {
            $result = ["driver_id" => $driver_id];
            return ($driver_id);
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
    public static function sendDataForTrip($driver_id, $rider_id, $rider_current_lat, $rider_current_lng, $rider_dest_lat, $rider_dest_lng, $rider_current_address, $trip_rate, $trip_id)
    {

        $trip_details = new TripDetails();
        $trip_details[TripDetails::trip_driver_id] = $driver_id;
        $trip_details[TripDetails::trip_rider_id] = $rider_id;
        $trip_details[TripDetails::trip_rider_current_lat] = $rider_current_lat;
        $trip_details[TripDetails::trip_rider_current_lng] = $rider_current_lng;

        $trip_details[TripDetails::trip_rider_dest_lat] = $rider_dest_lat;
        $trip_details[TripDetails::trip_rider_dest_lng] = $rider_dest_lng;
        $trip_details[TripDetails::trip_rider_current_address] = $rider_current_address;
        $trip_details[TripDetails::trip_trip_rate] = $trip_rate;
        $trip_details[TripDetails::trip_trip_id] = $trip_id;
        $trip_details[TripDetails::trip_trip_status_id] = 1;

        $dataChecker = $trip_details->save();

        if ($dataChecker) {
            return response()->json([$response = 'result' => true, 'message' => "trip saved"]);
        } else {
            return response()->json([$response = 'result' => false, 'message' => "data not saved"]);
        }
    }
    public static function showAllDriver($request)
    {
        $rider_current_lat = $request['rider_current_lat'];
        $rider_current_lng = $request['rider_current_lng'];
        $rider_dest_lat = $request['rider_dest_lat'];
        $rider_dest_lng = $request['rider_dest_lng'];
        $rider_current_address = $request['rider_current_address'];
        $rider_id = $request['rider_id'];
        $vehicle_type_id = $request['vehicle_type_id'];

        $driverLocation = self::select(
            self::driver_current_lat,
            self::driver_current_long,
            self::driver_driver_id,
            DriverDetails::firebase_token
        )
            ->join(DriverDetails::driverinfo, self::driver_id, DriverDetails::driver_id)
            ->where(self::driver_global_vehicle_id, $vehicle_type_id)
            ->get();
        foreach ($driverLocation as $value) {

            $point1 = array('lat' => $value->driver_current_lat, 'long' => -$value->driver_current_long);
            $point2 = array('lat' => $rider_current_lat, 'long' => -$rider_current_lng);
            $value->distance = self::getDistanceBetweenRiderToDriver($point1['lat'], $point1['long'], $point2['lat'], $point2['long'], $value->driver_id);
            $value->notify = self::notifyToDriver($value->firebase_token);
        }
       // return $driverLocation;
        $DriverDetails = $driverLocation;

      //  return $DriverDetails;

        $newDataArray = array();
        foreach ($DriverDetails as $values) {

            if ($values['distance'] != null)
                $newDataArray[] = $values;
        }
        foreach ($newDataArray as $key => $newValue) {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $pin = mt_rand(1000000, 9999999)
                . mt_rand(1000000, 9999999)
                . $characters[rand(0, strlen($characters) - 1)];
            $trip_id = str_shuffle($pin);
           $newValue->saveTrip = self::sendDataForTrip(($newValue['driver_id']), $rider_id, $rider_current_lat, $rider_current_lng, $rider_dest_lat, $rider_dest_lng, $rider_current_address, $request['trip_rate'],$trip_id);
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
}
