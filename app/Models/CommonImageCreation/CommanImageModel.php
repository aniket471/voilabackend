<?php

namespace App\Models\CommonImageCreation;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommanImageModel extends Model
{
    use HasFactory;

    const common_images = 'common_images';
    const image_title = 'image_title';
    const image = 'image';
    const image_for = 'image_for';
    const status = 'status';

    const common_images_all = self::common_images . AppConfig::DOT . AppConfig::STAR;
    const common_image_title = self::common_images . AppConfig::DOT . self::image_title;
    const common_image = self::common_images . AppConfig::DOT . self::image;
    const common_image_for = self::common_images . AppConfig::DOT . self::image_for;
    const common_status = self::common_images . AppConfig::DOT . self::status;

    protected $table = self::common_images;
    protected $fillable = [
        self::image_title,
        self::image,
        self::image_for,
        self::status
    ];

    public $timestamps = false;

    //add new comman image
    public static function addCommonImage($request){

        $pages = new self();

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move('uploads/common_image/', $filename);

            //see above line.. path is set.(uploads/appsetting/..)->which goes to public->then create
            //a folder->upload and appsetting, and it wil store the images in your file.

            $pages[self::image] = $filename;
            $pages[self::image_title] = $request[self::image_title];
            $pages[self::image_for] = $request[self::image_for];
            $pages[self::status] = 1;

        } else {
            return $request;
            $pages[self::image] = '';
        }
        $pages->save();

        return APIResponses::success_result("Image uploaded successfully");
    }

    //get common image
    public static function getCommonImageForAccountUnderReview(){

        $image = self::select(self::image)->where(self::image_for,"Account Under Review")->get();

        $data = asset('uploads/common_image/' . $image[0][self::image]);

        if(!empty($data)){

            $cong_msg = "Your account has been successfully created.Your account will be activate in 72 hours.";
            $isVerify = true;
            //return APIResponses::failed_result_with_data($cong_msg,$isVerify);

            return response()->json([$response = "result"=>true, "message"=>$cong_msg,"isVerify"=>$isVerify,"verificationData"=>$data]);
        }
    }
}
