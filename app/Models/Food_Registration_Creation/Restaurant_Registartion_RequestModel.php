<?php

namespace App\Models\Food_Registration_Creation;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use App\Models\Required_Docs_Creation\RestaurantDetailsRequiredDocsModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class Restaurant_Registartion_RequestModel extends Model
{
    use HasFactory;
    const restaurant_registration_request = 'restaurant_registration_request';
    const owner_name = 'owner_name';
    const owner_contact_no = 'owner_contact_no';
    const owner_email = 'owner_email';
    const owner_current_address = 'owner_current_address';
    const owner_permanent_address = 'owner_permanent_address';
    const restaurant_name = 'restaurant_name';
    const restaurant_email = 'restaurant_email';
    const restaurant_contact_no = 'restaurant_contact_no';
    const restaurant_opening_time = 'restaurant_opening_time';
    const restaurant_close_time = 'restaurant_close_time';
    const restaurant_website = 'restaurant_website';
    const restaurant_establishment_year = 'restaurant_establishment_year';
    const restaurant_cuisines_type = 'restaurant_cuisines_type';
    const restaurant_indoor_photo = 'restaurant_indoor_photo';
    const restaurant_outdoor_photo = 'restaurant_outdoor_photo';
    const restaurant_licence_photo = 'restaurant_licence_photo';
    const request_token = 'request_token';
    const status = 'status';

    const restaurant_registration_request_all = self::restaurant_registration_request . AppConfig::DOT . AppConfig::STAR;
    const restaurant_owner_name = self::restaurant_registration_request . AppConfig::DOT . self::owner_name;
    const restaurant_owner_contact_no = self::restaurant_registration_request . AppConfig::DOT . self::owner_contact_no;
    const restaurant_owner_email = self::restaurant_registration_request . AppConfig::DOT . self::owner_email;
    const restaurant_owner_current_address = self::restaurant_registration_request . AppConfig::DOT . self::owner_current_address;
    const restaurant_owner_permanent_address = self::restaurant_registration_request . AppConfig::DOT . self::owner_permanent_address;
    const restaurant_restaurant_name = self::restaurant_registration_request . AppConfig::DOT . self::restaurant_name;
    const restaurant_restaurant_email = self::restaurant_registration_request . AppConfig::DOT . self::restaurant_email;
    const restaurant_restaurant_contact_no = self::restaurant_registration_request . AppConfig::DOT . self::restaurant_contact_no;
    const restaurant_restaurant_opening_time = self::restaurant_registration_request . AppConfig::DOT . self::restaurant_opening_time;
    const restaurant_restaurant_close_time = self::restaurant_registration_request . AppConfig::DOT . self::restaurant_close_time;
    const restaurant_restaurant_website = self::restaurant_registration_request . AppConfig::DOT . self::restaurant_website;
    const restaurant_restaurant_establishment_year = self::restaurant_registration_request . AppConfig::DOT . self::restaurant_establishment_year;
    const restaurant_restaurant_cuisines_type = self::restaurant_registration_request . AppConfig::DOT . self::restaurant_cuisines_type;
    const restaurant_restaurant_indoor_photo = self::restaurant_registration_request . AppConfig::DOT . self::restaurant_indoor_photo;
    const restaurant_restaurant_outdoor_photo = self::restaurant_registration_request . AppConfig::DOT . self::restaurant_outdoor_photo;
    const restaurant_restaurant_licence_photo = self::restaurant_registration_request . AppConfig::DOT . self::restaurant_licence_photo;
    const restaurant_restaurant_token_id = self::restaurant_registration_request . AppConfig::DOT . self::request_token;
    const restaurant_status = self::restaurant_registration_request . AppConfig::DOT . self::status;


    protected $table = self::restaurant_registration_request;
    protected $fillable = [
        self::owner_name,
        self::owner_email,
        self::owner_contact_no,
        self::owner_current_address,
        self::owner_permanent_address,
        self::restaurant_name,
        self::restaurant_email,
        self::restaurant_contact_no,
        self::restaurant_opening_time,
        self::restaurant_close_time,
        self::restaurant_website,
        self::restaurant_establishment_year,
        self::restaurant_cuisines_type,
        self::restaurant_indoor_photo,
        self::restaurant_outdoor_photo,
        self::restaurant_licence_photo,
        self::request_token,
        self::status
    ];

    public $timestamps = true;


    //add new registration of restaurant
    public static function addNewRestaurantOwner($request)
    {
        
        $validator = Validator::make($request->all(), [
            self::owner_name => 'required',
            self::owner_email => 'required',
            self::owner_contact_no => 'required',
            self::owner_current_address => 'required',
            self::owner_permanent_address => 'required',
            self::request_token =>'required'
        ]);
         
        if ($validator->fails()) {

            return APIResponses::failed_result("Please provide all filed all are required");
        }
        else{

            $new_restaurant = new self();

            $new_restaurant[self::owner_name] = $request[self::owner_name];
            $new_restaurant[self::owner_email] = $request[self::owner_email];
            $new_restaurant[self::owner_contact_no] = $request[self::owner_contact_no];
            $new_restaurant[self::owner_current_address] = $request[self::owner_current_address];
            $new_restaurant[self::owner_permanent_address] = $request[self::owner_permanent_address];
            $new_restaurant[self::status] = 1;
    
    
            $new_restaurant[self::request_token] = $request[self::request_token];
    
            $result = $new_restaurant->save();
            $userId = $new_restaurant->id;
    
            $data = ["restaurant_token"=>$request[self::request_token],"restaurant_id"=>$userId];
    
            if ($result) {
                return APIResponses::success_result_with_data("Registration success.", array($data));
            } else return APIResponses::failed_result("Registration failed.");
        }
    }

    public static function addNewRestaurantProfileInfo($request){

        $validator = Validator::make($request->all(), [
            self::request_token => 'required',
            self::restaurant_name => 'required',
            self::restaurant_email => 'required',
            self::restaurant_contact_no => 'required',
            self::restaurant_opening_time => 'required',
            self::restaurant_close_time => 'required',
            self::restaurant_website => 'required',
            self::restaurant_establishment_year => 'required',
            self::restaurant_cuisines_type => 'required'
        ]);
         
        if ($validator->fails()) {
    
            return APIResponses::failed_result("Please provide all fields all are required");
        }
        else{

            if(self::where(self::request_token,$request[self::request_token])->first()){

                $new_restaurant[self::restaurant_name] = $request[self::restaurant_name];
                $new_restaurant[self::restaurant_email] = $request[self::restaurant_email];
                $new_restaurant[self::restaurant_contact_no] = $request[self::restaurant_contact_no];
                $new_restaurant[self::restaurant_opening_time] = $request[self::restaurant_opening_time];
                $new_restaurant[self::restaurant_close_time] = $request[self::restaurant_close_time];
                $new_restaurant[self::restaurant_website] = $request[self::restaurant_website];
                $new_restaurant[self::restaurant_establishment_year] = $request[self::restaurant_establishment_year];
                $new_restaurant[self::restaurant_cuisines_type] = $request[self::restaurant_cuisines_type];
                $new_restaurant[self::status] = 2;
    
                $result = self::where(self::request_token,$request[self::request_token])
                               ->update($new_restaurant);
                if($result){
                    return APIResponses::success_result("Restaurant Profile Registration SuccessFully");
                }
                else{
                    return APIResponses::failed_result("Restaurant Profile Registration Failed");
                }               
            }
            else{
                return APIResponses::failed_result("Invalid Token");
            }
        }   
        
    }

    public static function addRestaurantProfile($request){

        $title = $request->input('title');
        $pages = new self();
        $update = array();

        $validator = Validator::make($request->all(), [
            self::request_token => 'required',
            'title' => 'required'
        ]);
         
        if ($validator->fails()) {
            return APIResponses::failed_result("Title and Restaurant token is missing..please provide both");
        }
        else {

                if(self::where(self::request_token,$request[self::request_token])->first()){
                    
                    if($title === "restaurant_indoor_photo"){
            
                        if ($request->hasfile('image')) {
                            $file = $request->file('image');
                            $extension = $file->getClientOriginalExtension(); 
                            $filename = time() . '.' . $extension;
                            $file->move('uploads/restaurant/', $filename);
                
                            
                           $update['restaurant_indoor_photo'] = $filename;
                           $update[self::status] = 3;
                        } else {
                            return $request;
                            $pages->restaurant_indoor_photo = '';
                        }
                       // $pages->save();
            
                       $result = self::where(self::request_token,$request[self::request_token])->update($update);
            
                       if($result){
                          return APIResponses::success_result("Restaurant Indoor Image Uploaded Successfully");
                       }
                       else{
                        return APIResponses::failed_result("Restaurant Indoor Image Uploaded Failed");
            
                       }   
                    }
                    elseif($title === "restaurant_outdoor_photo"){
            
                        if ($request->hasfile('image')) {
                            $file = $request->file('image');
                            $extension = $file->getClientOriginalExtension(); 
                            $filename = time() . '.' . $extension;
                            $file->move('uploads/restaurant/', $filename);
                
                            
                            $update[self::restaurant_outdoor_photo] = $filename;
                            $update[self::status] = 3;

                        } else {
                            return $request;
                            $pages->image = '';
                        }
                       // $pages->save();
                         $result = self::where(self::request_token,$request[self::request_token])->update($update);
    
                         if($result) return APIResponses::success_result("Restaurant Outdoor Image Uploaded Successfully");
                         else return  APIResponses::failed_result("Restaurant Outdoor Image Uploaded Failed");
            
                    }
                    elseif($title === 'restaurant_licence_photo'){
                        
                        if ($request->hasfile('image')) {
                            $file = $request->file('image');
                            $extension = $file->getClientOriginalExtension(); 
                            $filename = time() . '.' . $extension;
                            $file->move('uploads/restaurant/', $filename);
                
                            
                            $update[self::restaurant_licence_photo] = $filename;
                            $update[self::status] = 3;
            
                        } else {
                            return $request;
                            $pages->image = '';
                        }
                       // $pages->save();
            
                       $result =  self::where(self::request_token,$request[self::request_token])->update($update);
    
                       if($result)  return APIResponses::success_result("Restaurant Licence Image Uploaded Successfully");
                       else return  APIResponses::failed_result("Restaurant Licence Image Uploaded Failed");
                    }
                    else {
                        return APIResponses::failed_result("Invalid title please check again");
                    }
                }
             else{
                return APIResponses::failed_result("Restaurant token is missMatch Please provide restaurant token");
              }
        }
    
    }

    //track the restaurant registration process
    public static function restaurantRegistrationProcess($request){

        if(self::where(self::request_token,$request[self::request_token])->first()){

            $process = self::select(self::status)->where(self::request_token,$request[self::request_token])->get();

            if(!empty($process[0][self::status])){

                if($process[0][self::status] === "1"){

                    return self::getRestaurantDetailsRequiredDocs($request);
                }
                elseif($process[0][self::status] === "2"){

                    return self::restaurantProfileDetails($request);
                }
                elseif($process[0][self::status] === "3"){

                    return self::restaurantProfileDetails($request);
                }
            }
            else{

                return response()->json([$response = "result"=>true, "message"=>"Invalid request or Token Expired","processComplete"=>"0"]);
            }
        }
        else{

            return response()->json([$response = "result"=>true, "message"=>"Invalid request or Token Expired","processComplete"=>"0"]);
        }
    }

    public static function restaurantProfileDetails($request){

        $restaurantProfileDetails = self::select(self::restaurant_indoor_photo,
                                                 self::restaurant_outdoor_photo,
                                                 self::restaurant_licence_photo
                                                 )
                                                 ->
                                                 where(self::request_token,$request[self::request_token])
                                                 ->get();
                                      
        if(!empty($restaurantProfileDetails)){

            if(!empty($restaurantProfileDetails[0][self::restaurant_indoor_photo])){

                if(!empty($restaurantProfileDetails[0][self::restaurant_outdoor_photo])){

                    if(!empty($restaurantProfileDetails[0][self::restaurant_licence_photo])){

                        return response()->json([$response = "result"=>true, "message"=>"Restaurant Registration Completed","processCompleteStatus"=>"4"]);
                    }
                    else{

                        $detailsFind = ["restaurant_indoor_photo"=>true,"restaurant_outdoor_photo"=>true,"restaurant_licence_photo"=>false];
                    return response()->json([$response = "result"=>true, "message"=>"Restaurant Profile Details Found","processCompleteStatus"=>"3","needToProcessComplete"=>array($detailsFind)]);
                    }
                }
                else{

                    $detailsFind = ["restaurant_indoor_photo"=>true,"restaurant_outdoor_photo"=>false];
                    return response()->json([$response = "result"=>true, "message"=>"Restaurant Profile Details Found","processCompleteStatus"=>"3","needToProcessComplete"=>array($detailsFind)]);
                }
            }
            else{

                return self::getAllRestaurantDocsByTypeImg(); 
            }
        }
        else{

            return self::getAllRestaurantDocsByTypeImg(); 
        }                                         
    }

    // if registration process one 
    public static function getRestaurantDetailsRequiredDocs($request){
        $restaurantDetailsRequiredDocs = RestaurantDetailsRequiredDocsModel::getRestaurantDetailsRequiredDocs();

        return response()->json([$response = "result"=>true, "message"=>"Owner Details Found","processCompleteStatus"=>"1","needToProcessComplete"=>$restaurantDetailsRequiredDocs]);
    }

    //get all restaurant docs type image
    public static function getAllRestaurantDocsByTypeImg(){

        $restaurantDocsTypeImage = RestaurantDetailsRequiredDocsModel::getAllRestaurantDocsByTypeImg();
      //  return $restaurantDocsTypeImage;
        return response()->json([$response = "result"=>true, "message"=>"Owner Details Found","processCompleteStatus"=>"2","needToProcessComplete"=>$restaurantDocsTypeImage]);

    }
}
