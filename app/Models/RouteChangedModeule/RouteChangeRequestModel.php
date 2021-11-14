<?php

namespace App\Models\RouteChangedModeule;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RouteChangeRequestModel extends Model
{
    use HasFactory;

    const  route_change_request  = 'route_change_request';
    const rider_id = 'rider_id';
    const driver_id = 'driver_id';
    const requested_id = 'requested_id';
    const trip_id = 'trip_id';
    const current_distance = 'current_distance';
    const request_status_id = 'request_status_id';

    const route_change_request_all = self::route_change_request . AppConfig::DOT . AppConfig::STAR;
    const route_change_request_rider_id =  self::route_change_request . AppConfig::DOT . self::rider_id;
    const route_change_request_driver_id = self::route_change_request . AppConfig::DOT . self::driver_id;
    const route_change_request_trip_id = self::route_change_request . AppConfig::DOT . self::trip_id;
    const route_change_request_current_distance = self::route_change_request . AppConfig::DOT . self::current_distance;
    const route_change_request_request_status_id = self::route_change_request . AppConfig::DOT . self::request_status_id;

    protected $table = self::route_change_request;
    protected $fillable = [
        self::rider_id,
        self::driver_id,
        self::requested_id,
        self::trip_id,
        self::current_distance,
        self::request_status_id,
    ];

    public $timestamps = false;

    //when the both user apply for change request this fun call for driver and rider
    public static function requestToChangedRoute($request)
    {

      $routeChanged = new self();

        $routeChanged[self::rider_id] = $request[self::rider_id];
        $routeChanged[self::driver_id] = $request[self::driver_id];
        $routeChanged[self::current_distance] = $request[self::current_distance]??0;
        $routeChanged[self::requested_id] = $request[self::requested_id];
        $routeChanged[self::trip_id] = $request[self::trip_id];
        $routeChanged[self::request_status_id]  = 0;

        $result = $routeChanged->save();
        if ($result)
            return APIResponses::success_result("Request send Successfully");
        else
            return APIResponses::failed_result("Request not send please try again");
    }

    //check the client site the request get or not
    public static function checkTheRouteChangeRequest($request)
    {
        if (self::where(self::requested_id, $request["checker_id"])->first()) {
            return APIResponses::success_result("New Route change request");
        } else {
            return APIResponses::failed_result("ID not matched");
        }
    }

    //accept the change route request
    public static function acceptTheChangeRouteRequest($request)
    {
        $checkerId = $request["checker_id"];
        if (self::where(self::requested_id, $checkerId)->where(self::request_status_id, 0)->first()) {
            $updateRequestStatus = DB::update('update route_change_request set request_status_id=? where requested_id=?', [1, $checkerId]);
            if ($updateRequestStatus)
                return APIResponses::success_result_with_data("Request accepted successfully", $checkerId);
            else
                return APIResponses::failed_result_with_data("Request not accepted,try again", $checkerId);
        }
        else{
            return APIResponses::failed_result("Request  Accept failed");
        }
    }
}
