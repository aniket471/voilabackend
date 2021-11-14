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
use App\Http\Controllers\RideImages\ImageController;
use App\Models\TripDetails_Modeule\ConformTrips;
use App\Models\TripDetails_Modeule\Pre_Confom_Trips;
use App\Http\Controllers\Saved_Placed_Creation\SavedPlacesController;
use App\Models\Saved_Placed_Creation\SavedPlaces;
use App\Http\Controllers\VehicleIconCreationModule\VehicleIconController;
use App\Http\Controllers\Food_Registartion_Creation\FoodRegistrationController;
use App\Http\Controllers\RequiredDocs_Creation\RequiredDocsController;
use App\Http\Controllers\CommonImageCreation\CommonImageController;
use App\Http\Controllers\AppUpdate\AppUpdateController;
use App\Http\Controllers\RateCardCreation\RateCardController;


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




//-------------------------------------  DRIVER MODULE ---------------------------------//


//update the driver location continuously need driverId,currentLat,currentLng,currentAddress
Route::middleware('auth:app_internal_partner')->group(function(){ 
Route::post('driverCurrentLocation',[RiderTripLocationController::class,'driverCurrentLocation']);
});

//check new trip for driver 
Route::middleware('auth:app_internal_partner')->group(function(){
Route::get('checkTheTripStatus',[TripDetailController::class,'checkTheTripStatus']);
});

//booking accepted for driver site
Route::middleware('auth:app_internal_partner')->group(function(){
//accept trip first time means its temp accept
Route::post('acceptTripForTemp',[TripDetailController::class,'acceptTripForTemp']);
// Route::post('acceptBookingWithRateCard',[TripDetailController::class,'acceptBookingWithRateCard']);
// Route::post('acceptBookingWithCustomCard',[TripDetailController::class,'acceptBookingWithCustomCard']);    
});

//bidding status changes && driver accept it with min rate for driver site
Route::middleware('auth:app_internal_partner')->group(function(){
    Route::post('driverLowestPrice',[BiddingController::class,'driverLowestPrice']);
    Route::get('refreshTheBiddingPrice',[BiddingController::class,'refreshTheBiddingPrice']);    
});

//enable the trip to selected driver this api call every 5 sec or 10 sec
Route::middleware('auth:app_internal_partner')->group(function(){
Route::get('enableTripToSelectedDriver',[Final_Driver_Controller::class,'enableTripToSelectedDriver']);
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

//driver earning weekly report
Route::middleware('auth:app_internal_partner')->group(function(){
    Route::post('getWeeklyReport',[DriverEaringController::class,'getWeeklyReport']);
    //not in use 
    Route::get('getMonthWiseEarning',[DriverEaringController::class,'getMonthWiseEarning']);
});


//-------------------------------------------- RIDER MODULE -------------------------------------------//


//Rider Login
Route::middleware('auth:app_external')->group(function(){
 Route::get('riderLogin',[RiderLoginController::class,'riderLogin']);
 Route::post('verifyTheOtp',[RiderLoginController::class,'verifyTheOtp']);
});  

//update a rider current/pickup location continuously
Route::middleware('auth:app_internal')->group(function(){
 Route::post('updateRiderLocationContinuously',[RiderTripLocationController::class,'updateRiderLocationContinuously']);
});


Route::middleware('auth:app_internal')->group(function(){
//get a all global vehicles which is in currently present in riders 5km radius with rate 
Route::post('getVehicle',[DriverController::class,'getVehicle']);
//show a all drivers when rider select a global vehicle . all driver should be in 5km radius.rider site
Route::post('showAllDriver',[RiderTripLocationController::class,'showAllDriver']);
//rider select driver to start a trip from hole driverList for rider site
Route::post('selectDriverToTrip',[Final_Driver_Controller::class,'selectDriverToTrip']);
});

//this api for IOS
Route::middleware('auth:app_internal')->group(function(){
    Route::post('getVehicles',[DriverController::class,'getVehicles']);
});



//get driver location when trip is enable to driver
Route::middleware('auth:app_internal')->group(function(){
Route::post('getDriverUpdatedLocation',[Final_Driver_Controller::class,'getDriverUpdatedLocation']);
});

//generate the otp to verify the driver
Route::middleware('auth:app_internal')->group(function(){
Route::post('generateTheOtpToVerifyTheDriver',[Final_Driver_Controller::class,'generateTheOtpToVerifyTheDriver']);
});

//check the trip status its only for test
Route::middleware('auth:app_internal')->group(function(){
Route::post('checkTripStatus',[ConformTripsController::class , 'checkTripStatus']);
Route::post('addNewFeedBack',[FeedBackController::class,'addNewFeedBack']);
});


//get drivers with live bidding rate for rider site
Route::middleware('auth:app_internal')->group(function(){
    Route::post('getDriversWithBiddingCurrentPrice',[BiddingController::class,'getDriversWithBiddingCurrentPrice']);
});


//for saved places
Route::middleware('auth:app_internal')->group(function(){
Route::post('savedPlaces',[SavedPlacesController::class,'savedPlaces']);
Route::get('getSavedPlaced',[SavedPlacesController::class,'getSavedPlaced']);
});


//-------------------------------------------- REQUEST WITH EXTERNAL TOKENS ----------------------------------------//

//canceled trip modules this is call by rider and driver also call it by external token
Route::middleware('auth:app_external')->group(function () {
    Route::post('canceledTrip',[Canceld_Trip_Controller::class,'canceledTrip']);
});

///route change request
Route::middleware('auth:app_external')->group(function() {
    //calculate a new route here if trip has change ant raoute
    Route::get('getMidLatLng',[RouteChangedController::class,'getMidLatLng']);
    Route::post('requestToChangedRoute',[RouteChangedController::class,'requestToChangedRoute']);
    Route::get('checkTheRouteChangeRequest',[RouteChangedController::class,'checkTheRouteChangeRequest']);
    Route::post('acceptTheChangeRouteRequest',[RouteChangedController::class,'acceptTheChangeRouteRequest']);
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



//--------------------------------------------- REQUIRED DOCS FOR REGISTRATION PROCESS -----------------------------------------//
Route::post('addDriverRegistrationRequiredDocs',[RequiredDocsController::class ,'addDriverRegistrationRequiredDocs']);
Route::post('addDriverAddressRequiredDocs',[RequiredDocsController::class ,'addDriverAddressRequiredDocs']);
Route::post('addDriverKYCRequiredDocs',[RequiredDocsController::class ,'addDriverKYCRequiredDocs']);
Route::post('addDriverVehicleRequiredDocs',[RequiredDocsController::class ,'addDriverVehicleRequiredDocs']);
Route::post('addRestaurantOwnerRequiredDocs',[RequiredDocsController::class ,'addRestaurantOwnerRequiredDocs']);
Route::post('addRestaurantDetailsRequiredDocs',[RequiredDocsController::class ,'addRestaurantDetailsRequiredDocs']);

//get all required docs by title
Route::post('getAllRequiredDocsToRegister',[RequiredDocsController::class, 'getAllRequiredDocsToRegister']);



// ---------------------------------------------- FOOD AND DRIVER REGISTRATION MODULE  -----------------------------------//


// registration Process Login
Route::middleware('auth:app_external')->group(function(){
   Route::post('registrationProcessLogin',[FoodRegistrationController::class, 'registrationProcessLogin']); 
   Route::post('verifyOtp',[FoodRegistrationController::class, 'verifyOtp']);
});


// add new restaurant and restaurant profile , dish
Route::middleware('auth:app_external')->group(function(){
    Route::post('addNewRestaurantOwner',[FoodRegistrationController::class , 'addNewRestaurantOwner']);
    Route::post('addNewRestaurantProfileInfo', [FoodRegistrationController::class , 'addNewRestaurantProfileInfo']);
    Route::get('getAllDishDetails',[FoodRegistrationController::class , 'getAllDishDetails']);
    Route::get('isRestaurantAccountVerify',[FoodRegistrationController::class,'isRestaurantAccountVerify']);
    Route::post('removeDishFromRestaurant',[FoodRegistrationController::class,'removeDishFromRestaurant']);

    Route::post('updateResaturantOwnerInformation',[FoodRegistrationController::class,'updateResaturantOwnerInformation']);
    Route::post('updateRestaurantInformation',[FoodRegistrationController::class,'updateRestaurantInformation']);
    
});
Route::post('updateRestaurantProfile',[FoodRegistrationController::class,'updateRestaurantProfile']);
Route::post('updateDishInfo',[FoodRegistrationController::class,'updateDishInfo']);
Route::post('addNewDish',[FoodRegistrationController::class,'addNewDish']);
  Route::post('addRestaurantProfile',[FoodRegistrationController::class , 'addRestaurantProfile']);

//driver registration request personal , address details, kyc-details, vehicle-details,
Route::middleware('auth:app_external')->group(function(){
    Route::post('addPersonalInformation',[FoodRegistrationController::class,'addPersonalInformation']);
    Route::post('addAddressDetails',[FoodRegistrationController::class,'addAddressDetails']); 
    Route::post('addVehicleDetails',[FoodRegistrationController::class ,'addVehicleDetails']);
    Route::post('addDriverVehicleDetails',[FoodRegistrationController::class,'addDriverVehicleDetails']);

    Route::post('updateAddressInformation',[FoodRegistrationController::class,'updateAddressInformation']);
    Route::post('updatePersonalInformation',[FoodRegistrationController::class,'updatePersonalInformation']);
    Route::post('updateVehicleInformation',[FoodRegistrationController::class,'updateVehicleInformation']);


});
Route::post('addKYCDetails',[FoodRegistrationController::class,'addKYCDetails']);
Route::post('addVehicleProfilePicture',[FoodRegistrationController::class, 'addVehicleProfilePicture']);
Route::post('updateKYCDetails',[FoodRegistrationController::class,'updateKYCDetails']);
Route::post('updateVehicleDocument',[FoodRegistrationController::class,'updateVehicleDocument']);


//get all menu of restaurant
Route::middleware('auth:app_external')->group(function(){

    Route::get('getAllMenus',[FoodRegistrationController::class, 'getAllMenus']);
});

//dish required docs
Route::middleware('auth:app_external')->group(function(){
    Route::post('addNewDishDocs',[FoodRegistrationController::class,'addNewDishDocs']);
    Route::get('getDishRequiredDocs',[FoodRegistrationController::class,'getDishRequiredDocs']);
});

//check registration process driver and food restaurant
Route::middleware('auth:app_external')->group(function(){
    Route::get('driverRegistrationProcess',[FoodRegistrationController::class , 'driverRegistrationProcess']);
    Route::get('restaurantRegistrationProcess',[FoodRegistrationController::class,'restaurantRegistrationProcess']);
    Route::get('getAllRequestedInfo',[FoodRegistrationController::class,'getAllRequestedInfo']);
    Route::get('getAllRestaurantRequestedInfo',[FoodRegistrationController::class,'getAllRestaurantRequestedInfo']);


});




// ---------------------------------------  RATE CARD MODEULE --------------------------------  
Route::get('getSystemRates', [RateCardController::class, 'getSystemRates']);
Route::post('createCustomeRateCard', [RateCardController::class, 'createCustomeRateCard']);
Route::post('getDriverVehicleInfo', [RateCardController::class, 'getDriverVehicleInfo']);














//---------------------------------------- CURRENTLY NOT USE API -----------------------------------//

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
    
    //show booking accepted drivers who accept with rate card and min rate (Its not final driver) for rider site
    // Route::middleware('auth:app_internal')->group(function(){
    //     Route::get('tripAcceptedDriver',[RiderTripLocationController::class,'tripAcceptedDriver']);
    // });



// ---------------------------------------------  splash screen user login session ------------------------------------- //
 Route::middleware('auth:app_internal')->group(function(){
 Route::post('checkUserLoginSession',[RiderLoginController::class,"checkUserLoginSession"]);
});


// ----------------------------------------------  Dashboard site images ----------------------------------------------------//
Route::post('storeRideImage',[ImageController::class,'storeRideImage']);
Route::post('getImage',[ImageController::class,'getImage']);

//for vehicle type wise icons
Route::post('storeVehicleTypeWiseImage',[VehicleIconController::class,'storeVehicleTypeWiseImage']);
Route::get('getVehicleTypeWiseImage',[VehicleIconController::class,'getVehicleTypeWiseImage']);

// get restaurant images 
Route::get('getRestaurantProfilePic',[FoodRegistrationController::class, 'getRestaurantProfilePic']);


// --------------------------------------------------  ADD COMMON IMAGE -------------------------------------------//

Route::middleware('auth:app_external')->group(function(){

    Route::post('addCommonImage',[CommonImageController::class ,'addCommonImage']);
    Route::get('getCommonImageForAccountUnderReview',[CommonImageController::class,'getCommonImageForAccountUnderReview']);

});

// ---------------------------------------- FILTER OPTION ---------------------------------------------- //
Route::middleware('auth:app_external')->group(function(){

    Route::post('addNewFilterOptions',[CommonImageController::class, 'addNewFilterOptions']);
    Route::get('getAllFilterOption',[CommonImageController::class , 'getAllFilterOption']);
});
//get dish with filter option
Route::middleware('auth:app_external')->group(function(){
Route::post('getDishWithFilter',[CommonImageController::class ,'getDishWithFilter']);
});







Route::get('getKYCRequestdInfo',[FoodRegistrationController::class, 'getKYCRequestdInfo']);


//---------------------------------------   APP UPDATE ----------------------------------//
Route::post('addNewBuild',[AppUpdateController::class,'addNewBuild']);