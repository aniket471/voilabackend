<?php

namespace App\Models\FeedBackModule;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class FeedBackModel extends Model
{
    use HasFactory;
    const driver_feedback = 'driver_feedback';
    const rider_id = 'rider_id';
    const driver_id = 'driver_id';
    const driver_ratings = 'driver_ratings';
    const feedback_message = 'feedback_message';
    const rider_rating = 'rider_rating';

    const driver_feedback_all = self::driver_feedback . AppConfig::DOT . AppConfig::STAR;
    const driver_feedback_rider_id = self::driver_feedback . AppConfig::DOT . self::rider_id;
    const driver_feedback_driver_id = self::driver_feedback . AppConfig::DOT . self::driver_id;
    const driver_feedback_driver_ratings = self::driver_feedback . AppConfig::DOT . self::driver_ratings;
    const driver_feedback_feedback_message = self::driver_feedback . AppConfig::DOT . self::feedback_message;
    const driver_feedback_rider_rating = self::driver_feedback . AppConfig::DOT . self::rider_rating;


    protected $table = self::driver_feedback;
    protected  $fillable = [
        self::rider_id,
        self::driver_id,
        self::driver_ratings,
        self::feedback_message,
        self::rider_rating,
    ];

    public $timestamps = false;

    public static function addNewFeedBack($request)
    {

        $feedbackAdd = new self();
        $feedbackAdd[self::rider_id] = $request[self::rider_id] ?? 0;
        $feedbackAdd[self::driver_id] = $request[self::driver_id] ?? 0;
        $feedbackAdd[self::driver_ratings] = $request[self::driver_ratings] ?? 0;
        $feedbackAdd[self::feedback_message] = $request[self::feedback_message] ?? NULL;
        $feedbackAdd[self::rider_rating] = $request[self::rider_rating] ?? NULL;

        $result = $feedbackAdd->save();
        if ($result) {
            return APIResponses::success_result("Thanks to give FeedBack...");
        } else {
            return APIResponses::failed_result("Failed to Voila feedback");
        }
    }

    public static function getDriverRating($request)
    {


        if (self::where(self::driver_id, $request)->first()) {

            $ratings = self::select(self::driver_ratings)->where(self::driver_id, $request)->get();
            //return $ratings;
            $TotalRating = $ratings->sum(self::driver_ratings);
            $countRating = count($ratings);
            $totalRating = $TotalRating / $countRating;
           // return $totalRating;
            return APIResponses::success_result_with_data("Rating Find",strval(round($totalRating)));
        } else {
            return APIResponses::failed_result("Invalid Driver Details found");
        }
    }
}
