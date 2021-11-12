<?php

namespace App\Models\Food_Registration_Creation;

use Illuminate\Support\Str;
use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Food_Dishes_Registartion_Request_Model extends Model
{
    use HasFactory;

    const requested_restaurant_dishes = 'requested_restaurant_dishes';
    const dish_id = 'id';
    const restaurant_id = 'restaurant_id';
    const dish_type = 'dish_type';
    const dish_item = 'dish_item';
    const dish_name = 'dish_name';
    const dish_description = 'dish_description';
    const dish_price = 'dish_price';
    const dish_photo = 'dish_photo';
    const restaurant_token_id = 'restaurant_token_id';

    const requested_restaurant_dishes_all = self::requested_restaurant_dishes . AppConfig::DOT . AppConfig::STAR;
    const requested_dish_id = self::requested_restaurant_dishes . AppConfig::DOT . self::dish_id;
    const requested_restaurant_id = self::requested_restaurant_dishes . AppConfig::DOT . self::restaurant_id;
    const requested_dish_type = self::requested_restaurant_dishes . AppConfig::DOT . self::dish_type;
    const requested_dish_item = self::requested_restaurant_dishes . AppConfig::DOT . self::dish_item;
    const requested_dish_name = self::requested_restaurant_dishes . AppConfig::DOT . self::dish_name;
    const requested_dish_description = self::requested_restaurant_dishes . AppConfig::DOT . self::dish_description;
    const requested_dish_price = self::requested_restaurant_dishes . AppConfig::DOT . self::dish_price;
    const requested_dish_photo = self::requested_restaurant_dishes . AppConfig::DOT . self::dish_photo;
    const requested_restaurant_token_id = self::requested_restaurant_dishes . AppConfig::DOT . self::restaurant_token_id;

    protected $table = self::requested_restaurant_dishes;
    protected $fillable = [
        self::dish_id,
        self::restaurant_id,
        self::dish_type,
        self::dish_item,
        self::dish_name,
        self::dish_description,
        self::dish_price,
        self::dish_photo,
        self::restaurant_token_id
    ];

  

    //add food list
    public static function addNewDish($request)
    {

        $validator = Validator::make($request->all(), [
            self::restaurant_id => 'required',
            self::dish_type => 'required',
            self::dish_item => 'required',
            self::dish_name => 'required',
            self::dish_description => 'required',
            self::dish_price =>'required',
            self::restaurant_token_id => 'required'
        ]);
         
        if ($validator->fails()) {

            return APIResponses::failed_result("Please provide all field , all fields are required");
        }
        else{

            $dish = new self();

            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/dish/', $filename);
    
    
                $dish[self::dish_photo] = $filename;
            } else {
                return $request;
                $dish[self::dish_photo] = '';
            }
    
            $dish[self::restaurant_id] = $request[self::restaurant_id];
            $dish[self::dish_type] = $request[self::dish_type];
            $dish[self::dish_item] = $request[self::dish_item];
            $dish[self::dish_name] = $request[self::dish_name];
            $dish[self::dish_description] = $request[self::dish_description];
            $dish[self::dish_price] = $request[self::dish_price];
            $dish[self::restaurant_token_id] = $request[self::restaurant_token_id];
    
    
           $result = $dish->save();
    
           if($result) return APIResponses::success_result("Dish Added Successfully");
           else return APIResponses::failed_result("something went wrong please try again");
        }
    }

    public static function getAllDishDetails($request)
    {

        if (self::where(self::restaurant_id, $request[self::restaurant_id])->first()) {

            $dish = self::select(
                self::dish_name,
                self::dish_type,
                self::dish_item,
                self::dish_description,
                self::dish_price,
                self::dish_photo
            )
                ->where(self::restaurant_id, $request[self::restaurant_id])
                ->get();
            foreach ($dish as $key => $value) {
                $value["dish_url"] = asset('uploads/dish/' . $value[self::dish_photo]);
            }
            return $dish;
        }
        else{
            return APIResponses::failed_result("This restaurant is not registered");
        }
    }

    //get all menu of restaurant by dish item 
    public static function getAllMenus($request){
     
        
        $validator = Validator::make($request->all(), [
            self::restaurant_id => 'required',
            self::restaurant_token_id => 'required'
        ]);
         
        if ($validator->fails()) {

            return APIResponses::failed_result("Please check restaurant id and restaurant token id is null");
        }
        else{

            if(self::where(self::restaurant_id,$request[self::restaurant_id])->where(self::restaurant_token_id,$request[self::restaurant_token_id])->first()){

                $menuList = self::select(
                                         self::dish_id,
                                         self::restaurant_id,
                                         self::restaurant_token_id,
                                         self::dish_type,
                                         self::dish_item,
                                         self::dish_name,
                                         self::dish_description,
                                         self::dish_price,
                                         self::dish_photo
                                        
                                         )
                                         ->
                                         where(self::restaurant_id,$request[self::restaurant_id])
                                         ->get();

               foreach($menuList as $key=>$value){

                $value->menuUrl = asset('uploads/dish/' . $value[self::dish_photo]);
               }
               
              if(!empty($menuList)){
                return APIResponses::success("Menu list find","menus",$menuList);
               }
               else return APIResponses::failed_result("Menu not find");

            }
            else{
                return APIResponses::failed_result("Restaurant token mistMatch");
            }
        }
    }

 //get all veg type dish
    public static function getAllVegDish($request)
    {
        if (!empty($request[self::restaurant_token_id])) {

            $data =  self::select(
                self::dish_id,
                self::restaurant_id,
                self::dish_type,
                self::dish_item,
                self::dish_name,
                self::dish_description,
                self::dish_price,
                self::dish_photo,
            )
                ->where(self::restaurant_token_id, $request[self::restaurant_token_id])
               ->whereRaw('LOWER(`dish_type`) LIKE ? ',strtolower($request['filter_type']).'%')
               ->get();

            foreach ($data as $key => $value) {

                $value->menuUrl = asset('uploads/dish/' . $value[self::dish_photo]);
            }           

            if(!$data->isEmpty()){
                
                  return APIResponses::success(
                    "Filter apply successfully",
                    "filterDish"
                    ,$data
                );
            }
            else return APIResponses::failed_result("No dish available on this filter please select another filter");
        }
        else return APIResponses::failed_result("Restaurant token mistMatch");
    }

    //get All dish newest and oldest records
    public static function getNewestDish($request){

        if (!empty($request[self::restaurant_token_id])) {

            $data =  self::orderBy('id', 'desc')->take(10)->where(self::restaurant_token_id,$request[self::restaurant_token_id])->get();

            foreach ($data as $key => $value) {

                $value->menuUrl = asset('uploads/dish/' . $value[self::dish_photo]);
            }            

if(!$data->isEmpty()){
                
                  return APIResponses::success(
                    "Filter apply successfully",
                    "filterDish"
                    ,$data
                );
            }
            else return APIResponses::failed_result("No dish available on this filter please select another filter");
        }
        else return APIResponses::failed_result("Restaurant token mistMatch");
    }

    //get all oldest dishes
    public static function getAllOldestDishes($request){

        if (!empty($request[self::restaurant_token_id])) {

            $data =  self::orderBy('id', 'asc')->take(10)->where(self::restaurant_token_id,$request[self::restaurant_token_id])->get();

            foreach ($data as $key => $value) {

                $value->menuUrl = asset('uploads/dish/' . $value[self::dish_photo]);
            }            

if(!$data->isEmpty()){
                
                  return APIResponses::success(
                    "Filter apply successfully",
                    "filterDish"
                    ,$data
                );
            }
            else return APIResponses::failed_result("No dish available on this filter please select another filter");
        }
        else return APIResponses::failed_result("Restaurant token mistMatch");
    }

 //update the dish list
    public static function updateDishInfo($request){
        $validator = Validator::make($request->all(), [
            self::restaurant_id => 'required',
            self::dish_type => 'required',
            self::dish_item => 'required',
            self::dish_name => 'required',
            self::dish_description => 'required',
            self::dish_price => 'required',
            self::restaurant_token_id => 'required',
            self::dish_id => 'required'
        ]);

        if ($validator->fails()) {

            return APIResponses::failed_result("Please provide all field , all fields are required");
        } else {

          //  $dish = new self();

            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('uploads/dish/', $filename);


                $dish[self::dish_photo] = $filename;
            } else {
                return $request;
                $dish[self::dish_photo] = '';
            }

            $dish[self::restaurant_id] = $request[self::restaurant_id];
            $dish[self::dish_type] = $request[self::dish_type];
            $dish[self::dish_item] = $request[self::dish_item];
            $dish[self::dish_name] = $request[self::dish_name];
            $dish[self::dish_description] = $request[self::dish_description];
            $dish[self::dish_price] = $request[self::dish_price];
            $dish[self::restaurant_token_id] = $request[self::restaurant_token_id];


            $result = self::where('id',$request[self::dish_id])->update($dish);
            if ($result) return APIResponses::success_result("Dish Added Successfully");
            else return APIResponses::failed_result("something went wrong please try again");
        }
    }

 public static function removeDishFromRestaurant($request){

    $validator = Validator::make($request->all(), [
        self::restaurant_id => 'required',
        self::dish_id => "required",
        self::restaurant_token_id => 'required'
    ]);
     
    if ($validator->fails()) {

        return APIResponses::failed_result("Please provide all field , all fields are required");
    }
    else{

        $data[self::dish_id] = $request[self::dish_id];
        
        $result = self::where(self::dish_id,$request[self::dish_id])->where(self::restaurant_token_id,$request[self::restaurant_token_id])
                        ->delete($data);
        if($result)return APIResponses::success_result("Dish remove successfully");
        else return APIResponses::failed_result("Dish not removed please try again");                
    }
 }
}
