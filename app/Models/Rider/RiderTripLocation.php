<?php

namespace App\Models\Rider;

use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderTripLocation extends Model
{
    use HasFactory;
    const rider_trip_location = 'rider_trip_location';
    const rider_id = 'rider_id';
    const rider_current_lat = 'rider_current_lat';
    const rider_current_long = 'rider_current_long';
    const rider_dest_lat = 'rider_dest_lat';
    const rider_dest_long = 'rider_dest_long';
    const rider_current_address = 'rider_current_address';
    const rider_destination_address  = 'rider_destination_address';
    const distance = 'distance';

    const rider_rider_trip_location = self::rider_trip_location . AppConfig::DOT . AppConfig::STAR;
    const rider_rider_id = self::rider_trip_location . AppConfig::DOT . self::rider_id;
    const rider_rider_current_lat = self::rider_trip_location . AppConfig::DOT . self::rider_current_lat;
    const rider_rider_current_long = self::rider_trip_location . AppConfig::DOT . self::rider_current_long;
    const rider_rider_dest_lat = self::rider_trip_location . AppConfig::DOT . self::rider_dest_lat;
    const rider_rider_dest_long = self::rider_trip_location . AppConfig::DOT . self::rider_dest_long;
    const rider_rider_current_address = self::rider_trip_location . AppConfig::DOT . self::rider_current_address;
    const rider_rider_destination_address = self::rider_trip_location . AppConfig::DOT . self::rider_destination_address;
    const rider_distance = self::rider_trip_location . AppConfig::DOT . self::distance;

    protected $table = self::rider_trip_location;
    public $timestamps = false;
    protected $fillable = [
        self::rider_id,
        self::rider_current_lat,
        self::rider_current_long,
        self::rider_dest_lat,
        self::rider_dest_long,
        self::rider_current_address,
        self::rider_destination_address,
        self::distance
    ];

  
}
