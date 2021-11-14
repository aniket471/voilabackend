<?php

namespace App\Models\Rider;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use App\Models\DriverInfo\DriverDetails\DriverDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SebastianBergmann\CodeCoverage\Driver\Driver;

class RiderLogin extends Model
{
    use HasFactory;

    const rider_login = 'rider_login';
    const id = 'id';
    const mobile_number = 'mobile_number';
    const rider_name = 'rider_name';
    const rider_rating = 'rider_rating';
    const api_token = 'api_token';
    const login_status = 'login_status';
    const fcm_token = 'fcm_token';

    const rider_rider_login = self::rider_login . AppConfig::DOT . AppConfig::STAR;
    const rider_id = self::rider_login . AppConfig::DOT . self::id;
    const rider_mobile_number = self::rider_login . AppConfig::DOT . self::mobile_number;
    const rider_rider_name = self::rider_login . AppConfig::DOT . self::rider_name;
    const rider_rider_ratingr = self::rider_login . AppConfig::DOT . self::rider_rating;
    const rider_api_token = self::rider_login . AppConfig::DOT . self::api_token;
    const rider_login_status = self::rider_login . AppConfig::DOT . self::login_status;
    const rider_fcm_token = self::rider_login . AppConfig::DOT . self::fcm_token;

    protected $table = self::rider_login;
    protected $primaryKey = self::id;
    public $timestamps = false;
    protected $fillable = [
        self::id,
        self::mobile_number,
        self::rider_name,
        self::rider_rating,
        self::api_token,
        self::login_status,
        self::fcm_token
    ];

    public static function riderLogin($request)
    {

        $mobile_number = $request[self::mobile_number];
        $firebase_token = $request["firebase_token"];

        if (DriverDetails::where(DriverDetails::driver_phone_number, $mobile_number)->first()) {
            DriverDetails::updateFCMToken($firebase_token, $mobile_number);
            // return "Driver number";
            return self::sendOtpToRider($mobile_number);
        } else {
            // return "Rider number";
            return self::sendOtpToRider($mobile_number);
        }
    }

    public static function sendOtpToRider($mobile_number)
    {

      $number = $mobile_number;
        
        if($number === "9999999999"){

            if (!empty($number)) {


                $otp =  1234;
    
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://2factor.in/API/V1/06fe377d-7a20-11ea-9fa5-0200cd936042/SMS/{$number}/{$otp}",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_POSTFIELDS => "",
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/x-www-form-urlencoded"
                    ),
                ));
    
                $response = (curl_exec($curl));
                $data = array();
                $data = json_decode($response, true);
    
                $err = curl_error($curl);
    
                curl_close($curl);
    
                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    //  echo $response;
                    $status = $data["Status"];
                    $details = $data["Details"];


    
                    return response()->json([$response = "result" =>true,"message"=>"Otp send successfully", "details" => $details,"otp"=>$otp]);
                    return $response;
                }
            } else {
                return APIResponses::failed_result("Mobile number required");
            }
        }
        else{

            if (!empty($number)) {


                $otp =  AppConfig::get4DigitOtp();
    
                $curl = curl_init();
    
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "http://2factor.in/API/V1/06fe377d-7a20-11ea-9fa5-0200cd936042/SMS/{$number}/{$otp}",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_POSTFIELDS => "",
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/x-www-form-urlencoded"
                    ),
                ));
    
                $response = (curl_exec($curl));
                $data = array();
                $data = json_decode($response, true);
    
                $err = curl_error($curl);
    
                curl_close($curl);
    
                if ($err) {
                    echo "cURL Error #:" . $err;
                } else {
                    //  echo $response;
                    $status = $data["Status"];
                    $details = $data["Details"];
 
                    return response()->json([$response = "result" =>true,"message"=>"Otp send successfully", "details" => $details]);
                    return $response;
                }
            } else {
                return APIResponses::failed_result("Mobile number required");
            }
        }
    }

    public static function generateTheOtp()
    {

        $generator = "1357902468";

        $result = "";

        for ($i = 1; $i <= 4; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }
        return $result;
    }

    public static function verifyTheOtp($request)
    {
        $session_id = $request['session_id'];
        $otp = $request['otp'];
        $curl = curl_init();
        $response = array();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://2factor.in/API/V1/06fe377d-7a20-11ea-9fa5-0200cd936042/SMS/VERIFY/{$session_id}/{$otp}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = (curl_exec($curl));
        $data = array();
        $data = json_decode($response, true);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            if ($data['Status'] === "Success") {
                return self::createAccountToRider($request);
            } else {
                return APIResponses::failed_result("OTP verification failed . Please try again");
            }
        }
    }

    public static function createAccountToRider($request)
    {

        if (self::where(self::mobile_number, $request[self::mobile_number])->first()) {
            $data = self::select(self::mobile_number, self::id, self::rider_name, self::api_token)
                ->where(self::mobile_number, $request[self::mobile_number])
                ->get();

                DB::update('update rider_login set fcm_token=? where mobile_number=?',[$request[self::fcm_token],$request[self::mobile_number]]);
               
                if($data!=null){

                    $data[0][self::rider_name]??"Empty";
                    $data[0][self::mobile_number]??"Empty";
                    $data[0][self::api_token]??"Empty";

                    $resultData = [ "rider_name"=> $data[0][self::rider_name]??"Empty", "mobile_number"=> $data[0][self::mobile_number]??"Empty","api_token"=>$data[0][self::api_token]??"Empty","id"=>$data[0][self::id]??"Empty"];

     
                 return APIResponses::success_result_with_data("This is Rider Login", array($resultData));
                }
        }
         else if (DriverDetails::where(DriverDetails::driver_phone_number, $request[self::mobile_number])->first()) {

            $DriverData = DriverDetails::select(
                DriverDetails::driver_phone_number,
                DriverDetails::driver_id,
                DriverDetails::driver_driver_name,
                DriverDetails::driver_api_token
            )
                ->where(DriverDetails::driver_phone_number, $request[self::mobile_number])
                ->get();

                if($DriverData!=null){
                    
                    $resultData =["driver_name"=>$DriverData[0][DriverDetails::driver_driver_name]??"Empty",
                    "driver_id"=>$DriverData[0][DriverDetails::driver_id]??"Empty",
                    "mobile_number"=>$DriverData[0][DriverDetails::driver_phone_number]??"Empty",
                    "api_token"=>$DriverData[0][DriverDetails::driver_api_token]??"Empty"

                ];

                    return APIResponses::success_result_with_data("This is Driver Login", ($DriverData));
                }

        }
         else {

            $rider_login = new self();
            $rider_login[self::mobile_number] = $request[self::mobile_number];
            $rider_login[self::rider_name] = $request[self::rider_name];
            $rider_login[self::rider_login_status] = 1;
            $rider_login[self::fcm_token] = $request[self::fcm_token];

            $var = Str::random(55);

            $rider_login[self::api_token] = $var;
            $resultChecker = $rider_login->save();

            if ($resultChecker) {

                $data = self::select(self::mobile_number, self::rider_name, self::id, self::api_token)
                    ->where(self::mobile_number, $request[self::mobile_number])
                    ->get();

                    if($data!=null){

                        $data[0][self::rider_name]??"Empty";
                        $data[0][self::mobile_number]??"Empty";
                        $data[0][self::api_token]??"Empty";
    
                        $resultData = [ "rider_name"=> $data[0][self::rider_name]??"Empty", "mobile_number"=> $data[0][self::mobile_number]??"Empty","api_token"=>$data[0][self::api_token]??"Empty","id"=>$data[0][self::id]??"Empty"];
    
         
                     return APIResponses::success_result_with_data("Voila account created successfully", array($resultData));
                    }
            } else {

                return APIResponses::failed_result("Voila account created failed");
            }
        }
    }


    //check the user login session on splash screen
    public static function checkUserLoginSession($request)
    {
        
       // return $request[self::fcm_token];
        if(self::where(self::fcm_token,$request[self::fcm_token])->where(self::rider_id,$request[self::id]) ->first()){
            return APIResponses::success_result("Fcm find");
        }
        else{
            return APIResponses::failed_result("Invalid fcm find");
        }
    } 
}
