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
    const restaurant_id = 'restaurant_id';
    const dish_type = 'dish_type';
    const dish_item = 'dish_item';
    const dish_name = 'dish_name';
    const dish_description = 'dish_description';
    const dish_price = 'dish_price';
    const dish_photo = 'dish_photo';
    const restaurant_token_id = 'restaurant_token_id';

    const requested_restaurant_dishes_all = self::requested_restaurant_dishes . AppConfig::DOT . AppConfig::STAR;
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
        self::restaurant_id,
        self::dish_type,
        self::dish_item,
        self::dish_name,
        self::dish_description,
        self::dish_price,
        self::dish_photo,
        self::restaurant_token_id
    ];

    public $timestamps = false;

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
}
