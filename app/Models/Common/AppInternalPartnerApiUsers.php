<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppInternalPartnerApiUsers extends Model
{
    use HasFactory;

    const driverinfo = 'driverinfo';
    const driverinfo_all = self::driverinfo . AppConfig::DOT . AppConfig::STAR;

    protected $table = self::driverinfo;
}
