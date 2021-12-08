<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\ZoomMeetings;
use App\Http\Controllers\SMSController;
use Illuminate\Support\Facades\Auth;
use PhpParser\NodeVisitor\FirstFindingVisitor;
use Twilio\Page;

class ZoomController extends Controller
{
    
    public $client;
    public $jwt;
    public $headers;
    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;


    public function __construct()
    {
        $this->client = new Client();
        $this->jwt = $this->generateZoomToken();
        $this->headers = [
            'Authorization' => 'Bearer '.$this->jwt,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
        ];
    }

    public function generateZoomToken()
    {
        $key = env('ZOOM_API_KEY', '');
        $secret = env('ZOOM_API_SECRET', '');
        $payload = [
            'iss' => $key,
            'exp' => strtotime('+1 minute'),
        ];

        return \Firebase\JWT\JWT::encode($payload, $secret, 'HS256');
    }

    public function retrieveZoomUrl()
    {
        return env('ZOOM_API_URL', '');
    }

    public function toZoomTimeFormat(string $dateTime)
    {
        try {
            $date = new \DateTime($dateTime);

            return $date->format('Y-m-d\TH:i:s');
        } catch (\Exception $e) {
            Log::error('ZoomJWT->toZoomTimeFormat : '.$e->getMessage());

            return '';
        }
    }

    
    public function create($data)
    {
        $path = 'users/me/meetings';
        $url = $this->retrieveZoomUrl();

        $body = [
            'headers' => $this->headers,
            'body'    => json_encode([
                'topic'      => $data['topic'],
                'type'       => self::MEETING_TYPE_SCHEDULE,
                'start_time' => $this->toZoomTimeFormat($data['start_time']),
                'agenda'     => (! empty($data['agenda'])) ? $data['agenda'] : null,
                'timezone'     => 'Asia/Kolkata',
                'settings'   => [
                    'host_video'        => ($data['host_video'] == "1") ? true : false,
                    'participant_video' => ($data['participant_video'] == "1") ? true : false,
                    'waiting_room'      => true,
                ],
            ]),
        ];

        $response =  $this->client->post($url.$path, $body);

        return [
            'success' => $response->getStatusCode() === 201,
            'data'    => json_decode($response->getBody(), true),
        ];
    }

    public function index()
    {
        //return redirect()->away("https://us04web.zoom.us/wc/join/73561262755?pwd=czAycTJQZVF1RXA2QmxjMExFYWFhUT09");
        
        if(Auth::check()){
           
        // $path = 'users/me/meetings?page_size=300';
        // $url = $this->retrieveZoomUrl();
        // $body = [
        //     'headers' => $this->headers,
        //     "page_size"=>100,
        // ];
        // $response =  $this->client->get($url.$path, $body);
        
        
        // $data = json_decode($response->getBody(), true);
        // $r=[];
        // $count=0;
        // for($i=0;$i<count($data['meetings']);$i++){

        //     if(strpos($data['meetings'][$i]['topic'],env('MEETING_NAME', '')) !== false){
               
        //         $r=array_add($r,$count,$data['meetings'][$i]);
        //         $count++;
             
        //     }

        // }
        
       
       
        
        
        
            
        $zoom= ZoomMeetings::all();
        return view('zoom.index',compact('zoom'));
        }else{
            return redirect('/');
        }
        

    }

    public function update(Request $request)
    {
        $matchThese = ['start_time' => $request->time, 'phone' => $request->phone];
        $zoom2= ZoomMeetings::where($matchThese)->get();
        //$zoom2= ZoomMeetings::where('start_time','=',$request->time)->get();
        
        $id=($zoom2[0]->id);
        $upzoom= ZoomMeetings::find($id);
        $upzoom->start_time=$request->time2;
        $upzoom->save();
        return redirect()->back();
    }
    public function store(Request $request)
    {   
        $todate = date('Y-m-d H:i:s');
        $meeting_dates= ZoomMeetings::all();
     
        
        foreach ($meeting_dates as $key) {
            if(strtotime($key->start_time)<strtotime($todate)){
                
               ZoomMeetings::find($key->id)->delete();
            }
        }
        


        $sms= new SMSController();

        $meeting=new ZoomMeetings();
        $meeting->topic="Doctor Appointment";
        $meeting->start_time=$request->date;
        $meeting->phone=$request->code.$request->phone;
        
        $res=$this->create([
            'topic'      => "Doctor Appointment",
            'start_time' => $meeting->start_time,
            'host_video' => 1,
            'participant_video' => 1,
        ]);

        $meeting->url=$res['data']['join_url'];
        $meeting->start_url=$res['data']['start_url'];
        $meeting->save();
        
        $sms->sendSMS($meeting->phone,$meeting->url,$meeting->start_time);

        
        

        $url=$res['data']['join_url'];

        return redirect()->back()->with('meeting-success','Meeting Created Successfully');
    }
}
