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
use App\Http\Controllers\Trips_Creation_Module\ConformTripsController;
use App\Http\Controllers\RouteChanged\RouteChangedController;
use App\Http\Controllers\DriverEarningModule\DriverEaringController;
use App\Http\Controllers\Trips_History_Module\TripHistoryController;
use App\Http\Controllers\FeedBackModule\FeedBackController;
use App\Http\Controllers\Saved_Placed_Creation\SavedPlacesController;

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

//driver registaration by app (currently not use)
Route::middleware('auth:app_external')->group(function () {
Route::get('driverRegistrations',[DriverInfoandDocController::class,'driverRegistrations']);
});

//Rider Login
Route::middleware('auth:app_external')->group(function(){

 Route::post('verifyTheOtp',[RiderLoginController::class,'verifyTheOtp']);
}); 
 Route::post('riderLogin',[RiderLoginController::class,'riderLogin']); 


//current lat-lng of driver
Route::middleware('auth:app_internal_partner')->group(function(){ 
//update the driver location continuously need driverid,currentLat,currentLng,currentAddress
Route::post('driverCurrentLocation',[RiderTripLocationController::class,'driverCurrentLocation']);

Route::get('findTheDriverBetweenRadius',[RiderTripLocationController::class,'findTheDriverBetweenRadius']);
});

//update a rider current/pickup location continuously
Route::middleware('auth:app_internal')->group(function(){
Route::post('updateRiderLocationContinuously',[RiderTripLocationController::class,'updateRiderLocationContinuously']);
});

//get all vehicle with rate. this api is replaced with getVehicle
Route::middleware('auth:app_external')->group(function(){
//not in use Ignore   
Route::get('getAllVehicleAndRates',[RiderTripLocationController::class,'getAllVehicleAndRates']);
});

//driverLogin
Route::middleware('auth:app_internal_partner')->group(function(){
Route::get('driverLogin',[DriverController::class,'driverLogin']);
Route::get('sendNotificationNew',[DriverController::class,'sendNotificationNew']);
Route::get('notifyUser',[DriverController::class,'notifyUser']);
});


Route::middleware('auth:app_internal')->group(function(){
//get a all global vehicles which is in currently present in riders 5km radius with rate 
Route::post('getVehicle',[DriverController::class,'getVehicle']);
//show a all drivers when rider select a global vehicle . all driver should be in 5km radius.rider site
Route::post('showAllDriver',[RiderTripLocationController::class,'showAllDriver']);
//rider select driver to start a trip from hole driverList for rider site
Route::post('selectDriverToTrip',[Final_Driver_Controller::class,'selectDriverToTrip']);
});


//get driver location when trip is enable to driver
Route::middleware('auth:app_internal')->group(function(){
Route::post('getDriverUpdatedLocation',[Final_Driver_Controller::class,'getDriverUpdatedLocation']);
});

//generate the otp to verify the driver
Route::middleware('auth:app_internal')->group(function(){
Route::post('generateTheOtpToVerifyTheDriver',[Final_Driver_Controller::class,'generateTheOtpToVerifyTheDriver']);
});

//enable the trip to selected driver this api call every 5 sec or 10 sec
Route::middleware('auth:app_internal_partner')->group(function(){
Route::get('enableTripToSelectedDriver',[Final_Driver_Controller::class,'enableTripToSelectedDriver']);
});

Route::middleware('auth:app_internal_partner')->group(function(){
//check new trip for driver 
Route::get('checkTheTripStatus',[TripDetailController::class,'checkTheTripStatus']);
});

//check the trip status its only for test
Route::middleware('auth:app_internal')->group(function(){
Route::post('checkTripStatus',[ConformTripsController::class , 'checkTripStatus']);
});


//booking accepted for driver site
Route::middleware('auth:app_internal_partner')->group(function(){
    //accept trip first time means its temp accept
    Route::post('acceptTripForTemp',[TripDetailController::class,'acceptTripForTemp']);
// Route::post('acceptBookingWithRateCard',[TripDetailController::class,'acceptBookingWithRateCard']);
// Route::post('acceptBookingWithCustomCard',[TripDetailController::class,'acceptBookingWithCustomCard']);    
});


//for saved places
Route::middleware('auth:app_internal')->group(function(){
Route::post('savedPlaces',[SavedPlacesController::class,'savedPlaces']);
Route::post('getSavedPlaced',[SavedPlacesController::class,'getSavedPlaced']);
});


//get drivers with live bidding rate for rider site
Route::middleware('auth:app_internal')->group(function(){
 Route::post('getDriversWithBiddingCurrentPrice',[BiddingController::class,'getDriversWithBiddingCurrentPrice']);
Route::post('addNewFeedBack',[FeedBackController::class,'addNewFeedBack']);
});

//show booking accepted drivers who accept with rate card and min rate (Its not final driver) for rider site
// Route::middleware('auth:app_internal')->group(function(){
//     Route::get('tripAcceptedDriver',[RiderTripLocationController::class,'tripAcceptedDriver']);
// });


//bidding status changes && driver accept it with min rate for driver site
Route::middleware('auth:app_internal_partner')->group(function(){
    Route::post('driverLowestPrice',[BiddingController::class,'driverLowestPrice']);
    Route::get('refreshTheBiddingPrice',[BiddingController::class,'refreshTheBiddingPrice']);    
});



//canceled trip modules this is call by rider and driver also call it by external token
Route::middleware('auth:app_external')->group(function () {
 Route::post('canceledTrip',[Canceld_Trip_Controller::class,'canceledTrip']);
});


//start a ride by driver (driver start a rider after reaching pickup location)
Route::middleware('auth:app_internal_partner')->group(function(){
 Route::post('startRide',[ConformTripsController::class,'startRide']);
    Route::post('updateDriverLocation',[Final_Driver_Controller::class,'updateDriverLocation']);
 Route::post('endTheRide',[ConformTripsController::class,'endTheRide']);
 Route::post('getADriverRating',[ConformTripsController::class,'getADriverRating']);
});

//verify the driver by otp
Route::middleware('auth:app_internal_partner')->group(function(){
Route::post('verifyDriver',[Final_Driver_Controller::class,'verifyDriver']);
});

//this api for IOS
Route::middleware('auth:app_internal')->group(function(){
    Route::post('getVehicles',[DriverController::class,'getVehicles']);
});

///route change request
Route::middleware('auth:app_external')->group(function() {
    //calculate a new route here if trip has change ant raoute
    Route::get('getMidLatLng',[RouteChangedController::class,'getMidLatLng']);
    Route::post('requestToChangedRoute',[RouteChangedController::class,'requestToChangedRoute']);
    Route::get('checkTheRouteChangeRequest',[RouteChangedController::class,'checkTheRouteChangeRequest']);
    Route::post('acceptTheChangeRouteRequest',[RouteChangedController::class,'acceptTheChangeRouteRequest']);
});

//driver earning weekly report
Route::middleware('auth:app_internal_partner')->group(function(){
    Route::post('getWeeklyReport',[DriverEaringController::class,'getWeeklyReport']);
    //not in use 
    Route::get('getMonthWiseEarning',[DriverEaringController::class,'getMonthWiseEarning']);
});

///generate the  pdf
Route::middleware('auth:app_external')->group(function(){
    Route::get('generateTheInVoiceTripPDF',[TripHistoryController::class,'generatePDF']);
    Route::get('downloadPDf',[TripHistoryController::class,'downloadPDf']);
});

//feedback rider to driver and driver to rider
Route::middleware('auth:app_external')->group(function(){
Route::get('getDriverRating',[FeedBackController::class,'getDriverRating']);
});

 Route::middleware('auth:app_internal')->group(function(){
 Route::post('checkUserLoginSession',[RiderLoginController::class,"checkUserLoginSession"]);
});
    