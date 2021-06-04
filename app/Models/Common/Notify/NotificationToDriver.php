<?php

namespace App\Models\Common\Notify;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class NotificationToDriver extends Model
{
    use HasFactory;

    public static function notifyToDriver($token){
    //  echo 'Hello';
      if (!defined('API_ACCESS_KEY')) define( 'API_ACCESS_KEY', 'AAAAisOCRZ0:APA91bGxSJ54v7pnoSDnmLM0u3dQD52-pxF9IPbAbvQql6Iv9wIQ8qiNzImNN6v2e1_SO__LVnwhwS0q_QLffnPUV9OTSVg3pj_tK_NE0r4X3T0TaOsZqMm02BhiERdlhGoPuAlCtt3R');
    // if (!defined('constant')) define('constant', 'value');
      //   $registrationIds = ;
#prep the bundle
     $msg = array
          (
		'body' 	=> 'This is notification for voila caps',
		'title'	=> 'Voila group',
             	
          );
	$fields = array
			(
				'to'		=> $token,
				'notification'	=> $msg
			);
	
	
	$headers = array
			(
				'Authorization: key=' . API_ACCESS_KEY,
				'Content-Type: application/json'
			);
#Send Reponse To FireBase Server	
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
	//	echo $result;
	return $result;
		curl_close( $ch );
 }

}
