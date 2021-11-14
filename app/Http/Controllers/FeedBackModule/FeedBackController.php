<?php

namespace App\Http\Controllers\FeedBackModule;

use App\Http\Controllers\Controller;
use App\Models\FeedBackModule\FeedBackModel;
use Illuminate\Http\Request;

class FeedBackController extends Controller
{
    public static function addNewFeedBack(Request $request){
        return FeedBackModel::addNewFeedBack($request);
    }

    public static function getDriverRating(Request $request){
        return FeedBackModel::getDriverRating($request);
    }
}
