<?php

namespace App\Models\DriveInfo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Common\AppConfig;
use Illuminate\Cache\ApcStore;

class DriverInfoModel extends Model
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
        self::api_token
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

    
}
