<?php

namespace App\Models\TripDetails_Modeule;

use App\Models\Common\APIResponses;
use App\Models\Common\AppConfig;
use App\Models\DriverInfo\DriverDetails\DriverDetails;
use App\Models\DriverInfo\DriverLocation\DriverVehicles;
use App\Models\Rider\RiderLogin;
use App\Models\VehicleIconCreationModule\VehicleIconModel;
use Carbon\Carbon;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use SebastianBergmann\CodeCoverage\Driver\Driver;
use Barryvdh\DomPDF\Facade as PDF;

use function PHPUnit\Framework\isEmpty;

class TripHistory extends Model
{
    use HasFactory;
    const trip_history  = 'trip_history';
    const rider_id = 'rider_id';
    const driver_id = 'driver_id';
    const trip_id = 'trip_id';
    const trip_rate = 'trip_rate';
    const rider_pickup_lat = 'rider_pickup_lat';
    const rider_pickup_long = 'rider_pickup_long';
    const rider_dest_lat = 'rider_dest_lat';
    const rider_dest_long = 'rider_dest_long';
    const rider_pickup_address = 'rider_pickup_address';
    const rider_drop_address = 'rider_drop_address';
    const updated_at = 'updated_at';
    const created_at = 'created_at';
    const trip_status = 'trip_status';

    const trip_history_all = self::trip_history . AppConfig::DOT . AppConfig::STAR;
    const trip_history_rider_id = self::trip_history . AppConfig::DOT . self::rider_id;
    const trip_history_driver_id = self::trip_history . AppConfig::DOT . self::driver_id;
    const trip_history_trip_id = self::trip_history . AppConfig::DOT . self::trip_id;
    const trip_history_trip_rate = self::trip_history . AppConfig::DOT . self::trip_rate;
    const trip_history_rider_pickup_lat = self::trip_history . AppConfig::DOT . self::rider_pickup_lat;
    const trip_history_rider_pickup_long = self::trip_history . AppConfig::DOT . self::rider_pickup_long;
    const trip_history_rider_dest_lat = self::trip_history . AppConfig::DOT . self::rider_dest_lat;
    const trip_history_rider_dest_long = self::trip_history . AppConfig::DOT . self::rider_dest_long;
    const trip_history_rider_pickup_address = self::trip_history . AppConfig::DOT . self::rider_pickup_address;
    const trip_history_rider_drop_address = self::trip_history . AppConfig::DOT . self::rider_drop_address;
    const trip_history_trip_status = self::trip_history . AppConfig::DOT . self::trip_status;
    const trip_history_created_at = self::trip_history . AppConfig::DOT . self::created_at;
    const trip_history_updated_at = self::trip_history . AppConfig::DOT . self::updated_at;

    protected $table = self::trip_history;
    protected $fillable = [
        self::rider_id,
        self::driver_id,
        self::trip_id,
        self::trip_rate,
        self::rider_pickup_lat,
        self::rider_pickup_long,
        self::rider_dest_lat,
        self::rider_dest_long,
        self::rider_pickup_address,
        self::rider_drop_address,
        self::updated_at,
        self::trip_status,
        self::created_at,
    ];

    public static function addTripHistory($request)
    {

        if (isset($request[0][self::rider_id]) && isset($request[0][self::driver_id])) {

            $data = $request;
            foreach ($data as $key => $value) {
                $value->saveTrip = self::saveTheTrips($value);
            }
            return $data;
        }
         else {
            return APIResponses::failed_result("Driver ID and Rider Id missing");
        }
    }

    public static function saveTheTrips($value)
    {

        $tripHistory = new self();
        $tripHistory[self::rider_id] = $value[self::rider_id];
        $tripHistory[self::driver_id] = $value[self::driver_id];
        $tripHistory[self::trip_id] = $value[self::trip_id];
        $tripHistory[self::trip_rate] = $value['driver_rate'];
        $tripHistory[self::rider_pickup_lat] = $value[self::rider_pickup_lat];
        $tripHistory[self::rider_pickup_long] = $value[self::rider_pickup_long];
        $tripHistory[self::rider_dest_lat] = $value[self::rider_dest_lat];
        $tripHistory[self::rider_dest_long] = $value[self::rider_dest_long];
        $tripHistory[self::rider_pickup_address] = $value[self::rider_pickup_address];
        $tripHistory[self::rider_drop_address] = $value[self::rider_drop_address];
        $tripHistory[self::trip_status] = 7;

        $result = $tripHistory->save();
        if ($result)
            return "trip history added";
        else
            return "trip history not added";
    }

    public static function getMidLatLng($request)
    {
        return
        $data = $request->input('data');
        $arr = json_decode($data,true);

        $getLatLng = self::select(self::rider_pickup_lat, self::rider_pickup_long)->where(self::rider_id,$arr[self::rider_id])->get();

        $totalComentarios = count($getLatLng);
        $mitadComentarios = floor($totalComentarios / 2);

        $primerosComentarios = $getLatLng[$mitadComentarios];

        $routeChangePoint = self::select(self::rider_pickup_lat, self::rider_pickup_long)->where(self::rider_id, $arr[self::rider_id])->first();

        $calculateDistanceOfMid = DriverVehicles::routeChangedCalculate(
            $primerosComentarios[self::rider_pickup_lat],
            $primerosComentarios[self::rider_pickup_long],
            $routeChangePoint[self::rider_pickup_lat],
            $routeChangePoint[self::rider_pickup_long]
        );

        $calculateTheDistanceMidToEnd = DriverVehicles::routeChangedCalculate($routeChangePoint[self::rider_pickup_lat], $routeChangePoint[self::rider_pickup_long], $arr[self::rider_dest_lat], $arr[self::rider_dest_long]);

        $calculateFinalDistance = $calculateDistanceOfMid + $calculateTheDistanceMidToEnd;


        return response()->json(["startToMid" => $calculateDistanceOfMid, "midToEnd" => $calculateTheDistanceMidToEnd, "TotalDistance" => $calculateFinalDistance]);
        return $primerosComentarios;
    }

    //require a driver_id and from_date and to_date
    public static function getDriverWeeklyEaring($request)
    {

        if(self::where(self::driver_id,$request[self::driver_id])->first()){

            $dates = self::where(self::driver_id, '=', $request[self::driver_id])
            ->whereBetween(self::created_at, array($request['from_date'], $request['to_date']))
            ->get([self::trip_rate]);

            return $dates;

            if(!$dates->isEmpty()){
                $sum = $dates->sum('trip_rate');
                return APIResponses::success_result_with_data("Record find",$sum);
            }
            else{
                return APIResponses::success_result("Record not found");
            }
        }
        else{

            return APIResponses::failed_result("Invalid driver . PLease check driver id....");
        }
        
    }
    //require a month in number like 6,5
    public static function getMonthWiseEarning($request){

        if(self::where(self::driver_id,$request[self::driver_id])->first()){

            $dates = self::select(self::trip_rate)->whereMonth(self::created_at,$request["month"])->get();
         //  return Carbon::now()->month();
            $newDates = self::select(DB::raw('MONTH(created_at) as month'))->groupBy('month')->get()->keyBy('month');

            if(!$dates->isEmpty()){
                $sum = $dates->sum('trip_rate');
                return APIResponses::success_result_with_data("Record find",$sum);
            }
           else{
            return APIResponses::success_result("Record not found");
           }
        }
        else{
            return APIResponses::failed_result("Invalid driver id . PLease check driver id");
        }
    }

    //generate pdf of invoice generate
    public static function generatePDF($request){
        $riderLogin = new RiderLogin();
        $tripHistory = new TripHistory();
        $riderName = $riderLogin::where('id',$request['id'])->get(['rider_name','id']);
    
        $driverId =  $riderName[0]["id"];
       // return $driverId;
        $trips = $tripHistory::where('trip_id',"2882037H4509292")
                              ->get([
                                  'trip_rate',
                                  'rider_pickup_address',
                                  'rider_drop_address',
                                  'updated_at'
                              ]);
    
       // return $trips;
        $data = [
          'title' => 'First PDF ',
          'heading' => 'Voila',
          'content' => 'Avishikar' ,
          'date' => '21/05/1999', 
          'riderName' => $riderName[0]["rider_name"],
          'tripRate' => $trips[0]["trip_rate"],
          'pickup_address' => $trips[0]["rider_pickup_address"],
          'drop_address' =>  $trips[0]["rider_drop_address"],
          'time' => $trips[0]["updated_at"],
          'email' => "99aniketsuryawanshi19@gmail.com",
          'title' => "Voila invoice",
            ];
        
       $pdf = PDF::loadView('generate_pdf', $data);
    
            Mail::send('generate_pdf', $data, function($message)use($data,$pdf) {
            $message->to($data["email"], $data["title"])
            ->subject($data["heading"])
            ->attachData($pdf->output(), "voila trip invoice.pdf");
            }); 
        return APIResponses::success_result("Invoice sent to email successfully");
    }

    public static function downloadPDf($request)
    {
        $riderLogin = new RiderLogin();
        $tripHistory = new TripHistory();
        $riderName = $riderLogin::where('id', $request['id'])->get(['rider_name', 'id']);

        
        if ($request["trip_id"] > 0) {

            $trips = $tripHistory::where('trip_id', $request["trip_id"])
                ->get([
                    'trip_rate',
                    'rider_pickup_address',
                    'rider_drop_address',
                    'updated_at'
                ]);

            $data = [
                'title' => 'First PDF ',
                'heading' => 'Voila',
                'content' => 'Avishikar',
                'date' => '21/05/1999',
                'riderName' => $riderName[0]["rider_name"],
                'tripRate' => $trips[0]["trip_rate"],
                'pickup_address' => $trips[0]["rider_pickup_address"],
                'drop_address' =>  $trips[0]["rider_drop_address"],
                'time' => $trips[0]["updated_at"],
                'email' => "pandharinath@skromanglobal.com",
                'title' => "Voila invoice",
            ];

            // $pdf = PDF::loadView('generate_pdf', $data);
            $pdf = PDF::loadView('generate_pdf', $data);
            return $pdf->download('VoilaTripInvoice.pdf');
        }
        else{
            return APIResponses::failed_result("trip id missing failed to download the pdf..");
        }
    }

    //check trip status if trip is completed or not
    public static function checkTripStatusTripEndOrNot($request){

        if(ConformTrips::where(ConformTrips::rider_id,$request[self::rider_id])->where(ConformTrips::trip_id,$request[ConformTrips::trip_id])->first()){

            $data = ConformTrips::select(ConformTrips::rider_dest_lat,ConformTrips::rider_dest_long,ConformTrips::driver_id)
                                  ->where(ConformTrips::rider_id,$request[self::rider_id])->where(ConformTrips::trip_id,$request[ConformTrips::trip_id])
                                  ->get();

                            
            //get driver vehicle type id
            $DriverVehicleTypeId = DriverDetails::select(DriverDetails::global_vehicle_id)->where(DriverDetails::driver_id,$data[0][self::driver_id])->get();
           
            $vehicleTypeImage = VehicleIconModel::getVehicleTypeWiseImage($DriverVehicleTypeId);

            foreach($data as $key=>$value){
                $value->vehicleImage = $vehicleTypeImage;
            }

            //return $data;
            return response()->json([$response = "result"=>true,'message'=>"Trip is start","startFlag"=>1,"dropLocation"=>$data]);
        }
        else{

            if(self::where(self::trip_id,$request[self::trip_id])->where(self::rider_id,$request[self::rider_id])
            ->where(self::driver_id,$request[self::driver_id])->first()){
                return response()->json([$response = "result"=>true,'message'=>"Trip is completed","startFlag"=>3]);
                return APIResponses::success_result("Trip is completed");
            }
            else{
                return response()->json([$response = "result"=>true,'message'=>"Trip is completed","startFlag"=>2]);
                return APIResponses::failed_result("Trip not completed");
            }
        }

        //startFlag means if trip is started then startFlag value is 1,
        //if trip is not completed then startFlag value is 2,
        //if trip is completed then startFlag value is 3
    }
}
