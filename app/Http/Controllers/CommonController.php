<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function access(Request $request){
        return response()->json(['result'=>false,'message'=>"Unauthorized request"]);
    }
}
