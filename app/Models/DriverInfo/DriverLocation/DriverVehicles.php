<?php

namespace App\Models\DriverInfo\DriverLocation;

use App\Models\Common\AppConfig;
use App\Models\DriverInfo\DriverDetails\DriverRateCard;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\type;

class DriverVehicles extends Model
{
    use HasFactory;
    const vehicle_type = 'vehicle_type';
    const vehicle_type_id = 'vehicle_type_id';
    const vehicle_types = 'vehicle_types';
    const vehicle_rate = "vehicle_rate";
    const km          = "km";
    const status   = 'status';
    const global_vehicle_id = 'global_vehicle_id';

    const vehicle_vehicle_type = self::vehicle_type . AppConfig::DOT . AppConfig::STAR;
    const vehicle_vehicle_type_id = self::vehicle_type . AppConfig::DOT . self::vehicle_type_id;
    const vehicle_vehicle_types = self::vehicle_type . AppConfig::DOT . self::vehicle_types;
    const vehicle_vehicle_rate = self::vehicle_type . AppConfig::DOT . self::vehicle_rate;
    const vehicle_km = self::vehicle_type . AppConfig::DOT . self::km;
    const vehicle_status = self::vehicle_type . AppConfig::DOT . self::status;
    const vehicle_global_vehicle_id = self::vehicle_type . AppConfig::DOT . self::global_vehicle_id;

    protected $table = self::vehicle_type;
    public $timestamps = false;
    protected $fillable = [
        self::vehicle_type_id,
        self::vehicle_types,
        self::vehicle_rate,
        self::km,
        self::status,
        self::global_vehicle_id
    ];

    public static function getAllVehicleWithRate($request)
    {
        $CarVehicleDetails = self::select(
            self::vehicle_type_id,
            self::vehicle_types,
            self::vehicle_rate,
            DriverLocation::driver_driver_current_lat,
            DriverLocation::driver_driver_current_long,
            DriverLocation::driver_on_off_status,
            DriverLocation::driver_driver_id,
            DriverRateCard::driver_min_rate,
            DriverRateCard::driver_max_rate
        )
            ->join(DriverLocation::driver_location, self::vehicle_vehicle_type_id, DriverLocation::driver_driver_vehicle_type_id)
            ->join(DriverRateCard::driver_rate_card, DriverLocation::driver_driver_id, DriverRateCard::driver_driver_id)
            ->where(self::vehicle_type_id, 2)
            ->where(DriverLocation::driver_on_off_status, 1)
            ->get();


        foreach ($CarVehicleDetails as $key => $values) {
            $point1 = array('lat' => $request['rider_current_lat'], 'long' => -$request['rider_current_lng']);
            $point2 = array('lat' => $request['rider_dest_lat'], 'long' => -$request['rider_dest_lng']);
            $point3 = array('lat' => $values->driver_current_lat, 'long' => -$values->driver_current_long);
            $values->distance =  self::getDistanceBetweenPoints($point1['lat'], $point1['long'], $point2['lat'], $point2['long']);
            $values->charges = self::calculateTheCharges($values->vehicle_types, $values->distance);
            $values->distanceBetweenDriverToRider = self::distanceBetweenDriverToRider($point1['lat'], $point1['long'], $point3['lat'], $point3['long'], $values->driver_id);
            $values->riderCurrentLat = $request['rider_current_lat'];
            $values->riderCurrentLng = $request['rider_current_lng'];
            $values->riderDestLat = $request['rider_dest_lat'];
            $values->riderDestLng = $request['rider_dest_lng'];

            $carMinRate[] = ($values->min_rate);
            $carMaxRate[] = ($values->max_rate);

            $carMin = min($carMinRate);
            $carMax = max($carMaxRate);
        }

        $vehicleWithRate = self::select(
            self::vehicle_type_id,
            self::vehicle_types,
            DriverLocation::driver_driver_current_lat,
            DriverLocation::driver_current_long,
            DriverLocation::driver_on_off_status,
            DriverLocation::driver_driver_id,
            DriverRateCard::driver_min_rate,
            DriverRateCard::driver_max_rate
        )
            ->join(DriverLocation::driver_location, self::vehicle_vehicle_type_id, DriverLocation::driver_driver_vehicle_type_id)
            ->join(DriverRateCard::driver_rate_card, DriverLocation::driver_driver_id, DriverRateCard::driver_driver_id)
            ->where(self::status, 1)
            ->where(DriverLocation::driver_on_off_status, 1)
            ->get();

        $minRateArray = array();
        $maxRateArray = array();
        $carMinRate = array();
        $carMaxRate = array();
        $ResultArray = array();
        $vehicleTypeID = array();
        $distanceArray = array();

        foreach ($vehicleWithRate as $key => $value) {
            $point1 = array('lat' => $request['rider_current_lat'], 'long' => -$request['rider_current_lng']);
            $point2 = array('lat' => $request['rider_dest_lat'], 'long' => -$request['rider_dest_lng']);
            $point3 = array('lat' => $value->driver_current_lat, 'long' => -$value->driver_current_long);
            $value->distance =  self::getDistanceBetweenPoints($point1['lat'], $point1['long'], $point2['lat'], $point2['long']);
            // $value->charges = self::calculateTheCharges($value->vehicle_types, $value->distance);
            $value->distanceBetweenDriverToRider = self::distanceBetweenDriverToRider($point1['lat'], $point1['long'], $point3['lat'], $point3['long'], $value->driver_id);
            $value->riderCurrentLat = $request['rider_current_lat'];
            $value->riderCurrentLng = $request['rider_current_lng'];
            $value->riderDestLat = $request['rider_dest_lat'];
            $value->riderDestLng = $request['rider_dest_lng'];

            $minRateArray[] = ($value->min_rate);
            $maxRateArray[] = ($value->max_rate);
            $mina = min($minRateArray);
            $maxRate = max($maxRateArray);
            $vehicleTypeID[] = ($value->vehicle_type_id);
            $distanceArray[] = ($value->distanceBetweenDriverToRider);

            if (($key = array_search("3", $vehicleTypeID)) !== false) {
                unset($vehicleTypeID[$key]);
            }
            if (($key = array_search("4", $vehicleTypeID)) !== false) {
                unset($vehicleTypeID[$key]);
            }


            $MyDistanceArray = array_filter($distanceArray);
            $UniqueVehicleType = ($vehicleTypeID);
        }
        $ResultArray = array(["min" => $mina, "max" => $maxRate, "carMin" => $carMin, "carMax" => $carMax]);


        return response()->json([$response = 'result' => true, 'message' => "Rates Available", "vehicleRates" => $ResultArray, "vehicleType_Id" => ($UniqueVehicleType)]);
    }
    public static function dd($km)
    {
        return $km;
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
        return $kilometers;
        // if($kilometers<=6){
        //     return $kilometers;
        // }


    }
    public static function calculateTheCharges($driver_vehicle, $distance)
    {
        if ($driver_vehicle == "Rikshow") {
            $calculate = $distance * 15;
            return $calculate;
        } else if ($driver_vehicle == "mini car") {
            $calculate = $distance * 60;
            return $calculate;
        } elseif ($driver_vehicle == "sedan") {
            $calculate = $distance * 120;

            return $calculate;
        } elseif ($driver_vehicle == "bike") {
            $calculate = $distance * 10;
            return $calculate;
        } else {
            return $driver_vehicle;
        }
    }
    public static function distanceBetweenDriverToRider($lat1, $lon1, $lat2, $lon2, $driver_id)
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
        if ($kilometers <= 5 || $kilometers === 0) {

            return $driver_id;
        }
    }

    public static function getMinRate($driver_id)
    {
        return $data = DriverLocation::select(DriverLocation::driver_driver_current_lat)
            ->where(DriverLocation::driver_driver_id, $driver_id)
            ->get();
    }


    public static function getVehicle($request)
    {

        $getVId = DriverLocation::select(
            DriverLocation::driver_driver_current_lat,
            DriverLocation::driver_driver_current_long,
            DriverLocation::driver_global_vehicle_id,
            DriverLocation::driver_driver_id,
            DriverRateCard::driver_min_rate,
            DriverRateCard::driver_max_rate
        )
            ->join(DriverRateCard::driver_rate_card, DriverLocation::driver_driver_id, DriverRateCard::driver_driver_id)
            ->where(DriverLocation::driver_on_off_status, 1)
            ->get();

        $newData = array();
        $minRateArray = array();
        $maxRateArray = array();
                    
        foreach ($getVId as $key => $value) {
            $point1 = array('lat' => $request['rider_current_lat'], 'long' => -$request['rider_current_lng']);
            $point3 = array('lat' => $value->driver_current_lat, 'long' => -$value->driver_current_long);
            $value->distance = self::distanceBetweenDriverToRider($point1['lat'], $point1['long'], $point3['lat'], $point3['long'], $value->driver_id);
        }
        $gh = $getVId;

        foreach ($gh as $key => $v) {
            if ($v->distance !== null) {

                // $v->hj  = DriverRateCard::select(
                //     DriverRateCard::driver_min_rate,
                //     DriverLocation::driver_global_vehicle_id,
                //     DriverLocation::driver_driver_id,
                //     DriverRateCard::driver_max_rate
                // )
                //     ->join(DriverLocation::driver_location, DriverRateCard::driver_driver_id, DriverLocation::driver_driver_id)
                //     ->where(DriverRateCard::driver_driver_id, $v->driver_id)
                //     ->where(DriverLocation::driver_driver_id,$v->driver_id)
                //     ->get();

                $newData[] = $v;
                $temp = array_unique(array_column($newData, 'global_vehicle_id'));
                $unique_arr = array_intersect_key($newData, $temp);
                $small[]['ve'] = $v->global_vehicle_id;
               // $small[]['ve'] = $v->driver_id;
               $driver_ids[]["driver_id"]  = $v->driver_id;

            }

           
        }
        $fillArray = array_filter(($small));
        //return $fillArray;
        $vehicleType2Avail = 0 ;
        foreach($fillArray as $key => $vf){
            if($vf['ve']  ==1){
            $vehicleType1Avail = "1";
            }
            elseif($vf['ve'] ===2){
            $vehicleType2Avail = "2";
            }           
        } 

        // return array($vehicleType1Avail,$vehicleType2Avail);

        foreach ($newData as $key => $values) {
            if ($values->global_vehicle_id === 1)
                $minRateArray[] = ($values->min_rate);
            $maxRateArray[] = ($values->max_rate);
            $mina = min($minRateArray);
            $max = max($maxRateArray);

            if ($values->global_vehicle_id === 2)
            $carMinRate = array();
            $carMaxRate = array();
            $carMinRate[] = ($values->min_rate);
            $carMaxRate[] = ($values->max_rate);
            $carMin = min(($carMinRate));
            $carMax = max($carMaxRate);
            $vehicleTypeID[] = $values->global_vehicle_id;

            $rider_current_lat =$request['rider_current_lat'];
            $rider_current_lng = $request['rider_current_lng'];
            $rider_dest_lat = $request['rider_dest_lat'];
            $rider_dest_lng = $request['rider_dest_lng'];
            $result = ["min"=>$mina,"max"=>$max,"carMin"=>$carMin,"carMax"=>$carMax, "rider_current_lat"=>$rider_current_lat,
                        "rider_current_lng"=>$rider_current_lng,"rider_dest_lat"=>$rider_dest_lat,
                        "vehicle"=>$vehicleType1Avail,
                        "secondVehicle"=>$vehicleType2Avail,
                        "rider_dest_lng"=>$rider_dest_lng ,"vehicleTyep" =>($small)];
        }
        return response()->json([$response = 'result'=>true,'message'=>"Vehicle","vehicleData"=>array($result)]);

    }
}
