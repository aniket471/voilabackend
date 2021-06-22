<?php

namespace App\Models\Rider;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class RiderLogin extends Model
{
    use HasFactory;

    const rider_login = 'rider_login';
    const id = 'id';
    const mobile_number = 'mobile_number';
    const rider_name = 'rider_name';
    const rider_rating = 'rider_rating';
    const api_token = 'api_token';

    const rider_rider_login = self::rider_login . AppConfig::DOT . AppConfig::STAR;
    const rider_id = self::rider_login . AppConfig::DOT . self::id;
    const rider_mobile_number = self::rider_login . AppConfig::DOT . self::mobile_number;
    const rider_rider_name = self::rider_login . AppConfig::DOT . self::rider_name;
    const rider_rider_ratingr = self::rider_login . AppConfig::DOT . self::rider_rating;
    const rider_api_token = self::rider_login . AppConfig::DOT . self::api_token;

    protected $table = self::rider_login;
    protected $primaryKey = self::id;
    public $timestamps = false;
    protected $fillable = [
        self::id,
        self::mobile_number,
        self::rider_name,
        self::rider_rating,
        self::api_token
    ];

    public static function riderLogin($request)
    {
        $mobile_number = $request[self::mobile_number];
        return self::sendOtpToRider($mobile_number);
    }

    public static function sendOtpToRider($mobile_number){
        
        $number = $mobile_number;
        $otp = self::generateTheOtp();

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

        $response =(curl_exec($curl));
    
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
          //  echo $response;
          return $response;
        }
    }

    public static function generateTheOtp(){

        $generator = "1357902468";

        $result = "";
  
        for ($i = 1; $i <= 4; $i++) {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        }
        return $result;
    }

    public static function verifyTheOtp($request){
        $session_id = $request['session_id'];
        $otp = $request['otp'];
        $curl = curl_init();

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

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
           // return $response;
           return self::createAccountToRider($request);
        }
    }

    public static function createAccountToRider($request){

          if (self::where(self::mobile_number, $request[self::mobile_number])->first()) {
            $data = self::select(self::mobile_number, self::id, self::rider_name)
                ->where(self::mobile_number, $request[self::mobile_number])
                ->get();
            return response()->json([$response = "result" => true, 'message' => "This number is already used", "data" => $data]);
        } 
        else {
            $rider_login = new self();
            $rider_login[self::mobile_number] = $request[self::mobile_number];
            $rider_login[self::rider_name] = $request[self::rider_name];

            $var = Str::random(55);

            $rider_login[self::api_token] = $var;
            $resultChecker = $rider_login->save();

            if($resultChecker){

                $data =self::select(self::mobile_number,self::rider_name,self::id)
                            ->where(self::mobile_number,$request[self::mobile_number])
                            ->get();
              //  return response()->json([$response = "result"=>true,'message'=>"Voila account created","data"=>$data]);
              return APIResponses::success_result_with_data("Voila account created successfully",$data);
            }
            else{
             //   return response()->json([$response = "result"=>false, "message"=>"Voila account created failed try again"]);
             return APIResponses::failed_result("Voila account created failed");
            }
        }
    }
}
