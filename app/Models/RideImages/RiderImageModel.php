<?php

namespace App\Models\RideImages;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderImageModel extends Model
{
    use HasFactory;

    const  voila_ride_image  = 'voila_ride_image';
    const title = 'title';
    const description = 'description';
    const image = 'image';

    const void_ride_image_all = self::voila_ride_image . AppConfig::DOT . AppConfig::STAR;
    const voila_ride_image_title = self::voila_ride_image . AppConfig::DOT . self::title;
    const voila_ride_image_description = self::voila_ride_image . AppConfig::DOT . self::description;
    const voila_ride_image_image = self::voila_ride_image . AppConfig::DOT . self::image;

    protected $table = self::voila_ride_image;
    protected $fillable = [
        self::title,
        self::description,
        self::image
    ];

    public $timestamps = false;


    //insert a new image
    public static function storeRideImage($request){

        $pages = new self();

        $pages->title = $request->input('title');
        $pages->description = $request->input('description');

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move('uploads/appsetting/', $filename);

            //see above line.. path is set.(uploads/appsetting/..)->which goes to public->then create
            //a folder->upload and appsetting, and it wil store the images in your file.

            $pages->image = $filename;
        } else {
            return $request;
            $pages->image = '';
        }
        $pages->save();

        return APIResponses::success_result("Image uploaded successfully");
    }

    //get image
    public static function getImage($request)
    {
        $pages = self::all();
           //  $data = asset('uploads/appsetting/' .   $pages['image']);
 foreach($pages as $key=>$value){
           $value["imageURL"]= asset('uploads/appsetting/' . $value['image']);
       }

       return response()->json([$response = "result"=>true,"message"=>"Image Found", "homeScreenImages"=> $pages]);
}
}
