<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppIntenalApiUsers extends Model
{
    use HasFactory;
    const rider_login = 'rider_login';
    const rider_login_all = self::rider_login . AppConfig::DOT . AppConfig::STAR;
    protected $table = self::rider_login;
}
