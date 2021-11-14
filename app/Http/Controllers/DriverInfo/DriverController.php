<?php

namespace App\Http\Controllers\DriverInfo;

use App\Http\Controllers\Controller;
use App\Models\Common\Notify\NotificationToDriver;
use App\Models\DriveInfo\DriverInfoModel;
use App\Models\DriverInfo\DriverDetails\DriverDetails;
use App\Models\DriverInfo\DriverLocation\DriverVehicles;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

class DriverController extends Controller
{
   public function driverLogin(Request $request){
       return DriverDetails::driverLogin($request);
   }

   public function sendNotificationNew(){
       
      $tokens = "ckcqwRPGS6iqo4DU12EC4C:APA91bGszSgm86vVwytmYhrb4KW2NqJplODvL6Ul1bKm-2P3zZfStDz1dTCSkdC_RlIlrUiai7SimGAKnyj6Mdubr0Kulb0KR2Z1GAn3_Nohjw2nnKo_ZvUDce8YmVRWrUzkFiUWKutn";
      $title = "Voila test notification";
      $content = "This is test voila Aniket";
      $page = "home";
      $receiveTypeID = 1;
      $data [] = ['ANiket','Suryawanshi'];
       return NotificationToDriver::sendNotification($tokens,$title,$content,$page,$receiveTypeID,$data);
   }

   public static function notifyUser(Request $request){
    return NotificationToDriver::notifyToDriver($request);
 }

    //get a all global vehicles which is in currently present in riders 5km radius with rate 
 public static function getVehicle(Request $request){
     return DriverVehicles::getVehicle($request);
 }
 //this api only for ios
 public static function getVehicles(Request $request){
     return DriverVehicles::getVehicles($request);
 }
}
