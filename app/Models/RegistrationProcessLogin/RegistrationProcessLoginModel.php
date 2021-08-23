<?php

namespace App\Models\RegistrationProcessLogin;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use App\Models\Rider\RiderLogin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class RegistrationProcessLoginModel extends Model
{
    use HasFactory;

    const  registration_process_login = 'registration_process_login';
    const  id = 'id';
    const  mobile_number = 'mobile_number';
    const  api_token = 'api_token';
    const  fcm_token = 'fcm_token';
    const  auth_token = 'auth_token';

    const registration_process_login_all = self::registration_process_login . AppConfig::DOT . AppConfig::STAR;
    const registration_user_id = self::registration_process_login . AppConfig::DOT . self::id;
    const registration_mobile_number = self::registration_process_login . AppConfig::DOT . self::mobile_number;
    const registration_api_token = self::registration_process_login . AppConfig::DOT . self::api_token;
    const registration_fcm_token = self::registration_process_login . AppConfig::DOT . self::fcm_token;
    const registration_auth_token = self::registration_process_login . AppConfig::DOT . self::auth_token;

    protected $table = self::registration_process_login;
    protected $fillable = [
        self::mobile_number,
        self::api_token,
        self::fcm_token,
        self::auth_token
    ];

    public $timestamps = true;


    //registration process login 
    public static function registrationProcessLogin($request)
    {

        $validator = Validator::make($request->all(), [
            self::mobile_number => 'required'
        ]);

        if ($validator->fails()) {

            return APIResponses::failed_result("Mobile number is required to login..");
        } else {

            if (self::where(self::mobile_number, $request[self::mobile_number])->first()) {

                return RiderLogin::sendOtpToRider($request[self::mobile_number]);
            } else return RiderLogin::sendOtpToRider($request[self::mobile_number]);
        }
    }

    public static function verifyOtp($request)
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
                return self::checkAccountDetails($request);
            } else {
                return APIResponses::failed_result("OTP verification failed . Please try again");
            }
        }
    }

    //to check the account details for login or new account
    public static function checkAccountDetails($request)
    {

        if (self::where(self::mobile_number, $request[self::mobile_number])->first()) {
            return self::loginUser($request);
        } else return self::registerTheUser($request);
    }

    //login the user account \
    public static function loginUser($request)
    {

        $validator = Validator::make($request->all(), [
            self::mobile_number => 'required'

        ]);

        if ($validator->fails()) {
            return  APIResponses::failed_result("Please provide all fields all are required");
        } else {

            $userDetails = self::select(
                self::id,
                self::mobile_number,
                self::auth_token,
                self::api_token
            )
                ->where(self::mobile_number, $request[self::mobile_number])
                ->get();
            if (!empty($userDetails))
                return APIResponses::success("Login Successfully", "userDetails", $userDetails);
            else return APIResponses::failed_result("Login failed please try again");
        }
    }

    //register the user
    public static function registerTheUser($request)
    {
        $addUser = new self();

        $validator = Validator::make($request->all(), [
            self::mobile_number => 'required',
            self::fcm_token => 'required'

        ]);

        if ($validator->fails()) {
            return  APIResponses::failed_result("Please provide all fields all are required");
        } else {

            $addUser[self::mobile_number] = $request[self::mobile_number];
            $addUser[self::fcm_token] = $request[self::fcm_token];

            $api_token = Str::random(55);

            $auth_token = Str::random(60);

            $addUser[self::api_token] = $api_token;
            $addUser[self::auth_token] = $auth_token;

            $result = $addUser->save();
            $user_id = $addUser->id;

            $userDetails = ["id" => $user_id, "mobile_number" => $request[self::mobile_number], "api_token" => $api_token, "auth_token" => $auth_token];

            if ($result) return APIResponses::success("Account created successfully", "userDetails", $userDetails);
            else return APIResponses::failed_result("something went wrong please try again");
        }
    }
}
