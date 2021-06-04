<?php

namespace App\Models\Rider;

use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

        $mobile_number = $request['mobile'];

        if (self::where(self::mobile_number, $request['mobile'])->first()) {
            $data = self::select(self::mobile_number, self::id, self::rider_name)
                ->where(self::mobile_number, $mobile_number)
                ->get();
            return response()->json([$response = "result" => true, 'message' => "This number is already used", "data" => $data]);
        } else {
            $rider_login = new self();
            $rider_login[self::mobile_number] = $request['mobile'];
            $rider_login[self::rider_name] = $request['name'];

            // Available alpha caracters
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

            // generate a pin based on 2 * 7 digits + a random character
            $pin = mt_rand(1000000, 9999999)
                . mt_rand(1000000, 9999999)
                . $characters[rand(0, strlen($characters) - 1)];

            // shuffle the result
            $string = str_shuffle($pin);

            $rider_login[self::api_token] = $string;

            $resultChecker = $rider_login->save();

            if($resultChecker){

                $data =self::select(self::mobile_number,self::rider_name,self::id)
                            ->where(self::mobile_number,$mobile_number)
                            ->get();
                return response()->json([$response = "result"=>true,'message'=>"Voila account created","data"=>$data]);
            }
            else{
                return response()->json([$response = "result"=>false, "message"=>"Voila account created failed try again"]);
            }
        }
    }
}
