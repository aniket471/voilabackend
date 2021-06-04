<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppConfig extends Model
{
    use HasFactory;
    const WRONG_PARAM = array(array('error' => 'wrong parameters'));


	const DASH = "-";
	const dateTime = 'M d, Y h:i a';
	const time = 'h:i a';
	const date = 'M d, Y';
	const DDMMMYYY = 'd M Y';
	const SUCCESS = 'success';
	const FAILURE = 'failure';
	const OTP = 'otp';
	const ERROR = 'error';
	const NO_DATA = 'no Data';
	const NOT_FOUND = 'not found!';
	const OBJECT_NOT_FOUND = 'Object not found!';
	const WENT_WRONG = 'Something wen\'t  wrong!';
	const LOCAL_DATE_FORMAT = '"%d %b %Y %h:%i %p"';
	const DATE_FORMAT = 'date_format';
	const CONCAT = 'CONCAT';
	const CONCAT_WS = 'CONCAT_WS';
	const TIMEDIFF = 'TIMEDIFF';
	const TIME_FORMAT = 'TIME_FORMAT';
	const SPACE = '," ",';
	const BLANK_SPACE = ' ';
	const DOUBLE_QUOTE = '"';
	const _AS = ' as ';
	const COMMA = ',';
	const COLLATE = 'COLLATE';
	const LOWER = 'LOWER';
	const LIKE = 'LIKE';
	const UPPER = 'UPPER';
	const PERCENT = '%';
	const LEFT_BR = '(';
	const RIGHT_BR = ')';
	const TOTAL = 'Total';
	const MULTIPLY = '*';
	const DIVIDE = '/';
	const F_SLASH = '/';
	const SLASH_URL = '"/"';

	const ADD = '+';
	const SUBTRACT = '-';

	const ALL = 'all';
	const ADMIN = 'admin';
	const DESC = 'desc';
	const EQUAL_TO = '=';

	const DOT = '.';
	const STAR = '*';

	const filter_text = "filter_text";

	const field_name = "field_name";
	const field_value = "field_value";


	const wentWrong = "Something wen't wrong !";
	const unauthorised = "You have unauthorised Access !";


	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
	}

	public static function setTimestamps(&$array)
	{
		$now = Carbon::now();
		$array[self::CREATED_AT] = $now;
		$array[self::UPDATED_AT] = $now;
	}
	public static function multiplyColumns($column1, $column2, $asName)
	{
		$sql = AppConfig::LEFT_BR;

		$sql .= $column1 . AppConfig::MULTIPLY . $column2;
		$sql .= AppConfig::RIGHT_BR . AppConfig::_AS . $asName;
		return DB::raw($sql);
	}


	static function array_value_recursive($key, array $arr)
	{
		$val = array();
		array_walk_recursive($arr, function ($v, $k) use ($key, &$val) {
			if ($k == $key) array_push($val, $v);
		});
		return count($val) > 0 ? $val : array_pop($val);
	}

	public static function photoUrlConcat(array $columns = [])
	{
		$start = self::CONCAT . self::LEFT_BR . self::DOUBLE_QUOTE . $columns[0] . self::DOUBLE_QUOTE . self::COMMA
			. $columns[1] . self::RIGHT_BR . self::_AS . $columns[2];
		$end = '';

		return DB::raw($start);
	}
	public static function photoUrlConcatEvent(array $columns = [])
	{
		$start = self::CONCAT . self::LEFT_BR . self::DOUBLE_QUOTE . $columns[0] . self::DOUBLE_QUOTE . self::COMMA
			. $columns[2] . self::COMMA . self::DOUBLE_QUOTE . self::F_SLASH . self::DOUBLE_QUOTE . self::COMMA . $columns[1] . self::RIGHT_BR . self::_AS . $columns[3];

		$end = '';

		return DB::raw($start);
	}

	public static function reColumn($columnName, $asName)
	{
		return DB::raw(self::LEFT_BR . $columnName . self::RIGHT_BR . self::_AS . $asName);
	}

	public static function toLowerLikeTextConcat($columnName)
	{
		return self::PERCENT . $columnName . self::PERCENT . self::SPACE . self::COLLATE;
	}
	public static function toLowerLikeSearchConcat($columnName, $text)
	{
		return DB::raw(AppConfig::LOWER . self::LEFT_BR . $columnName . self::RIGHT_BR . self::BLANK_SPACE . self::LIKE . AppConfig::BLANK_SPACE . AppConfig::LOWER . self::LEFT_BR . self::DOUBLE_QUOTE . self::PERCENT . $text . self::PERCENT . self::DOUBLE_QUOTE . self::RIGHT_BR);
	}

	public static function concat(array $columns = [])
	{
		$length = count($columns);
		$start = self::CONCAT . self::LEFT_BR;
		$end = '';
		if ($length >= 3) {
			for ($i = 0; $i < $length; $i++) {
				if ($length - 1 != $i) {
					$end .= 'COALESCE(' . $columns[$i] . ',\'\')';

					if ($length - 2 != $i) {
						$end .= self::SPACE;
					}
				} else {
					$end .= self::RIGHT_BR . self::_AS . $columns[$i];
				}
			}
			return DB::raw($start . $end);
		}

		return $end;
	}

	public static function urlConcat(array $columns = [])
	{

		$length = count($columns);
		$start = self::CONCAT . self::LEFT_BR;
		$end = '';
		if ($length >= 3) {
			for ($i = 0; $i < $length; $i++) {

				if ($length - 1 != $i) {

					if ($length - 2 == $i) {
						$end .= self::COMMA;
					}
					$end .= $columns[$i];
				} else {
					$end .= self::RIGHT_BR . self::_AS . $columns[$i];
				}
			}
			return DB::raw($start . $end);
		}

		return $end;
	}

	public static function dateTime($date)
	{
		return Carbon::parse($date)->format(self::dateTime);
	}

	public static function date($date)
	{
		return Carbon::parse($date)->format(self::date);
	}

	public static function time($date)
	{
		return Carbon::parse($date)->format(self::time);
	}
	public static function dateDDMMMYYYY($date)
	{
		return Carbon::parse($date)->format(self::DDMMMYYY);
	}

	public static function diffForHumans($date)
	{
		$date = new Carbon($date);
		return $date->diffForHumans(Carbon::now());
	}

	public static function diffInHours($date)
	{
		$date = new Carbon($date);
		return $date->diffInHours(Carbon::now());
	}

	public static function trimStr($nm)
	{
		$s = trim(preg_replace("/ {2,}/", " ", $nm));
		return ucfirst(strtolower($s));
	}

	public static function getName($nm)
	{
		$exp = explode(" ", AppConfig::trimStr($nm));
		$size = sizeof($exp);

		switch ($size) {

			case $size == 3:
				$exp[1] = $exp[2];
				return $exp;
				break;

			case $size > 3:
				$exp[1] = array_pop($exp); //GETS LAST NAME
				$exp[0] = implode(" ", $exp); //GET REST AS FIRST NAME
				return $exp;
				break;

			case $size == 1:
				$exp[1] = '';
				return $exp;
				break;

			default:
				return $exp;
		}
	}

	static function custom_number_format($n, $precision = 2)
	{
		//		if ($n < 999) {
		//			// Default
		//			$n_format = number_format($n);
		//		} else if ($n < 999999) {
		//			// Thausand
		//			$n_format = number_format($n / 1000, $precision). ' K';
		//		} else if ($n < 999999999) {
		//			// Million
		//			$n_format = number_format($n / 1000000, $precision). ' M';
		//		} else if ($n < 99999999999) {
		//			// Billion
		//			$n_format = number_format($n / 1000000000, $precision). ' B';
		//		} else {
		//			// Trillion
		//			$n_format = number_format($n / 1000000000000, $precision). ' T';
		//		}

		// Million
		$n_format = number_format($n / 10000000, $precision) . ' Cr';

		return $n_format;
	}


	static function getZeroPaddedNo1000($count)
	{
		$val = '';
		if ($count < 10) {
			$val = "000" . $count;
		} else if ($count >= 10 && $count < 100) {
			$val = "00" . $count;
		} else if ($count >= 100 && $count < 1000) {
			$val = "0" . $count;
		} else $val = $count;

		return $val;
	}
	static function getZeroPaddedNo100($count)
	{
		$val = '';
		if ($count < 10) {
			$val = "0" . $count;
		} else if ($count >= 10 && $count < 100) {
			$val = $count;
		} else {
			$val = $count;
		}

		return $val;
	}

	static function getZeroPaddedNo10000($count)
	{
		$val = '';
		if ($count < 10) {
			$val = "000" . $count;
		} else if ($count >= 10 && $count < 100) {
			$val = "00" . $count;
		} else if ($count >= 100 && $count < 1000) {
			$val = "0" . $count;
		} else if ($count >= 1000 && $count < 10000) {
			$val = "0" . $count;
		} else $val = $count;

		return $val;
	}

	public static function getCountUpTimeDiff($field)
	{
		return DB::raw('TIMESTAMPDIFF(MICROSECOND,' . $field . ', NOW()) as countUp');
	}
	public static function getCountDownTimeDiff($field)
	{
		return DB::raw('TIMESTAMPDIFF(MICROSECOND,NOW(),' . $field . ') as countDown');
	}

	public static function getTimeDiffDHM($field)
	{

		return  DB::raw("CONCAT(
            FLOOR(HOUR(TIMEDIFF(" . $field . ", NOW())) / 24), ' days ',
            MOD(HOUR(TIMEDIFF(" . $field . ", NOW())), 24), ' hours ',
            MINUTE(TIMEDIFF(" . $field . ", NOW())), ' minutes') as countUp");
	}

	public static function get4DigitOtp()
	{
		return rand(1000, 9999);
	}
	public static function get6DigitOtp()
	{
		return rand(100000, 999999);
	}

	public static function sendOtp($request)
	{
		$otp = self::get4DigitOtp();
		// //$content = "Your OTP for verification is " . $otp;
		// $content = "Dear Sir / Madam this code - ".$otp." is a VJ system code to verify your enquiry. Please share it with your Channel Partner or Sales Manager from VJ Team .";
		// SendSms::sendOtp($request[PersonsContactDetails::country_code] . $request[PersonsContactDetails::mobile_number], $content);

		return $otp;
	}
	public static function getTimeBeforeMin($min)
	{
		$now = Carbon::now()->subMinute($min);
		return $now;
	}
	public static function getTimeAfterMin($min)
	{
		$now = Carbon::now()->addMinute($min);
		return $now;
	}
	public static function getTimeBeforeSec($sec)
	{
		$now = Carbon::now()->subSeconds($sec);
		return $now;
	}
	public static function getTimeAfterSec($sec)
	{
		$now = Carbon::now()->addSeconds($sec);
		return $now;
	}

	public static function addToDateTime($date, $addTime, $retFormat, $type=1) {
		
		if($type==1) {
			$newtimestamp = strtotime($date.' + '.($addTime).' minute');
			$re=date($retFormat, $newtimestamp);
		}
		
		return $re;
	}
		
	// * FORMAT DATE WITH TYPES (params::  columnName, fieldAsName, dateFormat)
	public static function dateFormat($field, $as, $formatID)
	{
		$format = '%d %b %Y';
		if ($formatID == 1) {
			$format = '%d %b %Y';
		} // 20 Jan 2019
		else if ($formatID == 2) {
			$format = '%d-%m-%Y';
		} // 20-01-2019
		else if ($formatID == 3) {
			$format = '%Y-%m-%d';
		} // 2019-01-20

		return DB::raw("DATE_FORMAT(" . $field . ", '" . $format . "') as " . $as);
	}
	public static function dateTimeFormat($field, $as, $formatID)
	{
		$format = '%d %b %Y';
		if ($formatID == 1) {
			$format = '%d %b %Y';
		} // 20 Jan 2019
		else if ($formatID == 2) {
			$format = '%d-%m-%Y %h:%i %p';
		} // 20-01-2019
		else if ($formatID == 3) {
			$format = '%Y-%m-%d %h:%i %p';
		} // 2019-01-20
		else if ($formatID == 4) {
			$format = '%d %b %Y at %h:%i %p';
		} 
		return DB::raw("DATE_FORMAT(" . $field . ", '" . $format . "') as " . $as);
	}
	public static function timeFormat($field, $as, $formatID)
	{
		$format = '%h:%i %p';
		if ($formatID == 1) {
			$format = '%h:%i %p';
		} // 10 Oct 2019
		//        else if ($formatID==2) { $format='%h %i'; } // 10-10-2019

		return DB::raw("DATE_FORMAT(" . $field . ", '" . $format . "') as " . $as);
	}
}
