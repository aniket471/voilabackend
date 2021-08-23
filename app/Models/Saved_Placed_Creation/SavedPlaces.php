<?php

namespace App\Models\Saved_Placed_Creation;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Sabberworm\CSS\Property\Selector;

class SavedPlaces extends Model
{
    use HasFactory;

    const saved_places = 'saved_places';
    const rider_id = 'rider_id';
    const address = 'address';
    const lat = 'lat';
    const lng = 'lng';

    const saved_places_all = self::saved_places . AppConfig::DOT . self::saved_places;
    const saved_places_rider_id = self::saved_places . AppConfig::DOT . self::rider_id;
    const saved_places_address = self::saved_places . AppConfig::DOT . self::address;
    const saved_places_lat = self::saved_places . AppConfig::DOT . self::lat;
    const saved_places_lng = self::saved_places . AppConfig::DOT . self::lng;

    protected $table = self::saved_places;
    protected $fillable = [
        self::rider_id,
        self::address,
        self::lat,
        self::lng
    ];

    public $timestamps =false;

    //add saved places
    public static function savedPlaces($request){

        $savedPlace = new self();

        $savedPlace[self::rider_id] = $request[self::rider_id];
        $savedPlace[self::address] = $request[self::address];
        $savedPlace[self::lat] = $request[self::lat];
        $savedPlace[self::lng] = $request[self::lng];

        $result = $savedPlace->save();
        if($result){
            return APIResponses::success_result("Placed Saved Successfully");
        }
        else{
            return APIResponses::failed_result("Placed not saved");
        }
    }

    //get saved placed
    public static function getSavedPlaces($request){
    
        if(self::where(self::rider_id,$request[self::rider_id])){
            $savedPlace = self::select(self::address,self::lat,self::lng)->where(self::rider_id,$request[self::rider_id])->get();

            return response()->json([$response = "result"=>true , "message"=>"Saved placed found","placed"=>$savedPlace]);
        }
        else{
            return APIResponses::failed_result("rider id not matched");
        }
       
    }
}
