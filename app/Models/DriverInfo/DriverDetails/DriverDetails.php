<?php

namespace App\Models\DriverInfo\DriverDetails;

use App\Models\Common\APIResponses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Common\AppConfig;
use Illuminate\Support\Facades\DB;

class DriverDetails extends Model
{
    use HasFactory;
    const driverinfo = 'driverinfo';
    const id = 'id';
    const phone_number = 'phone_number';
    const driver_name = 'driver_name';
    const email = 'email';
    const current_address = 'current_address';
    const vehicle_reg_number = 'vehicle_reg_number';
    const rc = 'rc';
    const vehicle_color = 'vehicle_color';
    const vehicle_model = 'vehicle_model';
    const make_year = 'make_year';
    const vehicle_type = 'vehicle_type';
    const api_token = 'api_token';
    const firebase_token = 'firebase_token';
    const driver_ratings = 'driver_ratings';
    const global_vehicle_id = 'global_vehicle_id';

    
    const driver_driverinfo_all =self::driverinfo . AppConfig::DOT . AppConfig::STAR;
    const driver_id = self::driverinfo . AppConfig::DOT . self::id;
    const driver_phone_number = self::driverinfo . AppConfig::DOT . self::phone_number;
    const driver_driver_name = self::driverinfo . AppConfig::DOT . self::driver_name;
    const driver_email = self::driverinfo .AppConfig::DOT . self::email;
    const driver_current_address = self::driverinfo . AppConfig::DOT . self::current_address;
    const driver_vehicle_reg_number = self::driverinfo . AppConfig::DOT . self::vehicle_reg_number;
    const driver_rc = self::driverinfo . AppConfig::DOT . self::rc;
    const driver_vehicle_color = self::driverinfo . AppConfig::DOT . self::vehicle_color;
    const driver_vehicle_model = self::driverinfo . AppConfig::DOT . self::vehicle_model;
    const driver_make_year = self::driverinfo . AppConfig::DOT . self::make_year;
    const driver_vehicle_type = self::driverinfo . AppConfig::DOT . self::vehicle_type;
    const driver_api_token = self::driverinfo . AppConfig::DOT . self::api_token;
    const driver_firebase_token = self::driverinfo . AppConfig::DOT . self::firebase_token;
    const driver_driver_ratings = self::driverinfo . AppConfig::DOT . self::driver_ratings;
    const driver_global_vehicle_id = self::driverinfo . AppConfig::DOT  . self::global_vehicle_id;

    protected $table = self::driverinfo;
    protected $primaryKey=self::id;
	public $timestamps=false;
    protected $fillable = [
        self::id,
        self::phone_number,
        self::email,
        self::driver_name,
        self::current_address,
        self::vehicle_reg_number,
        self::rc,
        self::vehicle_color,
        self::vehicle_model,
        self::make_year,
        self::vehicle_type,
        self::api_token,
        self::firebase_token,
        self::driver_ratings,
        self::global_vehicle_id,
    ];

    public static function driverRegistration($request){
        $driverinfo = new self();
        if($driverinfo::where(self::phone_number,'=',$request['phone_number'])->where(self::rc,$request['rc'])->first()){
            return response()->json([$response = 'result'=>false, 'message'=>'Account find']);
        }
        else{
            
            $driverinfo[self::phone_number]=$request['phone_number'];
            $driverinfo[self::email]=$request['email'];
            $driverinfo[self::current_address]=$request['current_address'];
            $driverinfo[self::vehicle_reg_number]=$request['vehicle_reg_number'];
            $driverinfo[self::rc]=$request['rc'];
            $driverinfo[self::vehicle_color]=$request['vehicle_color'];
            $driverinfo[self::vehicle_model]=$request['vehicle_model'];
            $driverinfo[self::make_year]=$request['make_year'];
            $driverinfo[self::vehicle_type]=$request['vehicle_type'];
            $driverinfo[self::api_token]=$request['api_token'];
            $driverinfo->save();
            return "Data update";
        }
       
    }

    public static function driverLogin($request){
        $driverDetails = new self();
        if(self::where(self::driver_phone_number,$request['mobile'])->first()){
            
            $loginData = self::select(self::driver_id)->where(self::driver_phone_number,$request['mobile'])->get();

            $driverDetails[self::driver_firebase_token] = $request['fcm_token'];
            $result = DB::update('update driverinfo set firebase_token = ? where phone_number = ?',[$request['fcm_token'],$request['mobile']]);
            if($result){
                return response()->json([$response = "result"=>true,"message"=>"fcm updated","LoginData"=>$loginData]);
            }
            else{
               return response()->json([$response = "result"=>false,"message"=>"fcm not update","LoginData"=>$loginData]);
            }
        }
        else{
            $message = "This mobile number not find";
            return APIResponses::failed_result($message);
        }
    }

    public static function updateTheDriverRatings($request){

        $getRatings = self::select(self::driver_ratings)->where(self::id,$request['driver_id'])->get();

        $addNewRating = $getRatings[0]["driver_ratings"] + $request[self::driver_ratings];
    
        $updateRatings = DB::update('update driverinfo set driver_ratings=? where id=?',[$addNewRating,$request['driver_id']]);

        if($updateRatings){
            return 1;
        }
        else{
            return 0;
        }
    }

    //driver rating need driver_id
    public static function getADriverRating($request){

       // PlaceRating::where('place_id',$id)->selectRaw('SUM(rating)/COUNT(user_id) AS avg_rating')->first()->avg_rating;
        $driverRating = self::where(self::id,$request["driver_id"])->pluck(self::driver_ratings)->avg();
        $rateArray =[];
        foreach ($driverRating as $rate)
        {
            $rateArray[]= $rate['driver_ratings'];
        }

         $sum = array_sum($rateArray);
         $result = $sum/count($rateArray);

        return $result;
    }

    public static function getDriverVehicleData($request){

        return self::select(self::vehicle_type,self::global_vehicle_id)->where(self::id,$request["driver_id"])->get();
    }

   //if the login is driver then update the fcm token
     public static function updateFCMToken($firebase_token,$mobile_number){
        DB::update('update driverinfo set firebase_token=? where phone_number=?',[$firebase_token,$mobile_number]);
    }
}
