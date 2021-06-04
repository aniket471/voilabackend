<?php

namespace App\Models\DriverInfo\DriverDetails;

use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverRateCard extends Model
{
    use HasFactory;
    const driver_rate_card = 'driver_rate_card';
    const driver_id = 'driver_id';
    const min_rate = 'min_rate';
    const max_rate = 'max_rate';
    const system_rate = "system_rate";

    const driver_driver_rate_card = self::driver_rate_card . AppConfig::DOT . AppConfig::STAR;
    const driver_driver_id = self::driver_rate_card . AppConfig::DOT . self::driver_id;
    const driver_min_rate = self::driver_rate_card . AppConfig::DOT . self::min_rate;
    const driver_max_rate = self::driver_rate_card . AppConfig::DOT . self::max_rate;
    const driver_system_rate = self::driver_rate_card . AppConfig::DOT . self::system_rate;

    protected $table = self::driver_rate_card;
    protected $fillable = [
        self::driver_id,
        self::min_rate,
        self::max_rate,
        self::system_rate
    ];

    
}
