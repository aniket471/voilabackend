<?php

namespace App\Models\DriverInfo\DriverDetails;

use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver_Status extends Model
{
    use HasFactory;

    const driver_status = 'driver_on_off_status';
    const driver_status_id = 'driver_status_id';
    const driver_on_off_status = 'driver_status';

    const driver_driver_status = self::driver_status . AppConfig::DOT . AppConfig::STAR;
    const driver_driver_status_id = self::driver_status . AppConfig::DOT . self::driver_driver_status_id;
    const driver_driver_on_off_status = self::driver_status . AppConfig::DOT . self::driver_on_off_status;

    protected $table = self::driver_status;
    protected $fillable = [

        self::driver_status_id,
        self::driver_status
    ];
    public $timestamps = false;

}
