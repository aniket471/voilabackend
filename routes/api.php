<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverInfo\DriverDocsController;
use App\Http\Controllers\DriverInfo\DriverInfoandDocController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\Rider\RiderLoginController;
use App\Http\Controllers\Rider\RiderTrip\RiderTripLocationController;
use App\Models\Rider\RiderLogin;
use App\Http\Controllers\DriverInfo\DriverController;
use App\Http\Controllers\DriverInfo\TripDetails_Module\TripDetailController;
use App\Models\Rider\RiderTripLocation;
use App\Http\Controllers\Bidding_Creation\BiddingController;
use App\Http\Controllers\Trips_Creation_Module\Final_Driver_Controller;
use App\Http\Controllers\Canceld_Trips_Module\Canceld_Trip_Controller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//denied requests
Route::get('access',[CommonController::class,'access'])->name('access');

Route::middleware('auth:app_external')->group(function () {
	Route::get('driverRegistrations',[DriverInfoandDocController::class,'driverRegistrations']);
});

//Rider Login
Route::middleware('auth:app_external')->group(function(){
 Route::get('riderLogin',[RiderLoginController::class,'riderLogin']);
 Route::post('verifyTheOtp',[RiderLoginController::class,'verifyTheOtp']);
});  


//current lat-lng of driver
Route::middleware('auth:app_external')->group(function(){
Route::post('driverCurrentLocation',[RiderTripLocationController::class,'driverCurrentLocation']);
Route::get('findTheDriverBetweenRadius',[RiderTripLocationController::class,'findTheDriverBetweenRadius']);
Route::get('showAllDriver',[RiderTripLocationController::class,'showAllDriver']);
});


//get all vehicle with rate
Route::middleware('auth:app_external')->group(function(){
Route::get('getAllVehicleAndRates',[RiderTripLocationController::class,'getAllVehicleAndRates']);
});

//driverLogin
Route::middleware('auth:app_internal_partner')->group(function(){
Route::get('driverLogin',[DriverController::class,'driverLogin']);
Route::get('sendNotificationNew',[DriverController::class,'sendNotificationNew']);
Route::get('notifyUser',[DriverController::class,'notifyUser']);
});


//Trip Checker driver site
Route::middleware('auth:app_internal_partner')->group(function(){
Route::get('getVehicle',[DriverController::class,'getVehicle']);
Route::get('checkTheTripStatus',[TripDetailController::class,'checkTheTripStatus']);
});

//booking accepted for driver site
Route::middleware('auth:app_internal_partner')->group(function(){
    Route::post('acceptTripForTemp',[TripDetailController::class,'acceptTripForTemp']);
    Route::post('acceptBookingWithRateCard',[TripDetailController::class,'acceptBookingWithRateCard']);
    Route::post('acceptBookingWithCustomCard',[TripDetailController::class,'acceptBookingWithCustomCard']);    
});


//get drivers with live bidding rate for rider site
Route::middleware('auth:app_internal')->group(function(){
 Route::get('getDriversWithBiddingCurrentPrice',[BiddingController::class,'getDriversWithBiddingCurrentPrice']);
});

//show booking accepted drivers who accept with rate card and min rate (Its not final driver) for rider site
Route::middleware('auth:app_internal')->group(function(){
    Route::get('tripAcceptedDriver',[RiderTripLocationController::class,'tripAcceptedDriver']);
});


//bidding status changes && driver accept it with min rate for driver site
Route::middleware('auth:app_internal_partner')->group(function(){
    Route::post('driverLowestPrice',[BiddingController::class,'driverLowestPrice']);
    Route::get('refreshTheBiddingPrice',[BiddingController::class,'refreshTheBiddingPrice']);    
});

//rider select driver to start a trip from hole driverList for rider site
Route::middleware('auth:app_internal')->group(function(){
 Route::post('selectDriverToTrip',[Final_Driver_Controller::class,'selectDriverToTrip']);
});

//canceled trip modules this is call by rider and driver also call it by external token
Route::middleware('auth:app_external')->group(function () {
 Route::post('canceledTrip',[Canceld_Trip_Controller::class,'canceledTrip']);
});