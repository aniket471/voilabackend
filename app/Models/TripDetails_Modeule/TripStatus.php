<?php

namespace App\Models\TripDetails_Modeule;

use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripStatus extends Model
{
    use HasFactory;

    const trip_status = 'trip_status';
    const id = 'id';
    const trip_status_id = 'trip_status_id';
    const status_s = 'status';

    const trip_trip_status = self::trip_status . AppConfig::DOT . AppConfig::STAR;
    const trip_id = self::trip_status . AppConfig::DOT . self::id;
    const trip_trip_status_id = self::trip_status . AppConfig::DOT . self::trip_status_id;
    const trip_status_s = self::trip_status . AppConfig::DOT . self::status_s;

    protected $table = self::trip_status;
    protected $fillable = [
        self::id,
        self::trip_status_id,
        self::status_s
    ];
    public $timestamps = false;
}
