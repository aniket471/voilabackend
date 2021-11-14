<?php

namespace App\Http\Controllers\Saved_Placed_Creation;

use App\Http\Controllers\Controller;
use App\Models\Saved_Placed_Creation\SavedPlaces;
use Illuminate\Http\Request;
use Svg\Tag\Rect;

class SavedPlacesController extends Controller
{
    //
    public static function savedPlaces(Request $request){
        return SavedPlaces::savedPlaces($request);
    }
    public static function getSavedPlaced(Request $request){
        return SavedPlaces::getSavedPlaces($request);
    }
}
