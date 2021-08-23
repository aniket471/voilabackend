<?php

namespace App\Models\VehicleIconCreationModule;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleIconModel extends Model
{
    use HasFactory;

    const vehicle_icons = 'vehicle_icons';
    const vehicle_type_id = 'vehicle_type_id';
    const vehicle_type = 'vehicle_type';
    const vehicle_icon = 'vehicle_icon';

    const vehicle_icons_all = self::vehicle_icons . AppConfig::DOT . AppConfig::STAR;
    const vehicle_icons_vehicle_type_id = self::vehicle_icons . AppConfig::DOT . self::vehicle_type_id;
    const vehicle_icons_vehicle_type = self::vehicle_icons . AppConfig::DOT . self::vehicle_type;
    const vehicle_icons_vehicle_icon = self::vehicle_icons . AppConfig::DOT . self::vehicle_icon;

    protected $table = self::vehicle_icons;
    protected $fillable = [
        self::vehicle_type_id,
        self::vehicle_type,
        self::vehicle_icon
    ];

    public $timestamps = false;

    //store vehicle type wise images
    public static function storeVehicleTypeWiseImage($request)
    {
        $pages = new self();

        // $pages->title = $request->input('title');
        // $pages->description = $request->input('description');

        $pages[self::vehicle_type_id] = $request[self::vehicle_type_id];
        $pages[self::vehicle_type] = $request[self::vehicle_type];

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move('uploads/appsetting/', $filename);

            //see above line.. path is set.(uploads/appsetting/..)->which goes to public->then create
            //a folder->upload and appsetting, and it wil store the images in your file.

            $pages[self::vehicle_icon] = $filename;
        } else {
            return $request;
            $pages[self::vehicle_icon] = '';
        }
        $pages->save();

        return APIResponses::success_result("Image uploaded successfully");
    }

    //get vehicle wise image
    public static function getVehicleTypeWiseImage($request)
    {
        //         $pages = self::all();
        //         //  $data = asset('uploads/appsetting/' .   $pages['image']);
        // foreach($pages as $key=>$value){
        //         $value["imageURL"]= asset('uploads/appsetting/' . $value[self::vehicle_icon]);
        //     }

        $VehicleImages = self::select(self::vehicle_icon)->where(self::vehicle_type_id,$request[0]["global_vehicle_id"])->get();

        $data = asset('uploads/appsetting/' . $VehicleImages[0][self::vehicle_icon]);

        return $data;
        return response()->json([$response = "result" => true, "message" => "Image Found", "homeScreenImages" => $data]);
    }
}
