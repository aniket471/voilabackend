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
Route::get('riderLogin',[RiderLoginController::class,'riderLogin']);

//current lat-lng of driver
Route::post('driverCurrentLocation',[RiderTripLocationController::class,'driverCurrentLocation']);
Route::get('findTheDriverBetweenRadius',[RiderTripLocationController::class,'findTheDriverBetweenRadius']);
Route::get('showAllDriver',[RiderTripLocationController::class,'showAllDriver']);

//get all vehicle with rate
Route::get('getAllVehicleAndRates',[RiderTripLocationController::class,'getAllVehicleAndRates']);

//driverLogin
Route::get('driverLogin',[DriverController::class,'driverLogin']);
Route::get('sendNotificationNew',[DriverController::class,'sendNotificationNew']);
Route::get('notifyUser',[DriverController::class,'notifyUser']);

//Trip Checker
Route::get('getVehicle',[DriverController::class,'getVehicle']);
Route::get('checkTheTripStatus',[TripDetailController::class,'checkTheTripStatus']);

//booking accepted
Route::post('acceptTripForTemp',[TripDetailController::class,'acceptTripForTemp']);
Route::post('acceptBookingWithRateCard',[TripDetailController::class,'acceptBookingWithRateCard']);
Route::post('acceptBookingWithCustomCard',[TripDetailController::class,'acceptBookingWithCustomCard']);
Route::get('getDriversWithBiddingCurrentPrice',[BiddingController::class,'getDriversWithBiddingCurrentPrice']);

//show booking accepted drivers
Route::get('tripAcceptedDriver',[RiderTripLocationController::class,'tripAcceptedDriver']);

//bidding status changes
Route::post('driverLowestPrice',[BiddingController::class,'driverLowestPrice']);
Route::get('refreshTheBiddingPrice',[BiddingController::class,'refreshTheBiddingPrice']);