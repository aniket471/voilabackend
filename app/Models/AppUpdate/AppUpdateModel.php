<?php

namespace App\Models\AppUpdate;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;



class AppUpdateModel extends Model
{
    use HasFactory;

    const app_update = 'app_update';
    const version_name = 'version_name';
    const version_code = 'version_code';
    const build = 'build';
    const is_valid = 'is_valid';

    const app_update_all = self::app_update . AppConfig::DOT . AppConfig::STAR;
    const app_version_name = self::app_update . AppConfig::DOT . self::version_name;
    const app_version_code = self::app_update . AppConfig::DOT . self::version_code;
    const app_build = self::app_update . AppConfig::DOT . self::build;
    const app_is_valid = self::app_update . AppConfig::DOT . self::is_valid;

    protected $table = self::app_update;
    protected $fillable = [
        self::version_name,
        self::version_code,
        self::build,
        self::is_valid
    ];

    // add new build
    public static function addNewBuild($request){

        $app_update = new self();

        $app_update[self::version_name] = $request[self::version_name];
        $app_update[self::version_code] = $request[self::version_code];
        $app_update[self::is_valid] = $request[self::is_valid];


        
        // if ($request->hasfile('file')) {
        //     $file = $request->file('file');
        //     $extension = $file->getClientOriginalExtension(); // getting image extension
        //     $filename = time() . '.' . $extension;
        //     $file->move('uploads/build/apk/', $filename);

        //     //see above line.. path is set.(uploads/appsetting/..)->which goes to public->then create
        //     //a folder->upload and appsetting, and it wil store the images in your file.

        //     $app_update->build = $filename;
        // } else {
        //     return $request;
        //     $app_update->build = '';
        // }
        // $result =  $app_update->save();

        // if($result){
        //     return APIResponses::success_result("APK uploaded successfully");
        // }
        // else{
        //     return APIResponses::failed_result("Failed to upload the apk please try again");
        // }

        $validator = Validator::make($request->all(), [
            'file' => 'max:51200'
        ]);

        $uploadedFile = $request->file('file');
        $filename = time().$uploadedFile->getClientOriginalName();
  
        $uploadedFile->move('uploads/build/apk/', $filename);
  
     
        $app_update->filename = $filename;
  
  
        $app_update->save();
    }
}
