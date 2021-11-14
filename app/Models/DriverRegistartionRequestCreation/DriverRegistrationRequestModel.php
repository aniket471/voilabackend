<?php

namespace App\Models\DriverRegistartionRequestCreation;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use App\Models\CommonImageCreation\CommanImageModel;
use App\Models\Required_Docs_Creation\DriverAddressRequiredDocs;
use App\Models\Required_Docs_Creation\DriverKYCRequiredDocsModel;
use App\Models\Required_Docs_Creation\DriverRegistrationRequiredDocsModel;
use App\Models\Required_Docs_Creation\DriverVehicleRequiredDocsModel;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Environment\Console;

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
    const pan_card = 'pan_card';
    const vehicle_RTO_registration_number = 'vehicle_RTO_registration_number';
    const vehicle_rc_number = 'vehicle_rc_number';
    const vehicle_colour = 'vehicle_colour';
    const vehicle_make_year = 'vehicle_make_year';
    const vehicle_type = 'vehicle_type';
    const vehicle_brand = 'vehicle_brand';
    const vehicle_model = 'vehicle_model';
    const global_vehicle_id = 'global_vehicle_id';
    const vehicle_front_photo = 'vehicle_front_photo';
    const vehicle_back_photo = 'vehicle_back_photo';
    const vehicle_left_photo = 'vehicle_left_photo';
    const vehicle_right_photo = 'vehicle_right_photo';
    const request_token = 'request_token';
    const status = 'status';
    const account_verification_status = 'account_verification_status';
    const vehicle_rc = 'vehicle_rc';
    const vehicle_insurance = 'vehicle_insurance';
    const vehicle_permit = 'vehicle_permit';
    const is_deliver_partner = 'is_deliver_partner';

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
    const driver_pan_card = self::driver_registartion_request . AppConfig::DOT . self::pan_card;
    const driver_vehicle_RTO_registration_number = self::driver_registartion_request . AppConfig::DOT . self::vehicle_RTO_registration_number;
    const driver_vehicle_rc_number = self::driver_registartion_request . AppConfig::DOT . self::vehicle_rc_number;
    const driver_vehicle_colour = self::driver_registartion_request . AppConfig::DOT . self::vehicle_colour;
    const driver_vehicle_make_year = self::driver_registartion_request . AppConfig::DOT . self::vehicle_make_year;
    const driver_vehicle_type = self::driver_registartion_request . AppConfig::DOT . self::vehicle_type;
    const driver_vehicle_model = self::driver_registartion_request . AppConfig::DOT . self::vehicle_model;
    const driver_vehicle_brand = self::driver_registartion_request . AppConfig::DOT . self::vehicle_brand;
    const driver_global_vehicle_id = self::driver_registartion_request . AppConfig::DOT . self::global_vehicle_id;
    const driver_vehicle_front_photo = self::driver_registartion_request . AppConfig::DOT . self::vehicle_front_photo;
    const driver_vehicle_back_photo = self::driver_registartion_request . AppConfig::DOT . self::vehicle_back_photo;
    const driver_vehicle_left_photo = self::driver_registartion_request . AppConfig::DOT . self::vehicle_left_photo;
    const driver_vehicle_right_photo = self::driver_registartion_request . AppConfig::DOT . self::vehicle_right_photo;
    const driver_request_token = self::driver_registartion_request . AppConfig::DOT . self::request_token;
    const driver_status = self::driver_registartion_request . AppConfig::DOT . self::status;
    const driver_account_verification_status = self::driver_registartion_request . AppConfig::DOT . self::account_verification_status;
    const driver_vehicle_rc = self::driver_registartion_request . AppConfig::DOT . self::vehicle_rc;
    const driver_vehicle_insurance = self::driver_registartion_request . AppConfig::DOT . self::vehicle_insurance;
    const driver_vehicle_permit = self::driver_registartion_request . AppConfig::DOT . self::vehicle_permit;
    const driver_is_deliver_partner = self::driver_registartion_request . AppConfig::DOT . self::is_deliver_partner;


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
        self::pan_card,
        self::vehicle_RTO_registration_number,
        self::vehicle_rc_number,
        self::vehicle_colour,
        self::vehicle_make_year,
        self::vehicle_type,
        self::vehicle_brand,
        self::vehicle_model,
        self::global_vehicle_id,
        self::vehicle_front_photo,
        self::vehicle_back_photo,
        self::vehicle_left_photo,
        self::vehicle_right_photo,
        self::request_token,
        self::status,
        self::account_verification_status,
        self::vehicle_rc,
        self::vehicle_insurance,
        self::vehicle_permit,
        self::is_deliver_partner
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

            if (self::where(self::request_token, $request[self::request_token])->first()) {

                $data[self::full_name] = $request[self::full_name];
                $data[self::email] = $request[self::email];
                $data[self::contact_number] = $request[self::contact_number];
                $data[self::date_of_birth] = $request[self::date_of_birth];
                $data[self::status] = 1;
                $data[self::account_verification_status] = 0;

                if($request[self::is_deliver_partner] == "partner"){
                    $data[self::is_deliver_partner] = "delivery_partner";
                }        

                $data[self::request_token] = $request[self::request_token];

                $result = self::where(self::request_token, $request[self::request_token])->update($data);
                $userId = self::select('id')->where(self::request_token, $request[self::request_token])->get();

                $resultData = ["request_token" => $request[self::request_token], "driver_id" => $userId[0]['id']];

                if ($result) {
                    return APIResponses::success_result_with_data("Basic Information added", array($resultData));
                } else return APIResponses::failed_result("Registration failed please try again...");
            } else {

                $data = new self();
                $data[self::full_name] = $request[self::full_name];
                $data[self::email] = $request[self::email];
                $data[self::contact_number] = $request[self::contact_number];
                $data[self::date_of_birth] = $request[self::date_of_birth];
                $data[self::status] = 1;
                $data[self::account_verification_status] = 0;

                if($request[self::is_deliver_partner] == "partner"){
                    $data[self::is_deliver_partner] = "delivery_partner";
                }        

                $data[self::request_token] = $request[self::request_token];
                $result = $data->save();
                $driver_id = $data->id;

                $resultData = ["request_token" => $request[self::request_token], "driver_id" => $driver_id];

                if ($result) {
                    return APIResponses::success_result_with_data("Basic Information added", array($resultData));
                } else return APIResponses::failed_result("Registration failed please try again...");
            }
        }
    }

    public static function addAddressDetails($request)
    {

        $forUpdate = $request["update"];

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
        } else {


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
        //  return $request[self::request_token];

        $title = $request->input('title');

        $validator = Validator::make($request->all(), [
            self::request_token => 'required',
            'title' => 'required'
        ]);

        if ($validator->fails()) {

            return  APIResponses::failed_result("Please check requested token and title not null or empty");
        } else {

            $tokens = self::all();

            // printf($tokens);

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
                } elseif ($title === "pan_card") {

                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/kycdoc/', $filename);


                        $update[self::pan_card] = $filename;
                        $update[self::status] = 3;
                    } else {
                        return $request;
                    }

                    $result = self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Pan Card Uploaded Successfully");
                    else return APIResponses::failed_result("Pan Card Uploaded failed");
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
            self::vehicle_brand => 'required',
            self::vehicle_model => 'required'
        ]);

        if ($validator->fails()) {

            return APIResponses::failed_result("Please provide request token");
        } else {

            if (self::where(self::request_token, $request[self::request_token])->first()) {

                $vehicleDetails[self::vehicle_RTO_registration_number] = $request[self::vehicle_RTO_registration_number];
                $vehicleDetails[self::vehicle_rc_number] = $request[self::vehicle_rc_number];
                $vehicleDetails[self::vehicle_colour] = $request[self::vehicle_colour];
                $vehicleDetails[self::vehicle_make_year] = $request[self::vehicle_make_year];
                $vehicleDetails[self::vehicle_type] = $request[self::vehicle_type];
                $vehicleDetails[self::global_vehicle_id] = $request[self::global_vehicle_id];
                $vehicleDetails[self::vehicle_model] = $request[self::vehicle_model];
                $vehicleDetails[self::vehicle_brand] = $request[self::vehicle_brand];
                $vehicleDetails[self::status] = 4;

                $vehicleDetailsResult = self::where(self::request_token, $request[self::request_token])->update($vehicleDetails);

                if ($vehicleDetailsResult) {
                    return APIResponses::success_result("Vehicle Details Addedd SuccessFully");
                } else return APIResponses::failed_result("Vehicle Details Not Addeddd SuccessFully. please try again");
            } else return APIResponses::failed_result("Something went wrong");
        }
    }

    public static function  addDriverVehicleDetails($request)
    {

        $validator = Validator::make($request->all(), [
            self::request_token => 'required',
            "vehicle_rto_registration_number" => 'required',
            self::vehicle_rc_number => 'required',
            self::vehicle_colour => 'required',
            self::vehicle_make_year => 'required',
            self::vehicle_type => 'required',
            self::global_vehicle_id => 'required',
            self::vehicle_brand => 'required',
            self::vehicle_model => 'required'
        ]);

        if ($validator->fails()) {

            return APIResponses::failed_result("Please provide request token");
        } else {

            if (self::where(self::request_token, $request[self::request_token])->first()) {

                $vehicleDetails[self::vehicle_RTO_registration_number] = $request["vehicle_rto_registration_number"];
                $vehicleDetails[self::vehicle_rc_number] = $request[self::vehicle_rc_number];
                $vehicleDetails[self::vehicle_colour] = $request[self::vehicle_colour];
                $vehicleDetails[self::vehicle_make_year] = $request[self::vehicle_make_year];
                $vehicleDetails[self::vehicle_type] = $request[self::vehicle_type];
                $vehicleDetails[self::global_vehicle_id] = $request[self::global_vehicle_id];
                $vehicleDetails[self::vehicle_model] = $request[self::vehicle_model];
                $vehicleDetails[self::vehicle_brand] = $request[self::vehicle_brand];
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
                } elseif ($title === "vehicle_rc") {

                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/vehicle/', $filename);


                        $update[self::vehicle_rc] = $filename;
                        $update[self::status] = 5;
                    } else {
                        return $request;
                    }

                    $result = self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Vehicle RC Image Uploaded Successfully");
                    else  return  APIResponses::failed_result("Vehicle Rc Image Uploaded Failed");
                } elseif ($title === "vehicle_insurance") {
                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/vehicle/', $filename);


                        $update[self::vehicle_insurance] = $filename;
                        $update[self::status] = 5;
                    } else {
                        return $request;
                    }

                    $result = self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Vehicle Insurance Image Uploaded Successfully");
                    else  return  APIResponses::failed_result("Vehicle Insurance Image Uploaded Failed");
                } elseif ($title === "vehicle_permit") {
                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/vehicle/', $filename);


                        $update[self::vehicle_permit] = $filename;
                        $update[self::status] = 5;
                    } else {
                        return $request;
                    }

                    $result = self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Vehicle Permit Image Uploaded Successfully");
                    else  return  APIResponses::failed_result("Vehicle Permit Image Uploaded Failed");
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

                        return   $kycDetails = self::keyDetailsStatus($request);
                    } else if ($process[0][self::status] === "4") {

                        return self::toReviewVehicleInformation($request);
                        //return response()->json([$response = "result" => true, "message" => "Vehicle Details Found", "processCompleteStatus" => "4"]);
                    } else if ($process[0][self::status] === "5") {
                        return self::vehicleProfilePictureDetails($request);
                    } else if ($process[0][self::status] === "2") {

                        return self::toReviewAddressInformation($request);
                        return response()->json([$response = "result" => true, "message" => "Address Details Found", "processCompleteStatus" => "2"]);
                    } else if ($process[0][self::status] === "1") {

                        return self::toReviewBasicInformation($request);
                        // return response()->json([$response = "result" => true, "message" => "Basic Details Found", "processCompleteStatus" => "1"]);
                    }
                } else {

                    $data = DriverRegistrationRequiredDocsModel::getDriverRequiredDocs();
                    return response()->json([$response = "result" => true, "message" => "Registration incomplete", "processCompleteStatus" => "0", "needToProcessComplete" => $data]);
                }
            } else {
                $data = DriverRegistrationRequiredDocsModel::getDriverRequiredDocs();
                return response()->json([$response = "result" => true, "message" => "Registration incomplete", "processCompleteStatus" => "0", "needToProcessComplete" => $data]);
            }
        }
    }

    public static function keyDetailsStatus($request)
    {
        $kycDetails = self::select(
            self::aadhaar_front_photo,
            self::aadhaar_back_photo,
            self::licence_front_photo,
            self::licence_back_photo,
            self::passport_size_photo,
            self::pan_card,
            self::vehicle_RTO_registration_number
        )
            ->where(self::request_token, $request[self::request_token])
            ->get();

        if (!$kycDetails->isEmpty()) {

            if (!empty($kycDetails[0][self::aadhaar_front_photo])) {

                if (!empty($kycDetails[0][self::aadhaar_back_photo])) {

                    if (!empty($kycDetails[0][self::licence_front_photo])) {

                        if (!empty($kycDetails[0][self::licence_back_photo])) {

                            if (!empty($kycDetails[0][self::passport_size_photo])) {
                                if(!empty($kycDetails[0][self::vehicle_RTO_registration_number])){
                                    $vehicleDetails[self::status] = 5;
                                    $vehicleDetailsResult = self::where(self::request_token, $request[self::request_token])->update($vehicleDetails);
                                    return self::allRegistrationProcessIsCompleted($request);
                                }
                                else{
                                    $vehicleDetails = DriverVehicleRequiredDocsModel::getDocsByTextType();
                                    return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "3", "needToProcessComplete" => ($vehicleDetails)]);
                                    
                                }

                            } else {

                                $kycNeedFrom = DriverKYCRequiredDocsModel::getDriverKYCRequiredDocs();
                                foreach ($kycNeedFrom as $key => $follower) {
                                    if ($follower["required_docs_name"] === "Aadhaar Back Photo") {
                                        unset($kycNeedFrom[$key]);
                                    } elseif ($follower["required_docs_name"] === "Aadhaar Front Photo") {
                                        unset($kycNeedFrom[$key]);
                                    } elseif ($follower["required_docs_name"] === "Licence Front Photo") {
                                        unset($kycNeedFrom[$key]);
                                    } elseif ($follower["required_docs_name"] === "Licence Back Photo") {
                                        unset($kycNeedFrom[$key]);
                                    }
                                }
                                $new_data = array_values($kycNeedFrom->toArray());
                                return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "2", "needToProcessComplete" => ($new_data)]);
                            }
                        } else {

                            $kycNeedFrom = DriverKYCRequiredDocsModel::getDriverKYCRequiredDocs();
                            foreach ($kycNeedFrom as $key => $follower) {
                                if ($follower["required_docs_name"] === "Aadhaar Back Photo") {
                                    unset($kycNeedFrom[$key]);
                                } elseif ($follower["required_docs_name"] === "Aadhaar Front Photo") {
                                    unset($kycNeedFrom[$key]);
                                } elseif ($follower["required_docs_name"] === "Licence Front Photo") {
                                    unset($kycNeedFrom[$key]);
                                }
                            }
                            $new_data = array_values($kycNeedFrom->toArray());
                            return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "2", "needToProcessComplete" => ($new_data)]);
                        }
                    } else {

                        $kycNeedFrom = DriverKYCRequiredDocsModel::getDriverKYCRequiredDocs();
                        foreach ($kycNeedFrom as $key => $follower) {
                            if ($follower["required_docs_name"] === "Aadhaar Front Photo") {
                                unset($kycNeedFrom[$key]);
                            }
                            if ($follower["required_docs_name"] === "Aadhaar Back Photo") {
                                unset($kycNeedFrom[$key]);
                            }
                        }
                        $new_data = array_values($kycNeedFrom->toArray());
                        return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "2", "needToProcessComplete" => ($new_data)]);
                    }
                } else {

                    $kycNeedFrom = DriverKYCRequiredDocsModel::getDriverKYCRequiredDocs();
                    foreach ($kycNeedFrom as $key => $follower) {
                        if ($follower["required_docs_name"] === "Aadhaar Front Photo") {
                            unset($kycNeedFrom[$key]);
                        }
                    }
                    $new_data = array_values($kycNeedFrom->toArray());
                    return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "2", "needToProcessComplete" => ($new_data)]);
                }
            } else {

                $kycNeedFrom = DriverKYCRequiredDocsModel::getDriverKYCRequiredDocs();
                return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "2", "needToProcessComplete" => ($kycNeedFrom)]);
            }
        } else {

            $kycNeedFrom = DriverKYCRequiredDocsModel::getDriverKYCRequiredDocs();
            return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "2", "needToProcessComplete" => ($kycNeedFrom)]);
        }
    }

    public static function vehicleProfilePictureDetails($request)
    {

        $vehicleProfilePic = self::select(
            self::vehicle_front_photo,
            self::vehicle_back_photo,
            self::vehicle_left_photo,
            self::vehicle_right_photo,
            self::vehicle_rc,
            self::vehicle_insurance,
            self::vehicle_permit
        )
            ->where(self::request_token, $request[self::request_token])
            ->get();
        if (!empty($vehicleProfilePic)) {

            if (!empty($vehicleProfilePic[0][self::vehicle_front_photo])) {

                if (!empty($vehicleProfilePic[0][self::vehicle_back_photo])) {

                    if (!empty($vehicleProfilePic[0][self::vehicle_left_photo])) {

                        if (!empty($vehicleProfilePic[0][self::vehicle_right_photo])) {

                            if (!empty($vehicleProfilePic[0][self::vehicle_rc])) {

                                if (!empty($vehicleProfilePic[0][self::vehicle_insurance])) {

                                    if (!empty($vehicleProfilePic[0][self::vehicle_permit])) {
                                        return self::allRegistrationProcessIsCompleted($request);
                                    } else {

                                        $vehicleRequireDocs = DriverVehicleRequiredDocsModel::getDocsByImageType();
                                        foreach ($vehicleRequireDocs as $key => $follower) {
                                            if ($follower["required_docs_name"] === "Vehicle Front Photo") {
                                                unset($vehicleRequireDocs[$key]);
                                            } elseif ($follower["required_docs_name"] === "Vehicle Back Photo") {
                                                unset($vehicleRequireDocs[$key]);
                                            } elseif ($follower["required_docs_name"] === "Vehicle Left Photo") {
                                                unset($vehicleRequireDocs[$key]);
                                            } elseif ($follower["required_docs_name"] === "Vehicle Right Photo") {
                                                unset($vehicleRequireDocs[$key]);
                                            } elseif ($follower["required_docs_name"] === "Vehicle Rc") {
                                                unset($vehicleRequireDocs[$key]);
                                            } elseif ($follower["required_docs_name"] === "Vehicle Insurance") {
                                                unset($vehicleRequireDocs[$key]);
                                            }
                                        }
                                        $new_data = array_values($vehicleRequireDocs->toArray());
                                        return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "4", "needToProcessComplete" => ($new_data)]);
                                    }
                                } else {

                                    $vehicleRequireDocs = DriverVehicleRequiredDocsModel::getDocsByImageType();
                                    foreach ($vehicleRequireDocs as $key => $follower) {
                                        if ($follower["required_docs_name"] === "Vehicle Front Photo") {
                                            unset($vehicleRequireDocs[$key]);
                                        } elseif ($follower["required_docs_name"] === "Vehicle Back Photo") {
                                            unset($vehicleRequireDocs[$key]);
                                        } elseif ($follower["required_docs_name"] === "Vehicle Left Photo") {
                                            unset($vehicleRequireDocs[$key]);
                                        } elseif ($follower["required_docs_name"] === "Vehicle Right Photo") {
                                            unset($vehicleRequireDocs[$key]);
                                        } elseif ($follower["required_docs_name"] === "Vehicle Rc") {
                                            unset($vehicleRequireDocs[$key]);
                                        }
                                    }
                                    $new_data = array_values($vehicleRequireDocs->toArray());
                                    return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "4", "needToProcessComplete" => ($new_data)]);
                                }
                            } else {
                                $vehicleRequireDocs = DriverVehicleRequiredDocsModel::getDocsByImageType();
                                foreach ($vehicleRequireDocs as $key => $follower) {
                                    if ($follower["required_docs_name"] === "Vehicle Front Photo") {
                                        unset($vehicleRequireDocs[$key]);
                                    } elseif ($follower["required_docs_name"] === "Vehicle Back Photo") {
                                        unset($vehicleRequireDocs[$key]);
                                    } elseif ($follower["required_docs_name"] === "Vehicle Left Photo") {
                                        unset($vehicleRequireDocs[$key]);
                                    } elseif ($follower["required_docs_name"] === "Vehicle Right Photo") {
                                        unset($vehicleRequireDocs[$key]);
                                    }
                                }
                                $new_data = array_values($vehicleRequireDocs->toArray());
                                return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "4", "needToProcessComplete" => ($new_data)]);
                            }
                        } else {
                            $vehicleRequireDocs = DriverVehicleRequiredDocsModel::getDocsByImageType();
                            foreach ($vehicleRequireDocs as $key => $follower) {
                                if ($follower["required_docs_name"] === "Vehicle Front Photo") {
                                    unset($vehicleRequireDocs[$key]);
                                } elseif ($follower["required_docs_name"] === "Vehicle Back Photo") {
                                    unset($vehicleRequireDocs[$key]);
                                } elseif ($follower["required_docs_name"] === "Vehicle Left Photo") {
                                    unset($vehicleRequireDocs[$key]);
                                }
                            }
                            $new_data = array_values($vehicleRequireDocs->toArray());
                            return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "4", "needToProcessComplete" => ($new_data)]);
                        }
                    } else {

                        $vehicleRequireDocs = DriverVehicleRequiredDocsModel::getDocsByImageType();
                        foreach ($vehicleRequireDocs as $key => $follower) {
                            if ($follower["required_docs_name"] === "Vehicle Front Photo") {
                                unset($vehicleRequireDocs[$key]);
                            } elseif ($follower["required_docs_name"] === "Vehicle Back Photo") {
                                unset($vehicleRequireDocs[$key]);
                            }
                        }
                        $new_data = array_values($vehicleRequireDocs->toArray());
                        return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "4", "needToProcessComplete" => ($new_data)]);
                    }
                } else {

                    $vehicleRequireDocs = DriverVehicleRequiredDocsModel::getDocsByImageType();
                    foreach ($vehicleRequireDocs as $key => $follower) {
                        if ($follower["required_docs_name"] === "Vehicle Front Photo") {
                            unset($vehicleRequireDocs[$key]);
                        }
                    }
                    $new_data = array_values($vehicleRequireDocs->toArray());
                    return response()->json([$response = "result" => true, "message" => "Kyc Details found", "processCompleteStatus" => "4", "needToProcessComplete" => ($new_data)]);
                }
            } else {

                $vehicleRequireDocs = DriverVehicleRequiredDocsModel::getDocsByImageType();
                return response()->json([$response = "result" => true, "message" => "Vehicle Details Found", "processCompleteStatus" => "4", "needToProcessComplete" => $vehicleRequireDocs]);
            }
        } else {
            $vehicleRequireDocs = DriverVehicleRequiredDocsModel::getDocsByImageType();
            return response()->json([$response = "result" => true, "message" => "Vehicle Details Found", "processCompleteStatus" => "4", "needToProcessComplete" => $vehicleRequireDocs]);
        }
    }

    //check all basic information
    public static function toReviewBasicInformation($request)
    {

        $basicInfo = self::select(
            self::full_name,
            self::email,
            self::contact_number,
            self::date_of_birth,
            self::house_number
        )
            ->where(self::request_token, $request[self::request_token])
            ->get();
        if (!$basicInfo->isEmpty()) {

            if (!empty($basicInfo[0][self::full_name])) {

                if (!empty($basicInfo[0][self::email])) {

                    if (!empty($basicInfo[0][self::contact_number])) {

                        if (!empty($basicInfo[0][self::date_of_birth])) {

                            if(!empty($basicInfo[0][self::house_number])){
                                $vehicleDetails[self::status] = 5;
// update account verification state when basic infor rejected by c-person
                                $vehicleDetails[self::account_verification_status] = 3;
                                $vehicleDetailsResult = self::where(self::request_token, $request[self::request_token])->update($vehicleDetails);
                                return self::allRegistrationProcessIsCompleted($request);
                            }
                            else{
                                $addressRequiredDocs =  DriverAddressRequiredDocs::getDriverAddressRequiredDocs();
                                return response()->json([$response = "result" => true, "message" => "Registration incomplete", "processCompleteStatus" => "1", "needToProcessComplete" => $addressRequiredDocs]);
                            }
                        } else {

                            $requiredDocs = DriverRegistrationRequiredDocsModel::getDriverRequiredDocs($request);

                            return response()->json([$response = "result" => true, "message" => "Registration incomplete", "processCompleteStatus" => "0", "needToProcessComplete" => $requiredDocs]);
                        }
                    } else {

                        $requiredDocs = DriverRegistrationRequiredDocsModel::getDriverRequiredDocs($request);

                        return response()->json([$response = "result" => true, "message" => "Registration incomplete", "processCompleteStatus" => "0", "needToProcessComplete" => $requiredDocs]);
                    }
                } else {
                    $requiredDocs = DriverRegistrationRequiredDocsModel::getDriverRequiredDocs($request);

                    return response()->json([$response = "result" => true, "message" => "Registration incomplete", "processCompleteStatus" => "0", "needToProcessComplete" => $requiredDocs]);
                }
            } else {

                $requiredDocs = DriverRegistrationRequiredDocsModel::getDriverRequiredDocs($request);

                return response()->json([$response = "result" => true, "message" => "Registration incomplete", "processCompleteStatus" => "0", "needToProcessComplete" => $requiredDocs]);
            }
        }
    }

    //to check address information
    public static function toReviewAddressInformation($request)
    {

        $address = self::select(
            self::house_number,
            self::building_name,
            self::street_name,
            self::landmark,
            self::state,
            self::district,
            self::pin_code,
            self::aadhaar_front_photo
        )
            ->where(self::request_token, $request[self::request_token])
            ->get();
        //return $address;

        if (!$address->isEmpty()) {

            if (!empty($address[0][self::house_number]) && !empty($address[0][self::building_name])) {

                if (!empty($address[0][self::street_name]) && !empty($address[0][self::landmark])) {

                    if (!empty($address[0][self::state]) && !empty($address[0][self::district]) && !empty($address[0][self::pin_code])) {

                        if(!empty($address[0][self::aadhaar_front_photo])){
                            $vehicleDetails[self::status] = 5;
                            $vehicleDetailsResult = self::where(self::request_token, $request[self::request_token])->update($vehicleDetails);
                            return self::allRegistrationProcessIsCompleted($request);
                        }
                        else{
                            $kycNeedFrom = DriverKYCRequiredDocsModel::getDriverKYCRequiredDocs();
                            return response()->json([$response = "result" => true, "message" => "Registration incomplete", "processCompleteStatus" => "2", "needToProcessComplete" => $kycNeedFrom]);    
                        }
                    } else {

                        $addressRequiredDocs =  DriverAddressRequiredDocs::getDriverAddressRequiredDocs();
                        return response()->json([$response = "result" => true, "message" => "Registration incomplete", "processCompleteStatus" => "1", "needToProcessComplete" => $addressRequiredDocs]);
                    }
                } else {

                    $addressRequiredDocs =  DriverAddressRequiredDocs::getDriverAddressRequiredDocs();

                    return response()->json([$response = "result" => true, "message" => "Registration incomplete", "processCompleteStatus" => "1", "needToProcessComplete" => $addressRequiredDocs]);
                }
            } else {

                $addressRequiredDocs =  DriverAddressRequiredDocs::getDriverAddressRequiredDocs();

                return response()->json([$response = "result" => true, "message" => "Registration incomplete", "processCompleteStatus" => "1", "needToProcessComplete" => $addressRequiredDocs]);
            }
        } else {

            $addressRequiredDocs =  DriverAddressRequiredDocs::getDriverAddressRequiredDocs();

            return response()->json([$response = "result" => true, "message" => "Registration incomplete", "processCompleteStatus" => "1", "needToProcessComplete" => $addressRequiredDocs]);
        }
    }

    //to check vehicle information
    public static function toReviewVehicleInformation($request)
    {

        $vehicleDetails = self::select(
            self::vehicle_RTO_registration_number,
            self::vehicle_rc_number,
            self::vehicle_colour,
            self::vehicle_make_year,
            self::vehicle_model,
            self::vehicle_brand,
            self::vehicle_front_photo
        )
            ->where(self::request_token, $request[self::request_token])
            ->get();
        if (!$vehicleDetails->isEmpty()) {

            if (!empty($vehicleDetails[0][self::vehicle_RTO_registration_number]) && !empty($vehicleDetails[0][self::vehicle_rc_number])) {

                if (!empty($vehicleDetails[0][self::vehicle_colour]) && !empty($vehicleDetails[0][self::vehicle_make_year])) {

                    if (!empty($vehicleDetails[0][self::vehicle_model]) && !empty($vehicleDetails[0][self::vehicle_brand])) {
                        if(!empty($vehicleDetails[0][self::vehicle_front_photo])){
                            $vehicle_details[self::status] = 5;
                            $vehicleDetailsResult = self::where(self::request_token, $request[self::request_token])->update($vehicle_details);
                            return self::allRegistrationProcessIsCompleted($request);
                        }
                        else{
                            return self::vehicleProfilePictureDetails($request);
                        }
                        // $vehicleProfilePic = DriverVehicleRequiredDocsModel::getDocsByImageType();
                        // return response()->json([$response = "result" => true, "message" => "Registration incomplete", "processCompleteStatus" => "4", "needToProcessComplete" => $vehicleProfilePic]);
                    } else {
                        $vehicleRequireDocs = DriverVehicleRequiredDocsModel::getDocsByTextType();
                        return response()->json([$response = "result" => true, "message" => "Registration incomplete", "processCompleteStatus" => "3", "needToProcessComplete" => $vehicleRequireDocs]);
                    }
                } else {

                    $vehicleRequireDocs = DriverVehicleRequiredDocsModel::getDocsByTextType();
                    return response()->json([$response = "result" => true, "message" => "Registration incomplete", "processCompleteStatus" => "3", "needToProcessComplete" => $vehicleRequireDocs]);
                }
            } else {

                $kycNeedFrom = DriverVehicleRequiredDocsModel::getDocsByTextType();
                return response()->json([$response = "result" => true, "message" => "Registration incomplete", "processCompleteStatus" => "3", "needToProcessComplete" => $kycNeedFrom]);
            }
        } else {

            $kycNeedFrom = DriverVehicleRequiredDocsModel::getDocsByTextType();
            return response()->json([$response = "result" => true, "message" => "Registration incomplete", "processCompleteStatus" => "3", "needToProcessComplete" => $kycNeedFrom]);
        }
    }

    //all registration process is successfully completed
    public static function allRegistrationProcessIsCompleted($request)
    {

        $validator = Validator::make($request->all(), [
            self::request_token => 'required'
        ]);

        if ($validator->fails()) {

            return APIResponses::failed_result("Request token is required..");
        } else {

            if (self::where(self::request_token, $request[self::request_token])->first()) {
                if (self::where(self::account_verification_status, 1)->where(self::request_token,$request[self::request_token])->first()) {

                    $msg = "Your account is verifyed.. please share more";
                    $isVerify = true;
                    return APIResponses::success_result_with_data($msg, $isVerify);
                } else {
                    return CommanImageModel::getCommonImageForAccountUnderReview();
                }
            } else return APIResponses::failed_result("Request token is mismatch please try again");
        }
    }

    //get all registerd information before account verify to update the info
    public static function getAllRequestedInfo($request)
    {

        if (!empty($request[self::request_token])) {

            if (self::where(self::request_token, $request[self::request_token])->first()) {

                $regStatus = self::select(self::status)->where(self::request_token, $request[self::request_token])->get();

                if (!empty($regStatus[0][self::status])) {

                    if ($regStatus[0][self::status] == 1) {
                        $getBasicInfo = self::getBasicRequestedInfo($request);
                        $data = ["basicRequestedInfo" => $getBasicInfo];
                        return APIResponses::success("Requested Information found", "requestedInfo", array($data));
                    } elseif ($regStatus[0][self::status] == 2) {

                        $getAddressInfo = self::getAddressRequestedInfo($request);
                        $getBasicInfo = self::getBasicRequestedInfo($request);

                        $data = ["basicRequestedInfo" => $getBasicInfo, "addressRequestedInfo" => $getAddressInfo];

                        return APIResponses::success("Requested Information found", "requestedInfo", array($data));
                    } elseif ($regStatus[0][self::status] == 3) {
                        $getAddressInfo = self::getAddressRequestedInfo($request);
                        $getBasicInfo = self::getBasicRequestedInfo($request);
                        $getKYCInfo = self::getKYCRequestdInfo($request);

                        $data = ["basicRequestedInfo" => $getBasicInfo, "addressRequestedInfo" => $getAddressInfo, "kycRequestedInfo" => $getKYCInfo];

                        return APIResponses::success("Requested Information found", "requestedInfo", array($data));
                    } elseif ($regStatus[0][self::status] == 4) {
                        $getAddressInfo = self::getAddressRequestedInfo($request);
                        $getBasicInfo = self::getBasicRequestedInfo($request);
                        $getKYCInfo = self::getKYCRequestdInfo($request);
                        $vehicleInfo = self::getVehicleRequetedInfo($request);

                        $data = [
                            "basicRequestedInfo" => $getBasicInfo, "addressRequestedInfo" => $getAddressInfo,
                            "kycRequestedInfo" => $getKYCInfo, "vehicleRequestedInfo" => $vehicleInfo
                        ];


                        return APIResponses::success("Requested Information found", "requestedInfo", array($data));
                    } elseif ($regStatus[0][self::status] == 5) {
                        $getAddressInfo = self::getAddressRequestedInfo($request);
                        $getBasicInfo = self::getBasicRequestedInfo($request);
                        $getKYCInfo = self::getKYCRequestdInfo($request);
                        $vehicleInfo = self::getVehicleRequetedInfo($request);
                        $vehicleProfilePic = self::getVehicleProfilePicRequested($request);

                        $data = [
                            "basicRequestedInfo" => $getBasicInfo, "addressRequestedInfo" => $getAddressInfo,
                            "kycRequestedInfo" => $getKYCInfo, "vehicleRequestedInfo" => $vehicleInfo, "vehicleProfilePic" => $vehicleProfilePic
                        ];


                        return APIResponses::success("Requested Information found", "requestedInfo", array($data));
                    } elseif ($regStatus[0][self::status] == 6) {
                        return self::allRegistrationProcessIsCompleted($request);
                    }
                } else {
                    return APIResponses::failed_result("Something wents wrong please try after some time");
                }
            } else {
                return APIResponses::failed_result("This user is not valid please check the user auth");
            }
        } else {
            return APIResponses::failed_result("Request token is missing..please provide it.");
        }
    }

    //get all requested info to update before account verify
    public static function getBasicRequestedInfo($request)
    {

      return  $data = self::select(
            self::full_name,
            self::email,
            self::contact_number,
            self::date_of_birth
        )
            ->where(self::request_token, $request[self::request_token])
            ->get();

        // $requiredDocs = (DriverRegistrationRequiredDocsModel::getDriverRequiredDocs());


        // $abbreviations = array("AL", "AK", "AZ", "AR", "TX", "CA");
        // $states = array("Alabama", "Alaska", "Arizona", "Arkansas");
        // function combine_arr($a, $b)
        // {
        //     $acount = count($a);
        //     $bcount = count($b);
        //     $size = ($acount > $bcount) ? $bcount : $acount;
        //     $a = array_slice($a, 0, $size);
        //     $b = array_slice($b, 0, $size);
        //     return array_combine($a, $b);
        // }

        // for($i=0; $i<sizeof($data); $i++){
        //     for($j=0;$j<sizeof($requiredDocs);$j++){
        //         $combined[] = combine_arr(array($data[0][self::full_name]),array($requiredDocs[$j]));
        //     }
        // }
        // return($combined);
    }

    public static function getAddressRequestedInfo($request)
    {
        return self::select(
            self::house_number,
            self::building_name,
            self::street_name,
            self::landmark,
            self::state,
            self::district,
            self::pin_code
        )
            ->where(self::request_token, $request[self::request_token])
            ->get();
    }

    public static function getKYCRequestdInfo($request)
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
        $imageURL = array();
        foreach ($kycDetails as $key => $value) {
            $imageURL['aadhar_front_photo'] = asset('uploads/kycdoc/' . $kycDetails[0][self::aadhaar_front_photo]);
            $imageURL["aadhar_back_photo"] = asset('uploads/kycdoc/' . $kycDetails[0][self::aadhaar_back_photo]);
            $imageURL["licence_front_photo"] = asset('uploads/kycdoc/' . $kycDetails[0][self::licence_front_photo]);
            $imageURL["licence_back_photo"] = asset('uploads/kycdoc/' . $kycDetails[0][self::licence_back_photo]);
            $imageURL["passport_size_photo"] = asset('uploads/kycdoc/' . $kycDetails[0][self::passport_size_photo]);
            $imageURL["pan_card"] = asset('uploads/kycdoc/' . $kycDetails[0][self::pan_card]);
        }
        return array($imageURL);
    }

    public static function getVehicleRequetedInfo($request)
    {
        return self::select(
            self::vehicle_RTO_registration_number,
            self::vehicle_rc_number,
            self::vehicle_colour,
            self::vehicle_make_year,
            self::vehicle_type,
            self::vehicle_brand,
            self::vehicle_model
        )
            ->where(self::request_token, $request[self::request_token])
            ->get();
    }

    public static function getVehicleProfilePicRequested($request)
    {
        $requestDocs = self::select(
            self::vehicle_front_photo,
            self::vehicle_back_photo,
            self::vehicle_left_photo,
            self::vehicle_right_photo,
            self::vehicle_rc,
            self::vehicle_insurance,
            self::vehicle_permit
        )
            ->where(self::request_token, $request[self::request_token])
            ->get();

        $imageURL = array();
        foreach ($requestDocs as $key => $value) {
            $imageURL["vehicle_front_photo"] = asset('uploads/vehicle/' . $requestDocs[0][self::vehicle_front_photo]);
            $imageURL["vehicle_back_photo"] = asset('uploads/vehicle/' . $requestDocs[0][self::vehicle_back_photo]);
            $imageURL["vehicle_left_photo"] = asset('uploads/vehicle/' . $requestDocs[0][self::vehicle_left_photo]);
            $imageURL["vehicle_right_photo"] = asset('uploads/vehicle/' . $requestDocs[0][self::vehicle_right_photo]);
            $imageURL["vehicle_rc"] = asset('uploads/vehicle/' . $requestDocs[0][self::vehicle_rc]);
            $imageURL["vehicle_insurance"] = asset('uploads/vehicle/' . $requestDocs[0][self::vehicle_insurance]);
            $imageURL["vehicle_permit"] = asset('uploads/vehicle/' . $requestDocs[0][self::vehicle_permit]);

        }
        return array($imageURL);
    }

    //update personal information
    public static function updatePersonalInformation($request){

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

            if (self::where(self::request_token, $request[self::request_token])->first()) {

                $data[self::full_name] = $request[self::full_name];
                $data[self::email] = $request[self::email];
                $data[self::contact_number] = $request[self::contact_number];
                $data[self::date_of_birth] = $request[self::date_of_birth];
                $data[self::request_token] = $request[self::request_token];

                $result = self::where(self::request_token, $request[self::request_token])->update($data);
                $userId = self::select('id')->where(self::request_token, $request[self::request_token])->get();

                $resultData = ["request_token" => $request[self::request_token], "driver_id" => $userId[0]['id']];

                if ($result) {
                    return APIResponses::success_result_with_data("Basic Information added", array($resultData));
                } else return APIResponses::failed_result("Basic information not updated please try again...");
            }
             else {

                return APIResponses::failed_result("please try again...");
            }
        }
    }

    //update address informamtion
    public static function updateAddressInformation($request){

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
        } else {


            if (self::where(self::request_token, $request[self::request_token])->first()) {

                $address[self::house_number] = $request[self::house_number];
                $address[self::building_name] = $request[self::building_name];
                $address[self::street_name] = $request[self::street_name];
                $address[self::landmark] = $request[self::landmark];
                $address[self::state] = $request[self::state];
                $address[self::district] = $request[self::district];
                $address[self::pin_code] = $request[self::pin_code];

                $addressUpdateResult = self::where(self::request_token, $request[self::request_token])->update($address);

                if ($addressUpdateResult) {
                    return APIResponses::success_result("Address Addedd Successfully");
                } else return APIResponses::failed_result("Address not addedd please try again");
            } else {
                return APIResponses::failed_result("This user not register please fill personal details first");
            }
        }
    }

    //update vehicle information
    public static function updateVehicleInformation($request){
        $validator = Validator::make($request->all(), [
            self::request_token => 'required',
            "vehicle_rto_registration_number" => 'required',
            self::vehicle_rc_number => 'required',
            self::vehicle_colour => 'required',
            self::vehicle_make_year => 'required',
            self::vehicle_type => 'required',
            self::global_vehicle_id => 'required',
            self::vehicle_brand => 'required',
            self::vehicle_model => 'required'
        ]);

        if ($validator->fails()) {

            return APIResponses::failed_result("Please provide request token");
        } else {

            if (self::where(self::request_token, $request[self::request_token])->first()) {

                $vehicleDetails[self::vehicle_RTO_registration_number] = $request["vehicle_rto_registration_number"];
                $vehicleDetails[self::vehicle_rc_number] = $request[self::vehicle_rc_number];
                $vehicleDetails[self::vehicle_colour] = $request[self::vehicle_colour];
                $vehicleDetails[self::vehicle_make_year] = $request[self::vehicle_make_year];
                $vehicleDetails[self::vehicle_type] = $request[self::vehicle_type];
                $vehicleDetails[self::global_vehicle_id] = $request[self::global_vehicle_id];
                $vehicleDetails[self::vehicle_model] = $request[self::vehicle_model];
                $vehicleDetails[self::vehicle_brand] = $request[self::vehicle_brand];

                $vehicleDetailsResult = self::where(self::request_token, $request[self::request_token])->update($vehicleDetails);

                if ($vehicleDetailsResult) {
                    return APIResponses::success_result("Vehicle Details Addedd SuccessFully");
                } else return APIResponses::failed_result("Vehicle Details Not Addeddd SuccessFully. please try again");
            } else return APIResponses::failed_result("Something went wrong");
        }
    }

    //update kyc details
    public static function updateKYCDetails($request){

        $title = $request->input('title');

        $validator = Validator::make($request->all(), [
            self::request_token => 'required',
            'title' => 'required'
        ]);

        if ($validator->fails()) {

            return  APIResponses::failed_result("Please check requested token and title not null or empty");
        } else {

            $tokens = self::all();

            // printf($tokens);

            if (self::where(self::request_token, $request[self::request_token])->first()) {


                if ($title === "aadhaar_front_photo") {

                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/kycdoc/', $filename);


                        $update[self::aadhaar_front_photo] = $filename;

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

                    } else {
                        return $request;
                    }

                    $result = self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Passport Photo Uploaded Successfully");
                    else return APIResponses::failed_result("Passport Photo Uploaded failed");
                } elseif ($title === "pan_card") {

                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/kycdoc/', $filename);


                        $update[self::pan_card] = $filename;
                    } else {
                        return $request;
                    }

                    $result = self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Pan Card Uploaded Successfully");
                    else return APIResponses::failed_result("Pan Card Uploaded failed");
                } else {
                    return APIResponses::failed_result("Invalid request..please check again");
                }
            } else {

                return APIResponses::failed_result("This user request in invalid please try again...");
            }
        }
    }

    //update vehicle profile details
    public static function updateVehicleDocument($request){
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

                    } else {
                        return $request;
                    }

                    $result = self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Vehicle Right Image Uploaded Successfully");
                    else  return  APIResponses::failed_result("Vehicle Right Image Uploaded Failed");
                } elseif ($title === "vehicle_rc") {

                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/vehicle/', $filename);


                        $update[self::vehicle_rc] = $filename;

                    } else {
                        return $request;
                    }

                    $result = self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Vehicle RC Image Uploaded Successfully");
                    else  return  APIResponses::failed_result("Vehicle Rc Image Uploaded Failed");
                } elseif ($title === "vehicle_insurance") {
                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/vehicle/', $filename);


                        $update[self::vehicle_insurance] = $filename;

                    } else {
                        return $request;
                    }

                    $result = self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Vehicle Insurance Image Uploaded Successfully");
                    else  return  APIResponses::failed_result("Vehicle Insurance Image Uploaded Failed");
                } elseif ($title === "vehicle_permit") {
                    if ($request->hasfile('image')) {
                        $file = $request->file('image');
                        $extension = $file->getClientOriginalExtension();
                        $filename = time() . '.' . $extension;
                        $file->move('uploads/vehicle/', $filename);


                        $update[self::vehicle_permit] = $filename;

                    } else {
                        return $request;
                    }

                    $result = self::where(self::request_token, $request[self::request_token])->update($update);

                    if ($result) return APIResponses::success_result("Vehicle Permit Image Uploaded Successfully");
                    else  return  APIResponses::failed_result("Vehicle Permit Image Uploaded Failed");
                } else return APIResponses::failed_result("Please select a image ....");
            } else return APIResponses::failed_result("Something went wrong");
        }
    }

    public static function getKYCRequestdInfor($request)
    {

        $kycDetails = self::select(
            self::aadhaar_front_photo,
            self::aadhaar_back_photo,
            self::licence_front_photo,
            self::licence_back_photo,
            self::passport_size_photo,
            self::vehicle_front_photo,
            self::vehicle_back_photo,
            self::vehicle_left_photo,
            self::vehicle_right_photo,
            self::vehicle_rc,
            self::vehicle_insurance,
            self::vehicle_permit
        )
            ->where(self::request_token, $request[self::request_token])
            ->get();
        $imageURL = array();
        foreach ($kycDetails as $key => $value) {
            $imageURL['aadhar_front_photo'] = asset('uploads/kycdoc/' . $kycDetails[0][self::aadhaar_front_photo]);
            $imageURL["aadhar_back_photo"] = asset('uploads/kycdoc/' . $kycDetails[0][self::aadhaar_back_photo]);
            $imageURL["licence_front_photo"] = asset('uploads/kycdoc/' . $kycDetails[0][self::licence_front_photo]);
            $imageURL["licence_back_photo"] = asset('uploads/kycdoc/' . $kycDetails[0][self::licence_back_photo]);
            $imageURL["passport_size_photo"] = asset('uploads/kycdoc/' . $kycDetails[0][self::passport_size_photo]);
            $imageURL["pan_card"] = asset('uploads/kycdoc/' . $kycDetails[0][self::pan_card]);

            $imageURL["vehicle_front_photo"] = asset('uploads/vehicle/' . $kycDetails[0][self::vehicle_front_photo]);
            $imageURL["vehicle_back_photo"] = asset('uploads/vehicle/' . $kycDetails[0][self::vehicle_back_photo]);
            $imageURL["vehicle_left_photo"] = asset('uploads/vehicle/' . $kycDetails[0][self::vehicle_left_photo]);
            $imageURL["vehicle_right_photo"] = asset('uploads/vehicle/' . $kycDetails[0][self::vehicle_right_photo]);
            $imageURL["vehicle_rc"] = asset('uploads/vehicle/' . $kycDetails[0][self::vehicle_rc]);
            $imageURL["vehicle_insurance"] = asset('uploads/vehicle/' . $kycDetails[0][self::vehicle_insurance]);
            $imageURL["vehicle_permit"] = asset('uploads/vehicle/' . $kycDetails[0][self::vehicle_permit]);

        }
        return array($imageURL);
    }
  
}
