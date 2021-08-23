<?php

namespace App\Models\DriverRegistartionRequestCreation;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;


class DriverRegistrationRequestModel extends Model
{
    use HasFactory;

    const driver_registartion_request = 'driver_registartion_request';
    const full_name = 'full_name';
    const email = 'email';
    const contact_number = 'contact_number';
    const date_of_birth = 'date_of_birth';
    const house_number = 'house_number';
    const building_name = 'building_name';
    const street_name = 'street_name';
    const landmark = 'landmark';
    const state = 'state';
    const district = 'district';
    const pin_code = 'pin_code';
    const aadhaar_front_photo = 'aadhaar_front_photo';
    const aadhaar_back_photo = 'aadhaar_back_photo';
    const licence_front_photo = 'licence_front_photo';
    const licence_back_photo = 'licence_back_photo';
    const passport_size_photo = 'passport_size_photo';
    const vehicle_RTO_registration_number = 'vehicle_RTO_registration_number';
    const vehicle_rc_number = 'vehicle_rc_number';
    const vehicle_colour = 'vehicle_colour';
    const vehicle_make_year = 'vehicle_make_year';
    const vehicle_type = 'vehicle_type';
    const global_vehicle_id = 'global_vehicle_id';
    const vehicle_front_photo = 'vehicle_front_photo';
    const vehicle_back_photo = 'vehicle_back_photo';
    const vehicle_left_photo = 'vehicle_left_photo';
    const vehicle_right_photo = 'vehicle_right_photo';
    const request_token = 'request_token';
    const status = 'status';

    const driver_registartion_request_all = self::driver_registartion_request . AppConfig::DOT . AppConfig::STAR;
    const driver_full_name = self::driver_registartion_request . AppConfig::DOT . self::full_name;
    const driver_email = self::driver_registartion_request . AppConfig::DOT . self::email;
    const driver_contact_number = self::driver_registartion_request . AppConfig::DOT . self::contact_number;
    const driver_date_of_birth = self::driver_registartion_request . AppConfig::DOT . self::date_of_birth;
    const driver_house_number = self::driver_registartion_request . AppConfig::DOT . self::house_number;
    const driver_building_name = self::driver_registartion_request . AppConfig::DOT . self::building_name;
    const driver_street_name = self::driver_registartion_request . AppConfig::DOT . self::street_name;
    const driver_landmark = self::driver_registartion_request . AppConfig::DOT . self::landmark;
    const driver_state = self::driver_registartion_request . AppConfig::DOT . self::state;
    const driver_district = self::driver_registartion_request . AppConfig::DOT . self::district;
    const driver_pin_code = self::driver_registartion_request . AppConfig::DOT . self::pin_code;
    const driver_aadhaar_front_photo = self::driver_registartion_request . AppConfig::DOT . self::aadhaar_front_photo;
    const driver_aadhaar_back_photo = self::driver_registartion_request . AppConfig::DOT . self::aadhaar_back_photo;
    const driver_licence_front_photo = self::driver_registartion_request . AppConfig::DOT . self::licence_front_photo;
    const driver_licence_back_photo = self::driver_registartion_request . AppConfig::DOT . self::licence_back_photo;
    const driver_passport_size_photo = self::driver_registartion_request . AppConfig::DOT . self::passport_size_photo;
    const driver_vehicle_RTO_registration_number = self::driver_registartion_request . AppConfig::DOT . self::vehicle_RTO_registration_number;
    const driver_vehicle_rc_number = self::driver_registartion_request . AppConfig::DOT . self::vehicle_rc_number;
    const driver_vehicle_colour = self::driver_registartion_request . AppConfig::DOT . self::vehicle_colour;
    const driver_vehicle_make_year = self::driver_registartion_request . AppConfig::DOT . self::vehicle_make_year;
    const driver_vehicle_type = self::driver_registartion_request . AppConfig::DOT . self::vehicle_type;
    const driver_global_vehicle_id = self::driver_registartion_request . AppConfig::DOT . self::global_vehicle_id;
    const driver_vehicle_front_photo = self::driver_registartion_request . AppConfig::DOT . self::vehicle_front_photo;
    const driver_vehicle_back_photo = self::driver_registartion_request . AppConfig::DOT . self::vehicle_back_photo;
    const driver_vehicle_left_photo = self::driver_registartion_request . AppConfig::DOT . self::vehicle_left_photo;
    const driver_vehicle_right_photo = self::driver_registartion_request . AppConfig::DOT . self::vehicle_right_photo;
    const driver_request_token = self::driver_registartion_request . AppConfig::DOT . self::request_token;
    const driver_status = self::driver_registartion_request . AppConfig::DOT . self::status;

    protected $table = self::driver_registartion_request;
    protected $fillable = [
        self::full_name,
        self::email,
        self::contact_number,
        self::date_of_birth,
        self::house_number,
        self::building_name,
        self::street_name,
        self::landmark,
        self::state,
        self::district,
        self::pin_code,
        self::aadhaar_front_photo,
        self::aadhaar_back_photo,
        self::licence_front_photo,
        self::licence_back_photo,
        self::passport_size_photo,
        self::vehicle_RTO_registration_number,
        self::vehicle_rc_number,
        self::vehicle_colour,
        self::vehicle_make_year,
        self::vehicle_type,
        self::global_vehicle_id,
        self::vehicle_front_photo,
        self::vehicle_back_photo,
        self::vehicle_left_photo,
        self::vehicle_right_photo,
        self::request_token,
        self::status
    ];

    public $timestamps = true;

    //add a driver personal info
    public static function addPersonalInformation($request)
    {

        $validator = Validator::make($request->all(), [
            self::full_name => 'required',
            self::email => 'required',
            self::contact_number => 'required',
            self::date_of_birth => 'required',
            self::request_token => 'required'
        ]);

        if ($validator->fails()) {

            return APIResponses::failed_result("Please provide a all filed , all are required");
        } else {

            $data = new self();
            $data[self::full_name] = $request[self::full_name];
            $data[self::email] = $request[self::email];
            $data[self::contact_number] = $request[self::contact_number];
            $data[self::date_of_birth] = $request[self::date_of_birth];
            $data[self::status] = 1;

          

            $data[self::request_token] = $request[self::request_token];
            $result = $data->save();
            $driver_id = $data->id;

            $resultData = ["request_token" => $request[self::request_token], "driver_id" => $driver_id];

            if ($result) {
                return APIResponses::success_result_with_data("Basic Information added", array($resultData));
            } else return APIResponses::failed_result("Registration failed please try again...");
        }
    }

    public static function addAddressDetails($request)
    {

        $validator = Validator::make($request->all(), [
            self::house_number => 'required',
            self::building_name => 'required',
            self::street_name => 'required',
            self::landmark => 'required',
            self::state => 'required',
            self::district => 'required',
            self::pin_code => 'required'
        ]);

        if ($validator->fails()) {

            return APIResponses::failed_result("Please provide all filed , all are required");
        }
        else{

            if (self::where(self::request_token, $request[self::request_token])->first()) {

                $address[self::house_number] = $request[self::house_number];
                $address[self::building_name] = $request[self::building_name];
                $address[self::street_name] = $request[self::street_name];
                $address[self::landmark] = $request[self::landmark];
                $address[self::state] = $request[self::state];
                $address[self::district] = $request[self::district];
                $address[self::pin_code] = $request[self::pin_code];
                $address[self::status] = 2;
    
                $addressUpdateResult = self::where(self::request_token, $request[self::request_token])->update($address);
    
                if ($addressUpdateResult) {
                    return APIResponses::success_result("Address Addedd Successfully");
                } else return APIResponses::failed_result("Address not addedd please try again");
            } else {
                return APIResponses::failed_result("This user not register please fill personal details first");
            }
        }
    }

    public static function addKYCDetails($request)
    {

        $title = $request->input('title');

        $validator = Validator::make($request->all(), [
            self::request_token => 'required',
            'title' => 'required',
            $request->file('image') => 'required'
        ]);

        if ($validator->fails()) {

            return  APIResponses::failed_result("Please check requested token and title not null or empty");
        } else {

            if (self::where(self::request_token, $request[self::request_token])->first()) {

                if ($title === "aadhaar_front_photo") {

                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/kycdoc/', $filename);


                        $update[self::aadhaar_front_photo] = $filename;
                        $update[self::status] = 3;

                    } else {
                        return $request;
                    }

                    $result =  self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Aadhaar Front Image Uploaded Successfully");
                    else return APIResponses::failed_result("Aadhaar Front Image Uploaded failed");
                } elseif ($title === "aadhaar_back_photo") {

                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/kycdoc/', $filename);


                        $update[self::aadhaar_back_photo] = $filename;
                        $update[self::status] = 3;
                    } else {
                        return $request;
                    }

                    $result = self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Aadhar Back Image Uploaded Successfully");
                    else return APIResponses::failed_result("Aadhar Back Image Uploaded failed");
                } elseif ($title === "licence_front_photo") {

                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/kycdoc/', $filename);


                        $update[self::licence_front_photo] = $filename;
                        $update[self::status] = 3;
                    } else {
                        return $request;
                    }

                    $result =  self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Licence Front Image Uploaded Successfully");
                    else return APIResponses::failed_result("Licence Front Image Uploaded failed");
                } elseif ($title === "licence_back_photo") {

                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/kycdoc/', $filename);


                        $update[self::licence_back_photo] = $filename;
                        $update[self::status] = 3;
                    } else {
                        return $request;
                    }

                    $result = self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Licence Back Image Uploaded Successfully");
                    else return APIResponses::failed_result("Licence Back Image Uploaded failed");
                } elseif ($title === "passport_size_photo") {

                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/kycdoc/', $filename);


                        $update[self::passport_size_photo] = $filename;
                        $update[self::status] = 3;
                    } else {
                        return $request;
                    }

                    $result = self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Passport Photo Uploaded Successfully");
                    else return APIResponses::failed_result("Passport Photo Uploaded failed");
                } else {
                    return APIResponses::failed_result("Invalid request..please check again");
                }
            } else {
                return APIResponses::failed_result("This user request in invalid please try again...");
            }
        }
    }

    public static function  addVehicleDetails($request)
    {

        $validator = Validator::make($request->all(), [
            self::request_token => 'required',
            self::vehicle_RTO_registration_number => 'required',
            self::vehicle_rc_number => 'required',
            self::vehicle_colour => 'required',
            self::vehicle_make_year => 'required',
            self::vehicle_type => 'required',
            self::global_vehicle_id => 'required',
        ]);

        if ($validator->fails()) {
            
            return APIResponses::failed_result("Please provide request token");
        } 
        else {

            if (self::where(self::request_token, $request[self::request_token])->first()) {

                $vehicleDetails[self::vehicle_RTO_registration_number] = $request[self::vehicle_RTO_registration_number];
                $vehicleDetails[self::vehicle_rc_number] = $request[self::vehicle_rc_number];
                $vehicleDetails[self::vehicle_colour] = $request[self::vehicle_colour];
                $vehicleDetails[self::vehicle_make_year] = $request[self::vehicle_make_year];
                $vehicleDetails[self::vehicle_type] = $request[self::vehicle_type];
                $vehicleDetails[self::global_vehicle_id] = $request[self::global_vehicle_id];
                $vehicleDetails[self::status] = 4;

                $vehicleDetailsResult = self::where(self::request_token, $request[self::request_token])->update($vehicleDetails);

                if ($vehicleDetailsResult) {
                    return APIResponses::success_result("Vehicle Details Addedd SuccessFully");
                } else return APIResponses::failed_result("Vehicle Details Not Addeddd SuccessFully. please try again");
            } else return APIResponses::failed_result("Something went wrong");
        }
    }

    public static function addVehicleProfilePicture($request)
    {

        $validator = Validator::make($request->all(), [
            self::request_token => 'required',
            'title' => 'required'
        ]);

        if ($validator->fails()) {
            return  APIResponses::failed_result("Please check requested token and title not null or empty");
        } else {

            $title = $request->input('title');

            if (self::where(self::request_token, $request[self::request_token])->first()) {

                if ($title === "vehicle_front_photo") {

                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/vehicle/', $filename);


                        $update[self::vehicle_front_photo] = $filename;
                        $update[self::status] = 5;
                    } else {
                        return $request;
                    }

                    $result =  self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Vehicle Front Image Uploaded Successfully");
                    else  return  APIResponses::failed_result("Vehicle Front Image Uploaded Failed");
                } elseif ($title === "vehicle_back_photo") {

                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/vehicle/', $filename);


                        $update[self::vehicle_back_photo] = $filename;
                        $update[self::status] = 5;
                    } else {
                        return $request;
                    }

                    $result = self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Vehicle Back Image Uploaded Successfully");
                    else  return  APIResponses::failed_result("Vehicle Back Image Uploaded Failed");
                } elseif ($title === "vehicle_left_photo") {

                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/vehicle/', $filename);


                        $update[self::vehicle_left_photo] = $filename;
                        $update[self::status] = 5;
                    } else {
                        return $request;
                    }

                    $result = self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Vehicle Left Image Uploaded Successfully");
                    else return  APIResponses::failed_result("Vehicle Left Image Uploaded Failed");
                } elseif ($title === "vehicle_right_photo") {

                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/vehicle/', $filename);


                        $update[self::vehicle_right_photo] = $filename;
                        $update[self::status] = 5;
                    } else {
                        return $request;
                    }

                    $result = self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Vehicle Right Image Uploaded Successfully");
                    else  return  APIResponses::failed_result("Vehicle Right Image Uploaded Failed");
                } else return APIResponses::failed_result("Please select a image ....");
            } else return APIResponses::failed_result("Something went wrong");
        }
    }

    //check driver registration process and start from previous
    public static function driverRegistrationProcess($request)
    {

        $validator = Validator::make($request->all(), [
            self::request_token => 'required'

        ]);

        if ($validator->fails()) {
            return APIResponses::failed_result("Request token is required");
        } else {

            if (self::where(self::request_token, $request[self::request_token])->first()) {

                $process = self::select(self::status)->where(self::request_token, $request[self::request_token])->get();

                if (!empty($process[0][self::status])) {

                    if ($process[0][self::status] === "3") {

                        $kycDetails = self::keyDetailsStatus($request);
                        return $kycDetails;
                    } else if ($process[0][self::status] === "4") {

                        return response()->json([$response = "result" => true, "message" => "Vehicle Details Found", "processCompleteStatus" => "4"]);
                    } else if ($process[0][self::status] === "5") {

                        return self::vehicleProfilePictureDetails($request);
                    } else if ($process[0][self::status] === "2") {
                        return response()->json([$response = "result" => true, "message" => "Address Details Found", "processCompleteStatus" => "2"]);
                    } else if ($process[0][self::status] === "1") {
                        return response()->json([$response = "result" => true, "message" => "Basic Details Found", "processCompleteStatus" => "1"]);
                    }
                } else {
                    return response()->json([$response = "result" => true, "message" => "Details Not Found", "processCompleteStatus" => "0"]);
                }
            } else return APIResponses::failed_result("Please try to create a new account");
        }
    }

    public static function keyDetailsStatus($request)
    {
        $kycDetails = self::select(
            self::aadhaar_front_photo,
            self::aadhaar_back_photo,
            self::licence_front_photo,
            self::licence_back_photo,
            self::passport_size_photo
        )
            ->where(self::request_token, $request[self::request_token])
            ->get();
        if (!empty($kycDetails[0][self::aadhaar_front_photo])) {

            if (!empty($kycDetails[0][self::aadhaar_back_photo])) {

                if (!empty($kycDetails[0][self::licence_front_photo])) {

                    if (!empty($kycDetails[0][self::licence_back_photo])) {

                        if (!empty($kycDetails[0][self::passport_size_photo])) {

                            $kycNeedFrom = ["aadhaar_front_photo" => true, "aadhaar_back_photo" => true, "licence_front_photo" => true, "licence_back_photo" => true, "passport_size_photo" => true];
                            return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "3", "processComplete" => array($kycNeedFrom)]);
                        } else {

                            $kycNeedFrom = ["aadhaar_front_photo" => true, "aadhaar_back_photo" => true, "licence_front_photo" => true, "licence_back_photo" => true, "passport_size_photo" => false];
                            return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "3", "processComplete" => array($kycNeedFrom)]);
                        }
                    } else {

                        $kycNeedFrom = ["aadhaar_front_photo" => true, "aadhaar_back_photo" => true, "licence_front_photo" => true, "licence_back_photo" => false];
                        return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "3", "processComplete" => array($kycNeedFrom)]);
                    }
                } else {

                    $kycNeedFrom = ["aadhaar_front_photo" => true, "aadhaar_back_photo" => true, "licence_front_photo" => false];
                    return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "3", "processComplete" => array($kycNeedFrom)]);
                }
            } else {
                $kycNeedFrom = ["aadhaar_front_photo" => true, "aadhaar_back_photo" => false];
                return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "3", "processComplete" => array($kycNeedFrom)]);
            }
        } else return APIResponses::failed_result_with_data("Need KYC Details FillUp", 3);
    }

    public static function vehicleProfilePictureDetails($request)
    {

        $vehicleProfilePic = self::select(
            self::vehicle_front_photo,
            self::vehicle_back_photo,
            self::vehicle_left_photo,
            self::vehicle_right_photo
        )
            ->where(self::request_token, $request[self::request_token])
            ->get();
        if (!empty($vehicleProfilePic)) {

            if (!empty($vehicleProfilePic[0][self::vehicle_front_photo])) {

                if (!empty($vehicleProfilePic[0][self::vehicle_back_photo])) {

                    if (!empty($vehicleProfilePic[0][self::vehicle_left_photo])) {

                        if (!empty($vehicleProfilePic[0][self::vehicle_right_photo])) {

                            return response()->json([$response = "result" => true, "message" => "Registration Request Completed", "processCompleteStatus" => "6"]);
                        } else {

                            $vehiclePicDetails = ["vehicle_front_photo" => true, "vehicle_back_photo" => true, "vehicle_left_photo" => true, "vehicle_right_photo" => false];
                            return response()->json([$response = "result" => true, "message" => "Vehicle Profile Details found", "processCompleteStatus" => "5", "processComplete" => array($vehiclePicDetails)]);
                        }
                    } else {

                        $vehiclePicDetails = ["vehicle_front_photo" => true, "vehicle_back_photo" => true, "vehicle_left_photo" => false];
                        return response()->json([$response = "result" => true, "message" => "Vehicle Profile Details found", "processCompleteStatus" => "5", "processComplete" => array($vehiclePicDetails)]);
                    }
                } else {

                    $vehiclePicDetails = ["vehicle_front_photo" => true, "vehicle_back_photo" => false];
                    return response()->json([$response = "result" => true, "message" => "Vehicle Profile Details found", "processCompleteStatus" => "5", "processComplete" => array($vehiclePicDetails)]);
                }
            } else return response()->json([$response = "result" => true, "message" => "Vehicle Details Found", "processCompleteStatus" => "4"]);
        } else return response()->json([$response = "result" => true, "message" => "Vehicle Details Found", "processCompleteStatus" => "4"]);
    }
}
